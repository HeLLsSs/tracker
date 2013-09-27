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
            'url'    => '/:app/:controller/:action/page/:page', 
            'target' => array(), 
            'conditions' => array( 'page' => '[0-9]+' )
        ),
        array(
            'url'    => '/:app/:controller/:action/page/:page/search/:search', 
            'target' => array(), 
            'conditions' => array( 'page' => '[0-9]+' )
        ),
        array(
            'url'    => '/:app/:controller/:action/search/:search', 
            'target' => array(), 
            'conditions' => array( 'page' => '[0-9]+' )
        ),
        /*array(
            'url'    => '/backend/projects/:id/tickets/:status', 
            'target' => array( 'app' => 'backend', 'controller' => 'projects', 'action' => 'bugs' ) 
        ),*/

        array(
            'url'    => '/backend/projects/:id/new-ticket', 
            'target' => array( 'app' => 'backend', 'controller' => 'projects', 'action' => 'createTicket' ) 
        ),
        array(
            'url'    => '/:app/projects/:id/view/:filters', 
            'target' => array( 'controller' => 'projects', 'action' => 'view' ),
            'conditions' => array( 'filters' => '[a-z0-9:/,]+' )
        ),
        array(
            'url'    => '/:app/tickets/:id/status/:status', 
            'target' => array( 'controller' => 'tickets', 'action' => 'status' ),
        ),

        array(
            'url'    => '/:app/tickets/:id/dev/:dev_id', 
            'target' => array( 'controller' => 'tickets', 'action' => 'dev' ),
        ),
        array(
            'url'    => '/:app/tickets/:id/status-switch', 
            'target' => array( 'controller' => 'tickets', 'action' => '_status_switch' ),
        ),

    ),
);