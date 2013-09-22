<?php

return array(
    'default' => array(
        'app' => 'frontend',
        'controller' => 'main',
        'action' => 'index',
    ),
    'routes' => array( 
        array(
            'url'    => '/', 
            'target' => array( 'controller' => 'main', 'action' => 'index' ) 
        ),
        array(
            'url'    => '/telecharger.html', 
            'target' => array( 'controller' => 'main', 'action' => 'download' ) 
        ),
        array(
            'url'    => '/a-propos.html', 
            'target' => array( 'controller' => 'main', 'action' => 'about' ) 
        ),
        array(
            'url'    => '/docs/',
            'target' => array( 'controller' => 'main', 'action' => 'docs' )
        ),
        array(
            'url'    => '/docs/api.html', 
            'target' => array( 'controller' => 'main', 'action' => 'apidocs' ) 
        ),
        array(
            'url'    => '/licence.html', 
            'target' => array( 'controller' => 'main', 'action' => 'licence' ) 
        ),
        
        # backend
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