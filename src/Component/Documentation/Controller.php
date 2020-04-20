<?php 
namespace Dragon\Component\Documentation;

use Dragon\Component\Controller\AbstractController;
use Dragon\Component\Directory\Directory;
use Michelf\MarkdownExtra;

class Controller extends AbstractController
{
    public function index()
    {
        return $this->render("doc/index.html", [
            'sections' => $this->getSections()
        ]);
    }

    public function section(string $section, string $md5)
    {
        return $this->render("doc/section.html", [
            'sections' => $this->getSections(),
            'section' => $this->getSection($md5)
        ]);
    }

    public function examples()
    {
        return $this->render("doc/examples.html", [
            'sections' => $this->getSections(),
            'examples' => [
                [
                    "title" => "The App",
                    "articles" => [
                        [
                            'name' => "App Methods",
                            'description' => "Acces to public methods and confi settigs.",
                            'code' => "getApp();",
                            'result' => null,
                        ],
                    ]
                ],
                [
                    "title" => "Get config by sections",
                    "articles" => [
                        [
                            'name' => "Global config",
                            'code' => "getApp()->config();\ngetApp()->database();\ngetApp()->mailer();\ngetApp()->routing();\ngetApp()->security();",
                        ],
                    ]
                ],
                [
                    "title" => "Get global config parameters",
                    "articles" => [
                        [
                            'name' => "Website title",
                            'code' => "getApp()->config()->get('title');",
                            'result' => getApp()->config()->get('title'),
                        ],
                        [
                            'name' => "Activate PHP Session",
                            'code' => "getApp()->config()->get('session');",
                            'result' => getApp()->config()->get('session'),
                        ],
                        [
                            'name' => "Execution environment",
                            'code' => "getApp()->config()->get('environment');",
                            'result' => getApp()->config()->get('environment'),
                        ],
                    ]
                ],
                [
                    "title" => "Security authentication parameters",
                    "articles" => [
                        [
                            'name' => "Is Authentication activated",
                            'code' => "getApp()->security()->get('authentication');",
                            'result' => getApp()->security()->get('authentication'),
                        ],
                        [
                            'name' => "Authentication strategy",
                            'code' => "getApp()->security()->get('strategy');",
                            'result' => getApp()->security()->get('strategy'),
                        ],
                        [
                            'name' => "Authentication property name",
                            'description' => "Database field used to search user",
                            'code' => "getApp()->security()->get('authentication_property');",
                            'result' => getApp()->security()->get('authentication_property'),
                        ],
                    ]
                ],
                [
                    "title" => "Security registration parameters",
                    "articles" => [
                        [
                            'name' => "Is registration allowed",
                            'description' => "Everybody can create new account",
                            'code' => "getApp()->security()->get('registration_allowed');",
                            'result' => getApp()->security()->get('registration_allowed'),
                        ],
                        [
                            'name' => "Default roles for new user",
                            'code' => "getApp()->security()->get('registration_default_roles');",
                            'result' => print_r(getApp()->security()->get('registration_default_roles'), true),
                        ],
                        [
                            'name' => "Automaticaly authenticate on registration",
                            'code' => "getApp()->security()->get('authentication_on_registration');",
                            'result' => getApp()->security()->get('authentication_on_registration'),
                        ],
                    ]
                ],
                [
                    "title" => "Redirection strategy (after security events)",
                    "articles" => [
                        [
                            'name' => "Redirect after registration",
                            'code' => "getApp()->security()->get('redirect_on_registration');",
                            'result' => getApp()->security()->get('redirect_on_registration'),
                        ],
                        [
                            'name' => "Redirect after login",
                            'code' => "getApp()->security()->get('redirect_on_login');",
                            'result' => getApp()->security()->get('redirect_on_login'),
                        ],
                        [
                            'name' => "Redirect after logout",
                            'code' => "getApp()->security()->get('redirect_on_logout');",
                            'result' => getApp()->security()->get('redirect_on_logout'),
                        ],
                        [
                            'name' => "Redirect after activation",
                            'code' => "getApp()->security()->get('redirect_on_activation');",
                            'result' => getApp()->security()->get('redirect_on_activation'),
                        ],
                    ]
                ],
                [
                    "title" => "Account activation strategy",
                    "articles" => [
                        [
                            'name' => "Account activation",
                            'description' => "User need to active his account.",
                            'code' => "getApp()->security()->get('activation');",
                            'result' => getApp()->security()->get('activation'),
                        ],
                        [
                            'name' => "Account activation delay",
                            'description' => "Delay (in minute) before user need to activate his account before use the app.",
                            'code' => "getApp()->security()->get('activation_delayed');",
                            'result' => getApp()->security()->get('activation_delayed'),
                        ],
                    ]
                ],
                [
                    "title" => "Password strategy",
                    "articles" => [
                        [
                            'name' => "Password length",
                            'code' => "getApp()->security()->get('password_min_lenght');",
                            'result' => getApp()->security()->get('password_min_lenght'),
                        ],
                        [
                            'name' => "Password encoder",
                            'code' => "getApp()->security()->get('password_encoder');",
                            'result' => getApp()->security()->get('password_encoder'),
                        ],
                    ]
                ],
                [
                    "title" => "Token strategy",
                    "articles" => [
                        [
                            'name' => "Authentication token expiration delay",
                            'code' => "getApp()->security()->get('authentication_token_expiration');",
                            'result' => getApp()->security()->get('authentication_token_expiration'),
                        ],
                        [
                            'name' => "Activation token expiration delay",
                            'code' => "getApp()->security()->get('activation_token_expiration');",
                            'result' => getApp()->security()->get('activation_token_expiration'),
                        ],
                    ]
                ],
                [
                    "title" => "Mailer Server",
                    "articles" => [
                        [
                            'name' => "Mailer transport",
                            'code' => "getApp()->mailer()->get('transport');",
                            'result' => getApp()->mailer()->get('transport'),
                        ],
                        [
                            'name' => "Mailer authentication",
                            'code' => "getApp()->mailer()->get('auth');",
                            'result' => getApp()->mailer()->get('auth'),
                        ],
                        [
                            'name' => "Mailer tls",
                            'code' => "getApp()->mailer()->get('tls');",
                            'result' => getApp()->mailer()->get('tls'),
                        ],
                        [
                            'name' => "Mailer host",
                            'code' => "getApp()->mailer()->get('host');",
                            'result' => getApp()->mailer()->get('host'),
                        ],
                        [
                            'name' => "Mailer username",
                            'code' => "getApp()->mailer()->get('username');",
                            'result' => getApp()->mailer()->get('username'),
                        ],
                        [
                            'name' => "Mailer password",
                            'code' => "getApp()->mailer()->get('password');",
                            'result' => getApp()->mailer()->get('password'),
                        ],
                        [
                            'name' => "Mailer port",
                            'code' => "getApp()->mailer()->get('port');",
                            'result' => getApp()->mailer()->get('port'),
                        ],
                    ]
                ],
                [
                    "title" => "Mailer Sender",
                    "articles" => [
                        [
                            'name' => "Sender array",
                            'code' => "getApp()->mailer()->get('sender');",
                            'result' => print_r(getApp()->mailer()->get('sender'), true),
                        ],
                        [
                            'name' => "Sender address",
                            'code' => "getApp()->mailer()->get('sender_address');",
                            'result' => getApp()->mailer()->get('sender_address'),
                        ],
                        [
                            'name' => "Sender name",
                            'code' => "getApp()->mailer()->get('sender_name');",
                            'result' => getApp()->mailer()->get('sender_name'),
                        ],
                    ]
                ],
                [
                    "title" => "Mailer noreply",
                    "articles" => [
                        [
                            'name' => "No replay address",
                            'code' => "getApp()->mailer()->get('noreply');",
                            'result' => print_r(getApp()->mailer()->get('noreply'), true),
                        ],
                    ]
                ],
                [
                    "title" => "Request Methods",
                    "articles" => [
                        [
                            'name' => "Base url of the request",
                            'code' => "\$this->request()->base();",
                            'result' => $this->request()->base(),
                        ],
                        [
                            'name' => "Host name of the request",
                            'code' => "\$this->request()->hostname();",
                            'result' => $this->request()->hostname(),
                        ],
                        [
                            'name' => "Port of the request",
                            'code' => "\$this->request()->port();",
                            'result' => $this->request()->port(),
                        ],
                        [
                            'name' => "URI of the request",
                            'code' => "\$this->request()->uri();",
                            'result' => $this->request()->uri(),
                        ],
                        [
                            'name' => "Path section of the URI",
                            'code' => "\$this->request()->path();",
                            'result' => $this->request()->path(),
                        ],
                        [
                            'name' => "Scheme section of the URI",
                            'code' => "\$this->request()->scheme();",
                            'result' => $this->request()->scheme(),
                        ],
                        [
                            'name' => "HTTP Method",
                            'code' => "\$this->request()->method();",
                            'result' => $this->request()->method(),
                        ],
                        [
                            'name' => "HTTP Method is GET",
                            'code' => "\$this->request()->isGet();",
                            'result' => $this->request()->isGet(),
                        ],
                        [
                            'name' => "HTTP Method is POST",
                            'code' => "\$this->request()->isPost();",
                            'result' => $this->request()->isPost(),
                        ],
                        [
                            'name' => "User Agent",
                            'code' => "\$this->request()->agent();",
                            'result' => $this->request()->agent(),
                        ],
                        [
                            'name' => "Referer",
                            'code' => "\$this->request()->referer();",
                            'result' => $this->request()->referer(),
                        ],
                    ]
                ],
                [
                    "title" => "Request data",
                    "articles" => [
                        [
                            'name' => "Find parameters \"email\" of GET request",
                            'code' => "\$this->request()->query()->get('email');",
                            'result' => $this->request()->query()->get('email'),
                        ],
                        [
                            'name' => "Find parameters \"email\" of POST request",
                            'code' => "\$this->request()->request()->get('email');",
                            'result' => $this->request()->request()->get('email'),
                        ],
                    ]
                ],
            ],
        ]);
    }


    private function getSections(): array
    {
        $regex_md = "/\.md$/";
        $doc_files = scandir(Directory::DIRECTORY_DOC);
        $doc_sections = [];

        foreach ($doc_files as $key => $file)
        {
            if (preg_match($regex_md, $file))
            {
                $label = preg_replace($regex_md, null, $file);
                $path  = strtolower($label);
                $md5   = md5($path);

                array_push($doc_sections, [
                    'path'  => $path,
                    'md5'   => $md5,
                    'label' => $label,
                ]);
            }
        }

        return $doc_sections;
    }

    private function getSection(string $md5)
    {
        $regex_md = "/\.md$/";
        $doc_files = scandir(Directory::DIRECTORY_DOC);

        foreach ($doc_files as $file)
        {
            $label = preg_replace($regex_md, null, $file);
            $path  = strtolower($label);

            switch (true)
            {
                case $md5 == md5($path):
                    $test = Directory::DIRECTORY_DOC."/".$file;
                    $md = file_get_contents($test);
                    return MarkdownExtra::defaultTransform($md);
            }
        }
        
        return null;
    }
}
