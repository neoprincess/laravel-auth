<?php

namespace ViKon\Auth;

/**
 * Class Guard
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Auth
 */
class Guard extends \Illuminate\Auth\Guard
{
    /**
     * {@inheritDoc}
     */
    public function attempt(array $credentials = [], $remember = false, $login = true)
    {
        if (!array_key_exists('package', $credentials)) {
            $credentials['package'] = 'system';
        }

        return parent::attempt($credentials, $remember, $login);
    }

}