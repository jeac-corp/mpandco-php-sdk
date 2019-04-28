<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
// To suppress the warning during the date() invocation in logs, we would default the timezone to GMT.
if (!ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
}
// Include the composer autoloader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
$loader->addPsr4('JeacCorp\\Test\\', __DIR__);
if (!defined("PP_CONFIG_PATH")) {
    define("PP_CONFIG_PATH", __DIR__);
}

// Remplazar los valores por tus propias llaves generadas en ClientId and SecretId visitando https://test.mpandco.com/s/samp/client/oauth/
$clientId = '1_id_8217d6084e785f4448dd4c75aabe5d81';
$clientSecret = 'secret_a8f5f167f44f4964e6c998dee827110c';

/** @var JeacCorp\Mpandco\Rest\Client $apiContext */
//$apiContext = getApiContext($clientId, $clientSecret);