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
        'user_id' => array(   
            'type'              => 'int',
            'null'              => false,
            'formLabel'         => 'Auteur',
            'inputType'         => 'SelectOne',
            'modelType'         => '\core\tkr\User',
            'foreignTable'      => 'tkr_user',
            'foreignReference'  => 'id',
            'firstBlank'        => false,
        ),
        'bug_id' => array(   
            'type'              => 'int',
            'null'              => false,
            'formLabel'         => 'Bug',
            'inputType'         => 'SelectOne',
            'modelType'         => '\core\tkr\Bug',
            'foreignTable'      => 'tkr_bug',
            'foreignReference'  => 'id',
            'firstBlank'        => false,
        ),
        'commit' => array(   
            'type'              => 'int',
            'null'              => false,
            'formLabel'         => 'Commit #',
            'inputType'         => 'InputText',
        ),
        'description' => array(
            'type'          => 'text',
            'null'          => true,
            'formLabel'     => 'Description',
            'inputType'     => 'Textarea',
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
    'adminColumns' => array( 'user_id', 'bug_id', 'commit', 'datecreated' ),
    'orderColumn' => 'datecreated DESC',
    'linkColumns' => Array( 'user_id' ),
);