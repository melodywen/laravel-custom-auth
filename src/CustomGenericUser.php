<?php

namespace MelodyWen\LaravelCustomAuth;

use Illuminate\Auth\GenericUser;

/**
 * Class CustomGenericUser
 *  note ：对 GenericUser 再次的封装
 * @package MelodyWen\LaravelCustomAuthS
 */
class CustomGenericUser extends GenericUser
{

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }
}