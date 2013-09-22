<?php

return array(
    'modelType' => '\core\tkr\ProjectUser',
    'tableName' => 'tkr_projectuser',
    'description' => 'liaison utilisateur -> projet',
    'pluralDescription' => 'liaison utilisateur -> projet',
    'properties' => array(
        'id' => array(
            'type'              => 'int',
            'autoincrement'     => true,
            'primaryKey'        => true,
            'formLabel'         => '#',
            'inputType'         => 'InputHidden',
        ),
        'user_id' => array(   
            'type'              => 'int',
            'formLabel'         => 'Utilisateur',
            'inputType'         => 'SelectOne',
            'modelType'         => '\core\tkr\User',
            'foreignTable'      => 'tkr_user',
            'foreignReference'  => 'id',
        ),
        'project_id' => array(   
            'type'              => 'int',
            'formLabel'         => 'Projet',
            'inputType'         => 'SelectOne',
            'modelType'         => '\core\tkr\Project',
            'foreignTable'      => 'tkr_project',
            'foreignReference'  => 'id',
        ),
        'datecreated' => array(
            'formLabel'         => 'Date de création',
            'type'              => 'datetime',
            'null'              => false,
        ),
        'datemodified' => array(
            'formLabel'         => 'Date de modification',
            'type'              => 'datetime',
            'null'              => false,
        ),
    ),
    'adminColumns' => array( 'user_id', 'project_id' ),
    'linkColumns' => array( 'user_id', 'project_id' ),
    'orderColumn' => 'user_id ASC',
);