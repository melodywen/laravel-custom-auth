<?php

namespace MelodyWen\LaravelCustomAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use MelodyWen\LaravelCustomAuth\Exceptions\RuntimeException;

/**
 * Class CustomUserProvider
 * 对使用到的函数进行再次重写
 * @package MelodyWen\LaravelCustomAuth
 */
class CustomUserProvider implements UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws RuntimeException
     */
    public function retrieveById($identifier)
    {
        throw new RuntimeException('请重写此函数');
        // TODO: Implement retrieveById() method.
        $user = $this->conn->table($this->table)->find($identifier);

        return $this->getGenericUser($user);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws RuntimeException
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
        throw new RuntimeException('请重写此函数');

        $user = $this->getGenericUser(
            $this->conn->table($this->table)->find($identifier)
        );

        return $user && $user->getRememberToken() && hash_equals($user->getRememberToken(), $token)
            ? $user : null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     * @throws RuntimeException
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
        throw new RuntimeException('请重写此函数');

        $this->conn->table($this->table)
            ->where($user->getAuthIdentifierName(), $user->getAuthIdentifier())
            ->update([$user->getRememberTokenName() => $token]);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @throws RuntimeException
     */
    public function retrieveByCredentials(array $credentials)
    {
        throw new RuntimeException('请重写此函数');
        // TODO: Implement retrieveByCredentials() method.
        if (empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists('password', $credentials))) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // generic "user" object that will be utilized by the Guard instances.
        $query = $this->conn->table($this->table);

        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'password')) {
                $query->where($key, $value);
            }
        }

        // Now we are ready to execute the query to see if we have an user matching
        // the given credentials. If not, we will just return nulls and indicate
        // that there are no matching users for these given credential arrays.
        $user = $query->first();

        return $this->getGenericUser($user);
    }

    /**
     * Get the generic user.
     *
     * @param  mixed  $user
     * @return \Illuminate\Auth\GenericUser|null
     */
    protected function getGenericUser($user)
    {
        if (! is_null($user)) {
            return new CustomGenericUser((array) $user);
        }
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     * @throws RuntimeException
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        throw new RuntimeException('请重写此函数');
        // TODO: Implement validateCredentials() method.
        return $this->hasher->check(
            $credentials['password'], $user->getAuthPassword()
        );
    }
}