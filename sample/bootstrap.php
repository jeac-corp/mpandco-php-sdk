<?php
/*
 * Sample bootstrap file.
 */

// Include the composer Autoloader
// The location of your project's vendor autoloader.
$composerAutoload = dirname(dirname(dirname(__DIR__))) . '/autoload.php';
if (!file_exists($composerAutoload)) {
    //If the project is used as its own project, it would use rest-api-sdk-php composer autoloader.
    $composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';


    if (!file_exists($composerAutoload)) {
        echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
        exit(1);
    }
}
require $composerAutoload;
require __DIR__ . '/common.php';


// Suppress DateTime warnings, if not set already
date_default_timezone_set(@date_default_timezone_get());

// Adding Error Reporting for understanding errors properly
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Replace these values by entering your own ClientId and Secret by visiting https://test.mpandco.com/s/samp/client/oauth/
$clientId = '1_id_8217d6084e785f4448dd4c75aabe5d81';
$clientSecret = 'secret_a8f5f167f44f4964e6c998dee827110c';

/** @var JeacCorp\Mpandco\Rest\ApiContext $apiContext */
$apiContext = new JeacCorp\Mpandco\Rest\ApiContext([
    "clientId" => $clientId,
    "clientSecret" => $clientSecret,
    "mode" => "sandbox",
]);

ResultPrinter::$apiContext = $apiContext;