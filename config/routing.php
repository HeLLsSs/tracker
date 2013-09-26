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
        
    ),
    
);