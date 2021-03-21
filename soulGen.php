<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$contentDir = __DIR__ . '/doc/markdown';
$contentFiles = array_diff(scandir($contentDir), array('.', '..'));

$loader = new FilesystemLoader(__DIR__ . '/doc/static');
$twig = new Environment($loader);
$parsed = new Parsedown();

$asideNav = $contentFiles;
$data["pages"] = $asideNav;

$index = $twig->render('base.html.twig', $data);

file_put_contents(__DIR__ . '/public/docs/index.html', $index);
echo "BUILT index.html" . PHP_EOL;

foreach ($contentFiles as $file) {
    $data["HTML"] = $parsed->parse(file_get_contents($contentDir . '/' . $file));

    $contentBase = $twig->render('base.html.twig', $data);

    $outputDir = __DIR__ . '/public/docs';

    $outputPath = $outputDir . '/' . basename($file, '.md') . '.html';
    file_put_contents($outputPath, html_entity_decode($contentBase));

    echo "BUILT " . $file . PHP_EOL;
}
