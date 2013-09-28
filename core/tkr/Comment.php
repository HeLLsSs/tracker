<?php

namespace core\tkr;
use \core\Citrus\Citrus;
use \core\Citrus\data;
use \core\Citrus\db;

class Comment extends \core\Citrus\data\Model {
    const TABLENAME = 'tkr_comment';
    public $id;
    public $content;
    public $author;
    public $author_id;
    public $ticket;
    public $ticket_id;
    public $active;
    public $comment;
    public $comment_id;

    
}