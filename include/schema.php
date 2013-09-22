<?php

return array(
    /*** Users ***/
    'user' = array(
        'shortName' => 'user',
        'tableName' => 'users',
    	'description' => 'utilisateur',
    	'pluralDescription' => 'utilisateurs',
        'properties' => array(
            'id'        => array(
                'type'          => 'bigint',
                'autoincrement' => true,
                'primaryKey'    => true,
            );
            'login'     => array(
                'type'          => 'string',
                'length'        => 255,
                'null'          => false,
                'formLabel'     => 'Identifiant'
            ),
            'password'  => array(
                'type'          => 'string',
                'length'        => 255,
                'null'          => false,
                'formLabel'     => 'Mot de passe',
            ),
            'name'      => array(
                'type'          => 'string',
                'length'        => 255,
                'null'          => false,
                'formLabel'     => 'Nom',
            ),
            'email'     => array(
                'type'          => 'string',
                'length'        => 255,
                'null'          => false,
                'formLabel'     => 'E-mail',
            ),
            'isAdmin'   => array(
                'type'          => 'boolean',
                'formLabel'     => 'Administrateur',
            ),
            'valid'     => array(
                'type'          => 'boolean',
                'formLabel'     => 'Actif',
            ),
        ),
    ),
);