<?php

namespace core\tkr;
use \core\Citrus\data;
use \core\Citrus\Date;

class Ticket extends \core\Citrus\data\Model {
    public $id;
    public $title;
    public $description;
    public $project_id;
    public $project;
    public $author_id;
    public $author;
    public $developer_id;
    public $developer;
    public $status;
    public $type;
    public $priority;
    public $fix_id;
    public $fix;

    private $datecreated;
    private $datemodified;

    private $comments = Array();

    const STATUS_WAITING        = 1;
    const STATUS_ASSIGNED       = 2;
    const STATUS_CLIENT_WAITING = 3;
    const STATUS_FIXED          = 4;
    const STATUS_ABORTED        = 5;

    const TYPE_BUG              = 1;
    const TYPE_TASK             = 2;
    const TYPE_IMPROVM          = 3;
    const TYPE_REQUEST          = 4;

    const PRIORITY_NORMAL       = 1;
    const PRIORITY_URGENT       = 2;
    const PRIORITY_BLOCKING     = 3;

    public function __get( $name ) {
        switch ( $name ) {
            case 'comments':
                return $this->getComments();
                break;
            case 'datecreated':
                return Date::parse( $this->$name );
            case 'datemodified':
                return Date::parse( $this->$name );
            default:
                return $this->$name;
                break;
        }
    }

    public function getStatus() {
        switch ( intval( $this->status ) ) {
            case self::STATUS_WAITING:
                return 'En attente';
                break;
            case self::STATUS_ASSIGNED:
                return 'En cours';
                break;
            case self::STATUS_CLIENT_WAITING:
                return 'En attente client';
                break;
            case self::STATUS_FIXED:
                return 'Résolu';
                break;
            case self::STATUS_ABORTED:
                return 'Abandonné';
                break;
            default:
                return '';
                break;
        }
    }   

    public function getType() {
        switch ( intval( $this->type ) ) {
            case self::TYPE_BUG:
                return 'Anomalie';
                break;
            case self::TYPE_TASK:
                return 'Tâche';
                break;
            case self::TYPE_IMPROVM:
                return 'Amélioration';
                break;
            case self::TYPE_REQUEST:
                return 'Requête';
                break;
            default:
                return '';
                break;
        }
    }

    public function getPriority() {
        switch ( intval( $this->priority ) ) {
            case self::PRIORITY_NORMAL:
                return 'Normal';
                break;
            case self::PRIORITY_URGENT:
                return 'Urgent';
                break;
            case self::PRIORITY_BLOCKING:
                return 'Bloquant';
                break;
            default:
                return '';
                break;
        }
    }

    public function getComments() {
        if ( !count( $this->comments ) && $this->id ) {
            $this->comments = self::getTicketsComments( $this->id );
        }
        return $this->comments;
    }

    static public function getTicketsComments( $id ) {
        $c = new data\ModelCollection( '\core\tkr\Comment' );
        $c->query->addWhere( 'tkr_comment.ticket_id = ' . $id );
        $c->query->addWhere( 'tkr_comment.comment_id IS NULL ' );
            $c->query->addOrder( 'tkr_comment.datecreated ASC' );
        $c->fetch();
        return $c->items;
    }

    public function isNew() {
        $delay = 60 * 60 * 24 * 2; // 2 days
        if ( get_class( $this->datecreated ) != '\core\Citrus\Date' ) 
            $this->datecreated = Date::parse( $this->datecreated );
        return date( 'U' ) - $this->datecreated->format( 'U' ) < ( $delay );
    }

    static public function statuses() {
        return Array(
            self::STATUS_WAITING          => 'En attente',
            self::STATUS_ASSIGNED         => 'En cours',
            self::STATUS_CLIENT_WAITING   => 'En attente client',
            self::STATUS_FIXED            => 'Résolu',
            self::STATUS_ABORTED          => 'Abandonné',
        );
    }
}