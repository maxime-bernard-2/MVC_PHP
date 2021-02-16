<?php


namespace app\core;

use Twig\Environment;
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
		$twig = new Environment($loader);
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
}