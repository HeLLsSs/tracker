<?php
include '../boot.php';
define( 'CITRUS_INDEX', basename( __FILE__ ) );
$cos->loadRouter();

$app = $cos->router->app;
$module = $cos->router->controller;
$action = $cos->router->action;

$cos->app = new \core\Citrus\mvc\App( $app );
// $cos->user = new \core\Citrus\User();

if ( $cos->app->moduleExists( $module ) ) {
    $cos->app->createController( $module, $action );
    $cos->request->addParams( $cos->router->params );
    $cos->app->executeCtrlAction();
    $cos->done = true;
    die();
} else {
    core\Citrus\Citrus::pageNotFound();
}
