<?php


namespace app\core;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\RuntimeLoaderInterface;


/**
 * Class Controller
 * @package core
 */
class Controller
{

//    public string $layout = 'base';
//
//    /**
//     * sets the layout, by default it is base.html.twig
//     * @param String $layout
//     */
//    public function setLayout(string $layout): void
//    {
//        $this->layout = $layout;
//    }

	/**
	 * @param $view
	 * @param array $params
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function render($view, $params = []): string
	{
		$loader = new FilesystemLoader("../views");
        $twig = new Environment($loader,  [
            'debug' => true,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addExtension(new DebugExtension());
		$twig->addExtension(new MarkdownExtension());

		$twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
			public function load($class): MarkdownRuntime
			{
				if (MarkdownRuntime::class === $class) {
					return new MarkdownRuntime(new DefaultMarkdown());
				}
			}
		});

        return $twig->render($view, $params);
    }

    /**
     * @param string $path
     */
    public function redirect(string $path): void
    {
        Application::$app->router->redirect($path);
    }

    public function adminCheck(): bool
    {
        $pdo = Application::$app->db->pdo;
        if(isset($_SESSION['user'])) {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE name=?");
            $stmt->execute(array($_SESSION['user']['name']));
            $result = $stmt->fetch();

            if($result['roles'] === 'ROLE_ADMIN') {
                return true;
            } else {
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }
    }
}
