<?php
namespace Dragon\Component\Extensions;

class RoutesFunction
{
    private $routing;
    private $router;

    public function __construct()
    {
        $this->routing = getApp()->routing();
        $this->router = $this->routing->get('router');
    }

    public function getFunctions(): array
    {
        return [
            'url',
            'isRouteActive'
        ];
    }

    /**
     * Generate URL form route name
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    public function url(string $name, array $params=[]): string
    {
        return $this->router->generate($name, $params);
    }

    /**
     * Return true if the route $name is active
     *
     * @param string $name
     * @return boolean
     */
    public function isRouteActive(string $name): bool
    {
        return $this->routing->isActive($name);
    }
}