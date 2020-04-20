<?php 
namespace Dragon\Component\Security;

use Dragon\Component\Security\Definition;

class Builder 
{

    /**
     * Routes definition
     *
     * @var \Definition
     */
    private $definition;

    public function __construct()
    {
        $this->definition = new Definition;
    }


    // Bridge Methods
    // --
    
    /**
     * Get config value by the key
     *
     * @param string $key
     * @return void
     */
    public function get(string $key)
    {
        return $this->definition->get( $key );
    }

    /**
     * Return user data or empty array
     *
     * @return array
     */
    public function user(): array
    {
        $user = [];

        if (session_id())
        {
            $user = $_SESSION['user'] ?? [];
        }

        return $user;
    }

    /**
     * Return true if user is not authenticated
     *
     * @return boolean
     */
    public function isAnonymous(): bool
    {
        return empty($this->user());
    }

    /**
     * Return true if user is authenticated
     *
     * @return boolean
     */
    public function isAuthenticated(): bool
    {
        return !empty($this->user());
    }

    /**
     * Return true if user has role defined in $roles
     *
     * @param string|array $roles
     * @return boolean
     */
    public function hasRole(string $role): bool
    {
        $user = $this->user();
        
        return $this->checkRole($role, $user['roles'] ?? []);
    }

    /**
     * Check hierarchical role
     *
     * @param string $role
     * @param array $userRoles
     * @return boolean
     */
    private function checkRole(string $role, array $userRoles): bool
    {
        if (in_array($role, $userRoles) || $role == ROLE_ANONYMOUS)
        {
            return true;
        }

        if (!$parent = array_keys(ROLES_HIERARCHY, $role))
        {
            return false;
        }

        return $this->checkRole($parent[0] ?? $role, $userRoles);
    }
    
}