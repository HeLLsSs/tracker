<?php

namespace core\tkr;

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

    const STATUS_WAITING        = 1;
    const STATUS_ASSIGNED       = 2;
    const STATUS_CLIENT_WAITING = 3;
    const STATUS_FIXED          = 4;
    const STATUS_TREATED        = 5;
    const STATUS_ABORTED        = 6;

    const TYPE_BUG              = 1;
    const TYPE_TASK             = 2;
    const TYPE_IMPROVM          = 3;
    const TYPE_REQUEST          = 4;

    const PRIORITY_NORMAL       = 1;
    const PRIORITY_URGENT       = 2;
    const PRIORITY_BLOCKING     = 3;


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
            case self::STATUS_CLOSED:
                return 'Fermé';
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
        switch ( intval( $this->type ) ) {
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

    public function isNew() {
        $delay = 60 * 60 * 24 * 2; // 2 days
        return date( 'U' ) - $this->datecreated->format( 'U' ) < ( $delay );
    }

    static public function statuses() {
        return Array(
            self::STATUS_WAITING          => 'En attente',
            self::STATUS_ASSIGNED         => 'En cours',
            self::STATUS_CLIENT_WAITING   => 'En attente client',
            self::STATUS_FIXED            => 'Résolu',
            self::STATUS_TREATED          => 'Traité',
            self::STATUS_ABORTED          => 'Abandonné',
        );
    }
}