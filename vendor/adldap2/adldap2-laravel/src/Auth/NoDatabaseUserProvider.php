<?php

namespace Adldap\Laravel\Auth;

use Adldap\Laravel\Facades\Resolver;
use Adldap\Laravel\Events\AuthenticationRejected;
use Adldap\Laravel\Events\AuthenticationSuccessful;
use Adldap\Laravel\Events\DiscoveredWithCredentials;
use Adldap\Laravel\Events\AuthenticatedWithCredentials;
use Illuminate\Contracts\Auth\Authenticatable;

class NoDatabaseUserProvider extends Provider
{
    /**
     *  {@inheritdoc}
     */
    public function retrieveById($identifier)
    {
        $user = Resolver::byId($identifier);

        // We'll verify we have the correct instance just to ensure we
        // don't return an incompatible model that may be returned.
        return $user instanceof Authenticatable ? $user : null;
    }

    /**
     *  {@inheritdoc}
     */
    public function retrieveByToken($identifier, $token)
    {
        return;
    }

    /**
     *  {@inheritdoc}
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        //
    }

    /**
     *  {@inheritdoc}
     */
    public function retrieveByCredentials(array $credentials)
    {
        if ($user = Resolver::byCredentials($credentials)) {
            event(new DiscoveredWithCredentials($user));

            return $user;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (Resolver::authenticate($user, $credentials)) {
            event(new AuthenticatedWithCredentials($user));

            if ($this->passesValidation($user)) {
                event(new AuthenticationSuccessful($user));

                return true;
            }

            event(new AuthenticationRejected($user));
        }

        return false;
    }
}
