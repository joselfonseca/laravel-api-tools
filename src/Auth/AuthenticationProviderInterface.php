<?php

namespace Joselfonseca\LaravelApiTools\Auth;

/**
 *
 * @author josefonseca
 */
interface AuthenticationProviderInterface
{
    public function authenticate();

    public function getAuthenticatedUser();
}