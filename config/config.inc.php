<?php

return $config = array(
    # project configuration
    'siteName' => 'Caramia bug tracker',
    'projectName' => 'tkr',
    
    # routing defaults
    'defaultApp' => 'frontend',
    
    # hosts
    'hosts' => array(
        # dev
        'dev' => array(
            'httpHost'          => '',
            'baseUrl'           => '/',
            'services'          => array(
                'hasRewriteEngine' => array( 'active' => true ),
                'logger' => array( 'active' => true ),
                'debug'  => array( 'active' => true ),
                'db'     => array( 'active' => true,
                    'connection' => array( 
                        "mysql:dbname=",
                        "", 
                        "" 
                    ),
                ),
            ),
        ),
    ),
    
    # Citrus locale Configuration
    'cos_Timezone' => 'Europe/Paris',
);