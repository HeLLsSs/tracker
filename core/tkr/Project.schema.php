<?php

return array(
    'shortName' => 'Project',
    'modelType' => '\core\tkr\Project',
    'tableName' => 'tkr_project',
    'description' => 'projet',
    'pluralDescription' => 'projets',
    'properties' => array(
        'id' => array(
            'type'          => 'int',
            'autoincrement' => true,
            'primaryKey'    => true,
            'inputType'     => 'InputHidden',
        ),
        'name' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => false,
            'formLabel'     => 'Nom',
            'inputType'     => 'InputText',
        ),
        'description' => array(
            'type'          => 'text',
            'null'          => true,
            'formLabel'     => 'Description',
            'inputType'     => 'RichText',
        ),
        'url_dev' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => true,
            'formLabel'     => 'URL de développement',
            'inputType'     => 'InputText',
        ),
        'url_preprod' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => true,
            'formLabel'     => 'URL de pré-production',
            'inputType'     => 'InputText',
        ),
        'url_prod' => array(
            'type'          => 'string',
            'length'        => 255,
            'null'          => true,
            'formLabel'     => 'URL de production',
            'inputType'     => 'InputText',
        ),
        'status' => array(
            'type'              => 'int',
            'null'              => false,
            'formLabel'         => 'État',
            'inputType'         => 'SelectOne',
            'options'           => Array(
                '0' => 'En attente',
                '1' => 'En cours',
                '2' => 'Terminé',
            ),
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
    'manyProperties' => array(
        'users' => array(
            'formLabel'         => 'Utilisateurs',
            'modelType'         => '\core\tkr\User',
            'foreignTable'      => 'tkr_user',
            'foreignReference'  => 'id',
            'conditions'        => Array(
                'isadmin = 0',
                'valid = 1'
            ),
        ),
        /*'devs' => array(
            'formLabel'         => 'Développeurs',
            'modelType'         => '\core\tkr\User',
            'foreignTable'      => 'tkr_user',
            'foreignReference'  => 'id',
        ),*/
    ),
    'adminColumns' => array( 'name', 'status', 'datecreated' ),
    'orderColumn' => 'datecreated DESC',
    'linkColumns' => Array( 'name' ),
);