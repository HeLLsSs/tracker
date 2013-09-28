<?php

return array(
    'shortName' => 'Comment',
    'modelType' => '\core\tkr\Comment',
    'tableName' => 'tkr_comment',
    'description' => 'commentaire',
    'pluralDescription' => 'commentaires',
    'properties' => array(
        'id' => array(
            'type'          => 'int',
            'autoincrement' => true,
            'primaryKey'    => true,
            'inputType'     => 'InputHidden',
        ),
        'content' => array(
            'type'          => 'text',
            'length'        => 255,
            'null'          => false,
            'formLabel'     => 'Commentaire',
            'inputType'     => 'Textarea',
        ),
        'ticket_id' => array(   
            'type'              => 'int',
            'null'              => false,
            // 'formLabel'         => 'Ticket',
            'inputType'         => 'InputHidden',
            'modelType'         => '\core\tkr\Ticket',
            'foreignTable'      => 'tkr_ticket',
            'foreignReference'  => 'id',
        ),
        'author_id' => array(   
            'type'              => 'int',
            'null'              => false,
            // 'formLabel'         => 'Auteur',
            'inputType'         => 'InputHidden',
            'modelType'         => '\core\tkr\User',
            'foreignTable'      => 'tkr_user',
            'foreignReference'  => 'id',
        ),
        'comment_id' => array(   
            'type'              => 'int',
            'null'              => true,
            // 'formLabel'         => 'comment',
            'inputType'         => 'InputHidden',
            'modelType'         => '\core\tkr\Comment',
            'foreignTable'      => 'tkr_comment',
            'foreignReference'  => 'id',
        ),
        'active' => array(
            'type'          => 'boolean',
            'null'          => false,
            'formLabel'     => 'Actif',
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
    'adminColumns' => array( 'author', 'ticket', 'active' ),
    'orderColumn' => 'datecreated DESC',
    'linkColumns' => Array( 'lastname' ),
);