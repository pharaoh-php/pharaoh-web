<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../kernel/autoload.php';

$env   = getenv('SYMFONY_ENV')   ?: 'staging';
$debug = getenv('SYMFONY_DEBUG') ? true : false;

if ($debug && class_exists('Symfony\Component\Debug\Debug')) {
    Debug::Enable();
}

if ('prod' === $env) {
    include_once __DIR__.'/../var/bootstrap.php.cache';

    /*
    $apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
    $loader->unregister();
    $apcLoader->register(true);
    */
}

$kernel = new PharaohKernel($env, $debug);
$kernel->loadClassCache();

if ('prod' === $env) {
    $kernel = new PharaohCache($kernel);
}

Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
