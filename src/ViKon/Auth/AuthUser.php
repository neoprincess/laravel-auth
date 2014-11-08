<?php


namespace ViKon\Auth;

use Illuminate\Auth\Guard;
use ViKon\Auth\models\User;

/**
 * Class AuthUser
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Auth
 */
class AuthUser
{

    /**
     * @var null|\ViKon\Auth\models\User
     */
    private $user = null;
    /**
     * @var array
     */
    private $roles = [];

    /**
     * Create AuthUser instance
     * @param \Illuminate\Auth\Guard $guard
     */
    public function __construct(Guard $guard)
    {
        if ($guard->check())
        {
            $this->user = $guard->getUser();
            if (!$this->user instanceof User)
            {
                $this->user = null;
                logger('User is not instance of "ViKon\Auth\models\User"');

                return;
            }
            $roles  = $this->user->roles;
            $groups = $this->user->groups;

            foreach ($roles as $role)
            {
                $this->roles[] = $role->name;
            }

            foreach ($groups as $group)
            {
                $roles = $group->roles();
                foreach ($roles->get() as $role)
                {
                    $this->roles[] = $role->name;
                }
            }
            $this->roles = array_unique($this->roles);
        }
    }

    /**
     * Check if current user has all roles passed as parameter
     *
     * @param array|string $roles roles name array
     *
     * @return bool
     */
    public function hasRoles($roles)
    {
        if (func_num_args() > 1)
        {
            $roles = func_get_args();
        }

        if (!is_array($roles))
        {
            return $this->hasRole($roles);
        }

        // Count roles because user need to have all roles passed as parameter
        return count(array_intersect($roles, $this->roles)) === count($roles);
    }

    /**
     * Check if current user has single role
     *
     * @param string $role role name
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array((string) $role, $this->roles);
    }

    /**
     * Get current user instance
     *
     * @return null|\ViKon\Auth\models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get current user id
     *
     * @return int|null
     */
    public function getUserId()
    {
        return $this->user === null ? null : $this->user->id;
    }

    /**
     * Return if current user is blocked
     *
     * @return bool
     */
    public function isBlocked()
    {
        return $this->user !== null && $this->user->blocked;
    }
}