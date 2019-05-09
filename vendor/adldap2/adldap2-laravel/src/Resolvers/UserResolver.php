<?php

namespace Adldap\Laravel\Resolvers;

use Adldap\Models\User;
use Adldap\Query\Builder;
use Adldap\AdldapInterface;
use Adldap\Connections\ProviderInterface;
use Adldap\Laravel\Events\Authenticated;
use Adldap\Laravel\Events\Authenticating;
use Adldap\Laravel\Events\AuthenticationFailed;
use Adldap\Laravel\Auth\NoDatabaseUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class UserResolver implements ResolverInterface
{
    /**
     * The Adldap instance.
     *
     * @var AdldapInterface
     */
    protected $ldap;

    /**
     * The name of the LDAP connection to utilize.
     *
     * @var string
     */
    protected $connection = 'default';

    /**
     * {@inheritdoc}
     */
    public function __construct(AdldapInterface $ldap)
    {
        $this->ldap = $ldap;

        $this->setConnection($this->getLdapAuthConnectionName());
    }

    /**
     * {@inheritdoc}
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function byId($identifier)
    {
        return $this->query()->findByGuid($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function byCredentials(array $credentials = [])
    {
        if (empty($credentials)) {
            return;
        }

        // Depending on the configured user provider, the
        // username field will differ for retrieving
        // users by their credentials.
        if ($this->getAppAuthProvider() instanceof NoDatabaseUserProvider) {
            $username = $credentials[$this->getLdapDiscoveryAttribute()];
        } else {
            $username = $credentials[$this->getEloquentUsernameAttribute()];
        }

        $field = $this->getLdapDiscoveryAttribute();

        return $this->query()->whereEquals($field, $username)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function byModel(Authenticatable $model)
    {
        $field = $this->getLdapDiscoveryAttribute();

        $username = $model->{$this->getEloquentUsernameAttribute()};

        return $this->query()->whereEquals($field, $username)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(User $user, array $credentials = [])
    {
        $attribute = $this->getLdapAuthAttribute();

        // If the developer has inserted 'dn' as their LDAP
        // authentication attribute, we'll convert it to
        // the full attribute name for convenience.
        if ($attribute == 'dn') {
            $attribute = $user->getSchema()->distinguishedName();
        }

        $username = $user->getFirstAttribute($attribute);

        $password = $this->getPasswordFromCredentials($credentials);

        event(new Authenticating($user, $username));

        if ($this->getLdapAuthProvider()->auth()->attempt($username, $password)) {
            event(new Authenticated($user));

            return true;
        }

        event(new AuthenticationFailed($user));

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function query() : Builder
    {
        $query = $this->getLdapAuthProvider()->search()->users();

        $scopes = Config::get('ldap_auth.scopes', []);

        if (is_array($scopes)) {
            foreach ($scopes as $scope) {
                // Here we will use Laravel's IoC container to construct our scope.
                // This allows us to utilize any Laravel dependencies in
                // the scopes constructor that may be needed.

                /** @var \Adldap\Laravel\Scopes\ScopeInterface $scope */
                $scope = app($scope);

                // With the scope constructed, we can apply it to our query.
                $scope->apply($query);
            }
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getLdapDiscoveryAttribute() : string
    {
        return Config::get('ldap_auth.usernames.ldap.discover', 'userprincipalname');
    }

    /**
     * {@inheritdoc}
     */
    public function getLdapAuthAttribute() : string
    {
        return Config::get('ldap_auth.usernames.ldap.authenticate', 'distinguishedname');
    }

    /**
     * {@inheritdoc}
     */
    public function getEloquentUsernameAttribute() : string
    {
        return Config::get('ldap_auth.usernames.eloquent', 'email');
    }

    /**
     * Returns the password field to retrieve from the credentials.
     *
     * @param array $credentials
     *
     * @return string|null
     */
    protected function getPasswordFromCredentials($credentials)
    {
        return array_get($credentials, 'password');
    }

    /**
     * Retrieves the provider for the current connection.
     *
     * @throws \Adldap\AdldapException
     *
     * @return ProviderInterface
     */
    protected function getLdapAuthProvider() : ProviderInterface
    {
        return $this->ldap->getProvider($this->connection);
    }

    /**
     * Returns the default guards provider instance.
     *
     * @return UserProvider
     */
    protected function getAppAuthProvider() : UserProvider
    {
        return Auth::guard()->getProvider();
    }

    /**
     * Returns the connection name of the authentication provider.
     *
     * @return string
     */
    protected function getLdapAuthConnectionName()
    {
        return Config::get('ldap_auth.connection', 'default');
    }
}
