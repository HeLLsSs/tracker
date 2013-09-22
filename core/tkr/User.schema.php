<?php

return array(
    'shortName' => 'User',
    'modelType' => '\core\tkr\User',
    'tableName' => 'tkr_user',
    'description' => 'utilisateur',
    'pluralDescription' => 'utilisateurs',
    'properties' => array(
        'id' => array(
            'type'          => 'int',
            'autoincrement' => true,
            'primaryKey'    => true,
            'inputType'     => 'InputHidden',
        ),
        'lastname' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => true,
            'formLabel'     => 'Nom',
            'inputType'     => 'InputText',
        ),
        'firstname' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => false,
            'formLabel'     => 'Prénom',
            'inputType'     => 'InputText',
        ),
        'email' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => false,
            'formLabel'     => 'E-mail',
            'inputType'     => 'InputText',
        ),
        'password' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => false,
            'formLabel'     => 'Mot de passe',
            'inputType'     => 'InputPassword',
        ),
        'picture' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => false,
            'formLabel'     => 'Image',
            'inputType'     => 'InputFile',
        ),
        'valid' => array(
            'type'          => 'boolean',
            'null'          => false,
            'formLabel'     => 'Actif',
            'inputType'     => 'CheckBox',
        ),
        'isadmin' => array(
            'type'          => 'boolean',
            'null'          => false,
            'formLabel'     => 'Administrateur',
            'inputType'     => 'CheckBox',
        ),
        'datecreated' => array(
            'type'          => 'datetime',
            'formLabel'     => 'Date de création', 
            'null'          => false,
        ),
        'datemodified' => array(
            'type'          => 'datetime',
            'null'          => false,
        ),
    ),
    'adminColumns' => array( 'lastname', 'firstname', 'email', 'active', 'datecreated' ),
    'orderColumn' => 'lastname ASC, firstname ASC',
    'linkColumns' => Array( 'lastname' ),
);