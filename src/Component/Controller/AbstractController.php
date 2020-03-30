<?php 
namespace Dragon\Component\Controller;

use Dragon\Component\Directory\Directory;

abstract class AbstractController 
{
    protected function render(string $template, array $params=array())
    {
        $themes_dir     = Directory::DIRECTORY_THEMES;
        $theme_name     = getApp()->config()->getConfig('theme');
        $theme_dir      = $themes_dir.$theme_name;

        $loader = new \Twig\Loader\FilesystemLoader($theme_dir);
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        echo $twig->render($template, $params);
        exit;
    }

    /**
     * Make an HTTP Redirect
     *
     * @param string $uri
     * @return void
     */
    public function redirect(string $uri)
    {
        header("location: $uri");
        exit;
    }

    /**
     * Make an HTTP Redirect by a route name
     *
     * @param string $routeName
     * @param array $params
     * @return void
     */
    public function redirectToRoute(string $routeName, array $params=array())
    {
        $uri = ""; // TODO: Make redirect to route
        $this->redirect($uri);
    }

    /**
     * Generate URL by the route name
     *
     * @param string $routeName
     * @param array $params
     * @param boolean $absolute
     * @return void
     */
    public function generateUrl(string $routeName, array $params=array(), bool $absolute=false)
    {
        $app    = getApp();
        $router = $app->routing()->getRouter();
        $url    = $router->generate($routeName, $params);

        if ($absolute)
        {
            $u = \League\Url\Url::createFromServer($_SERVER);
            $url = $u->getBaseUrl() . $url;
        }

        return $url;
    }
}