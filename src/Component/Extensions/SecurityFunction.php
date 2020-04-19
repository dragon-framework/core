<?php 
namespace Dragon\Component\Extensions;

class SecurityFunction
{
    public function getFunctions(): array
    {
        return [
            'user',
            'isAnonymous',
            'isAutheticated',
            'hasRoles',
        ];
    }

    /**
     * Return user data or empty array
     *
     * @return array
     */
    public function user()
    {
        return getApp()->security()->user();
    }

    /**
     * Return true if user is not authenticated
     *
     * @return boolean
     */
    public function isAnonymous(): bool
    {
        return getApp()->security()->isAnonymous();
    }

    /**
     * Return true if user is authenticated
     *
     * @return boolean
     */
    public function isAuthenticated(): bool
    {
        return getApp()->security()->isAuthenticated();
    }

    /**
     * Return true if user has role defined in $roles
     *
     * @param string|array $roles
     * @return boolean
     */
    public function hasRoles($roles): bool
    {
        return getApp()->security()->hasRoles($roles);
    }
}