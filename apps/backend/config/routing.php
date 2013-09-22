<?php

return array(
    'default' => array(
        'controller' => 'main',
        'action' => 'index',
    ),
    
    'routes' => array(
		array(
            'url'    => '/backend/login', 
            'target' => array( 'app' => 'backend', 'controller' => 'users', 'action' => 'login' ) 
        ),
        array(
			'url'    => '/backend/logout', 
        	'target' => array( 'app' => 'backend', 'controller' => 'users', 'action' => 'logout' ) 
		),
        array(
            'url'    => '/backend/projects/:id/tickets/:status', 
            'target' => array( 'app' => 'backend', 'controller' => 'projects', 'action' => 'bugs' ) 
        ),
        
    ),
);