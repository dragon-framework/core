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
    public function hasRoles($roles): bool
    {
        if (!is_array($roles))
        {
            $roles = [$roles];
        }

        // Retrieve users roles
        $usersRoles = [];
        // ...

        // Check if $roles in array $usersRoles
        // ...

        return false;
    }
    
}