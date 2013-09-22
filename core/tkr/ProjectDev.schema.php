<?php

return array(
    'modelType' => '\core\tkr\ProjectDev',
    'tableName' => 'tkr_projectdev',
    'description' => 'liaison développeur -> projet',
    'pluralDescription' => 'liaison développeur -> projet',
    'properties' => array(
        'id' => array(
            'type'              => 'int',
            'autoincrement'     => true,
            'primaryKey'        => true,
            'formLabel'         => '#',
            'inputType'         => 'InputHidden',
        ),
        'dev_id' => array(   
            'type'              => 'int',
            'formLabel'         => 'Développeur',
            'inputType'         => 'SelectOne',
            'modelType'         => '\core\tkr\Dev',
            'foreignTable'      => 'tkr_dev',
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
    'adminColumns' => array( 'dev_id', 'project_id' ),
    'linkColumns' => array( 'dev_id', 'project_id' ),
    'orderColumn' => 'dev_id ASC',
);