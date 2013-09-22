<?php

return array(
    'default' => array(
        'app' => 'frontend',
        'controller' => 'main',
        'action' => 'index',
    ),
    'routes' => array( 
        array(
            'url'    => '/backend/login', 
            'target' => array( 'app' => 'backend', 'controller' => 'users', 'action' => 'login' ) 
        ),
        array(
            'url'    => '/:app/:controller/:action/page/:page', 
            'target' => array(), 
            'conditions' => array( 'page' => '[0-9]+' )
            // 'target' => array( 'app' => 'backend', 'controller' => 'users', 'action' => 'logout' ) 
        ),
        array(
            'url'    => '/:app/:controller/:action/page/:page/search/:search', 
            'target' => array(), 
            'conditions' => array( 'page' => '[0-9]+' )
            // 'target' => array( 'app' => 'backend', 'controller' => 'users', 'action' => 'logout' ) 
        ),
        array(
            'url'    => '/:app/:controller/:action/search/:search', 
            'target' => array(), 
            'conditions' => array( 'page' => '[0-9]+' )
            // 'target' => array( 'app' => 'backend', 'controller' => 'users', 'action' => 'logout' ) 
        ),
    ),
    
);