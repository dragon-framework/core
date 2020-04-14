<?php
namespace Dragon\Component\Views;

use Dragon\Component\Directory\Directory;

class Render
{
    const REGEX_EXTENSIONS_TYPE = "/(Function|Filter)\.php$/";

    private $themeDirectory;
    private $engine;

    public function __construct()
    {
        $this->setEngine();
        $this->loadExtensions();
    }

    private function setEngine(): self
    {
        $loader = new \Twig\Loader\FilesystemLoader( Directory::DIRECTORY_APP_TEMPLATES );

        $this->engine = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        return $this;
    }

    private function loadExtensions(): self
    {
        $extLoaders = [[
            'dir' => Directory::DIRECTORY_APP_EXTENSIONS,
            'namespace' => "App\\Extensions\\"
        ],[
            'dir' => Directory::DIRECTORY_CORE_EXTENSIONS,
            'namespace' => "Dragon\\Component\\Extensions\\"
        ]];

        foreach ($extLoaders as $extLoader)
        {
            if (is_dir( $extLoader['dir'] ))
            {
                foreach (\scandir( $extLoader['dir'] ) as $entry)
                {
                    if (preg_match(self::REGEX_EXTENSIONS_TYPE, $entry, $type))
                    {
                        $type       = strtolower($type[1]);
                        $className  = preg_replace("/\.php$/", null, $entry);
                        $className  = $extLoader['namespace'].$className;
    
                        $extension  = new $className;
    
                        foreach ($extension->getFunctions() as $method)
                        {
                            $callable = new \Twig\TwigFunction($method, [$extension, $method]);
    
                            switch ($type)
                            {
                                case 'function':
                                    $this->engine->addFunction( $callable );
                                    break;
                            }
                        }
                    }
                }
            }
        }

        return $this;
    }

    public function render(string $template, array $params=array())
    {
        return $this->engine->render($template, $params);
    }
}
