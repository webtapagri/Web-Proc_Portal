<?php

namespace Adldap\Laravel\Tests;

use Adldap\Models\User;
use Adldap\AdldapInterface;
use Adldap\Laravel\Commands\Import;
use Adldap\Laravel\Facades\Resolver;
use Adldap\Laravel\Tests\Scopes\JohnDoeScope;
use Adldap\Laravel\Tests\Models\TestUser as EloquentUser;
use Adldap\Laravel\Tests\Handlers\LdapAttributeHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DatabaseProviderTest extends DatabaseTestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function configuration_not_found_exception_when_config_is_null()
    {
        config(['ldap' => null]);

        App::make(AdldapInterface::class);
    }

    /** @test */
    public function adldap_is_bound_to_interface()
    {
        $adldap = App::make(AdldapInterface::class);

        $this->assertInstanceOf(AdldapInterface::class, $adldap);
    }

    /** @test */
    public function auth_passes($credentials = null)
    {
        $credentials = $credentials ?: ['email' => 'jdoe@email.com', 'password' => '12345'];

        $user = $this->makeLdapUser([
            'cn'    => 'John Doe',
            'userprincipalname'  => 'jdoe@email.com',
        ]);

        Resolver::shouldReceive('byModel')->once()->andReturn($user)
            ->shouldReceive('byCredentials')->once()->andReturn($user)
            ->shouldReceive('authenticate')->once()->andReturn(true);

        $this->assertTrue(Auth::attempt($credentials));
        $this->assertInstanceOf(EloquentUser::class, Auth::user());
        $this->assertInstanceOf(User::class, Auth::user()->ldap);
    }

    /** @test */
    public function auth_fails_when_user_found()
    {
        $user = $this->makeLdapUser([
            'cn'    => 'John Doe',
            'userprincipalname'  => 'jdoe@email.com',
        ]);

        Resolver::shouldReceive('byCredentials')->once()->andReturn($user)
            ->shouldReceive('authenticate')->once()->andReturn(false);

        $this->assertFalse(Auth::attempt(['email' => 'jdoe@email.com', 'password' => '12345']));
    }

    /** @test */
    public function auth_fails_when_user_not_found()
    {
        Resolver::shouldReceive('byCredentials')->once()->andReturn(null);

        $this->assertFalse(Auth::attempt(['email' => 'jdoe@email.com', 'password' => '12345']));
    }

    /** @test */
    public function config_scopes_are_applied()
    {
        config(['ldap_auth.scopes' => [JohnDoeScope::class]]);

        $expectedFilter = '(&(objectclass=\75\73\65\72)(objectcategory=\70\65\72\73\6f\6e)(!(objectclass=\63\6f\6e\74\61\63\74))(cn=\4a\6f\68\6e\20\44\6f\65))';

        $this->assertEquals($expectedFilter, Resolver::query()->getQuery());
    }

    /** @test */
    public function attribute_handlers_are_used()
    {
        $default = config('ldap_auth.sync_attributes');

        config(['ldap_auth.sync_attributes' => array_merge($default, [LdapAttributeHandler::class])]);

        $this->auth_passes();

        $user = Auth::user();

        $this->assertEquals('handled', $user->name);
    }

    /** @test */
    public function invalid_attribute_handlers_does_not_throw_exception()
    {
        // Inserting an invalid attribute handler that
        // does not contain a `handle` method.
        config(['ldap_auth.sync_attributes' => [\stdClass::class]]);

        $user = $this->makeLdapUser([
            'cn'    => 'John Doe',
            'userprincipalname'  => 'jdoe@email.com',
        ]);

        $importer = new Import($user, new EloquentUser());

        $this->assertInstanceOf(EloquentUser::class, $importer->handle());
    }

    /** @test */
    public function sync_attribute_as_string_will_return_null()
    {
        config([
            'ldap_auth.sync_attributes' => [
                'email' => 'userprincipalname',
                'name' => 'cn',
            ]
        ]);

        // LDAP user does not have common name.
        $user = $this->makeLdapUser([
            'userprincipalname'  => 'jdoe@email.com',
        ]);

        $importer = new Import($user, new EloquentUser());

        $model = $importer->handle();

        $this->assertInstanceOf(EloquentUser::class, $model);
        $this->assertNull($model->name);
    }

    /** @test */
    public function sync_attribute_as_int_boolean_or_array_will_be_used()
    {
        config([
            'ldap_auth.sync_attributes' => [
                'email' => 'userprincipalname',
                'string' => 'not-an-LDAP-attribute',
                'int' => 1,
                'bool' => true,
                'array' => ['one', 'two']
            ]
        ]);

        // LDAP user does not have common name.
        $user = $this->makeLdapUser([
            'userprincipalname'  => 'jdoe@email.com',
        ]);

        $importer = new Import($user, new EloquentUser());

        $model = $importer->handle();

        $this->assertInstanceOf(EloquentUser::class, $model);
        $this->assertNull($model->string);
        $this->assertEquals($model->int, 1);
        $this->assertEquals($model->bool, true);
        $this->assertEquals($model->array, ['one', 'two']);
    }

    /** @test */
    public function auth_attempts_fallback_using_config_option()
    {
        config(['ldap_auth.login_fallback' => true]);

        EloquentUser::create([
            'email'    => 'jdoe@email.com',
            'name'     => 'John Doe',
            'password' => Hash::make('Password123'),
        ]);

        $credentials = [
            'email'    => 'jdoe@email.com',
            'password' => 'Password123',
        ];

        Resolver::shouldReceive('byCredentials')->times(3)->andReturn(null)
            ->shouldReceive('byModel')->times(2)->andReturn(null);

        $this->assertTrue(Auth::attempt($credentials));

        $this->assertFalse(Auth::attempt(
            array_replace($credentials, ['password' => 'Invalid'])
        ));

        config(['ldap_auth.login_fallback' => false]);

        $this->assertFalse(Auth::attempt($credentials));
    }

    /** @test */
    public function auth_attempts_using_fallback_does_not_require_connection()
    {
        config(['ldap_auth.login_fallback' => true]);

        EloquentUser::create([
            'email'    => 'jdoe@email.com',
            'name'     => 'John Doe',
            'password' => Hash::make('Password123'),
        ]);

        $credentials = [
            'email'    => 'jdoe@email.com',
            'password' => 'Password123',
        ];

        $this->assertTrue(Auth::attempt($credentials));

        $user = Auth::user();

        $this->assertInstanceOf('Adldap\Laravel\Tests\Models\TestUser', $user);
        $this->assertEquals('jdoe@email.com', $user->email);
    }

    /** @test */
    public function passwords_are_synced_when_enabled()
    {
        config(['ldap_auth.passwords.sync' => true]);

        $credentials = [
            'email' => 'jdoe@email.com',
            'password' => '12345',
        ];

        $this->auth_passes($credentials);

        $user = EloquentUser::first();

        // This check will pass due to password synchronization being enabled.
        $this->assertTrue(Hash::check($credentials['password'], $user->password));
    }

    /** @test */
    public function passwords_are_not_synced_when_sync_is_disabled()
    {
        config(['ldap_auth.passwords.sync' => false]);

        $credentials = [
            'email' => 'jdoe@email.com',
            'password' => '12345',
        ];

        $this->auth_passes($credentials);

        $user = EloquentUser::first();

        // This check will fail due to password synchronization being disabled.
        $this->assertFalse(Hash::check($credentials['password'], $user->password));
    }

    /** @test */
    public function passwords_are_not_updated_when_sync_is_disabled()
    {
        config(['ldap_auth.passwords.sync' => false]);

        $credentials = [
            'email' => 'jdoe@email.com',
            'password' => '12345',
        ];

        $this->auth_passes($credentials);

        $user = EloquentUser::first();

        $this->auth_passes($credentials);

        $this->assertEquals($user->password, $user->fresh()->password);
    }

    /** @test */
    public function trashed_rule_prevents_deleted_users_from_logging_in()
    {
        config([
            'ldap_auth.login_fallback' => false,
            'ldap_auth.rules' => [\Adldap\Laravel\Validation\Rules\DenyTrashed::class],
        ]);

        $credentials = [
            'email' => 'jdoe@email.com',
            'password' => '12345',
        ];

        $ldapUser = $this->makeLdapUser();

        Resolver::shouldReceive('byCredentials')->twice()->andReturn($ldapUser)
            ->shouldReceive('byModel')->once()->andReturn($ldapUser)
            ->shouldReceive('authenticate')->twice()->andReturn(true);

        $this->assertTrue(Auth::attempt($credentials));

        EloquentUser::first()->delete();

        $this->assertFalse(Auth::attempt($credentials));
    }

    /** @test */
    public function only_imported_users_are_allowed_to_authenticate_when_rule_is_applied()
    {
        config([
            'ldap_auth.login_fallback' => false,
            'ldap_auth.rules' => [\Adldap\Laravel\Validation\Rules\OnlyImported::class],
        ]);

        $credentials = [
            'email' => 'jdoe@email.com',
            'password' => '12345',
        ];

        Resolver::shouldReceive('byCredentials')->once()->andReturn($this->makeLdapUser())
            ->shouldReceive('authenticate')->once()->andReturn(true);

        $this->assertFalse(Auth::attempt($credentials));
    }

    /** @test */
    public function method_calls_are_passed_to_fallback_provider()
    {
        $this->assertEquals('Adldap\Laravel\Tests\Models\TestUser', Auth::getProvider()->getModel());
    }
}
