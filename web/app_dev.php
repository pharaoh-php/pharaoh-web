<?php

$env   = getenv('SYMFONY_ENV')   ?: 'dev';
$debug = getenv('SYMFONY_DEBUG') ? true : false;
$debug = false === $debug ? true : (bool) $debug;

putenv(sprintf('SYMFONY_ENV=%s', $env));
putenv(sprintf('SYMFONY_DEBUG=%d', (int) $debug));

require 'app.php';
