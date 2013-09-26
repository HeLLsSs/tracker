<?php

namespace core\tkr;
use \core\Citrus;

class Project extends \core\Citrus\data\Model {
    public $id;
    private $name;
    private $description;
    private $url_dev;
    private $url_preprod;
    private $url_prod;
    private $status;
    // public $datecreated;
    // public $datemodified;
    private $users;
    // private $devs;

    const PROJECT_STATUS_WAITING    = 0;
    const PROJECT_STATUS_RUNNING    = 1;
    const PROJECT_STATUS_FINISHED   = 2;

    public function __toString() {
        return $this->name;
    }

    public function __get( $name ) {
        switch ( $name ) {
            case 'users': 
                return $this->getUsers();
                break;
            /*case 'devs': 
                return $this->getDevs();
                break;*/
            default: 
                if ( property_exists( $this, $name ) ) return $this->$name;
                else return parent::__get( $name );
                break;
        }
    }
    
    public function __set( $name, $value ) {
        switch ( $name ) {
            case 'users' : 
                return $this->setUsers(
                    is_array( $value ) ? $value : ( $value == '' ? array() : explode( ',' ,$value ) ) 
                ); 
                break;
            /*case 'devs' : 
                return $this->setDevs(
                    is_array( $value ) ? $value : ( $value == '' ? array() : explode( ',' ,$value ) ) 
                ); 
                break;*/
            default :
                if ( property_exists( $this, $name ) ) $this->$name = $value;
                else return parent::__set( $name, $value );
            break;
        }
    }


    public function getUsers() {
        if ( !$this->id ) return Array();
        if ( count( $this->users ) == 0 ) {
            $lst = new Citrus\data\ModelCollection( '\core\tkr\ProjectUser' );
            $lst->query->addWhere( "project_id = " . $this->id );
            $lst->query->addWhere( "i0.isadmin = 0" );
            $lst->query->addWhere( "i0.valid = 1" );
            $lst->fetch();
            $this->users = Array();
            foreach ( $lst->items as $item ) $this->users[] = $item->user->hydrateAssoc();
        }
        return $this->users;
    }
    
    private function setUsers( $listIds = array() ) {
        if ( !$this->id ) return array();
        $targetClass = '\core\tkr\ProjectUser';
        $schema = self::getSchema( $targetClass );
        $cos = Citrus\Citrus::getInstance();
        $cos->db->execute( 
            "DELETE FROM " . $schema->tableName . "
            WHERE project_id = '" . $this->id . "'"
        );
        
        foreach ( $listIds as $id ) {
            $lnk = new $targetClass();
            $lnk->user_id = $id;
            $lnk->project_id = $this->id;
            $lnk->save();
        }
    }

    /*public function getDevs() {
        if ( !$this->id ) return Array();
        if ( count( $this->devs ) == 0 ) {
            $lst = new Citrus\data\ModelCollection( '\core\tkr\ProjectDev' );
            $lst->query->addWhere( "project_id = " . $this->id );
            $lst->query->addWhere( "i0.isadmin = 1" );
            $lst->query->addWhere( "i0.valid = 1" );
            $lst->fetch();
            $this->devs = Array();
            foreach ( $lst->items as $item ) $this->devs[] = $item->dev->hydrateAssoc();
        }
        return $this->devs;
    }
    
    private function setDevs( $listIds = array() ) {
        if ( !$this->id ) return array();
        $targetClass = '\core\tkr\ProjectDev';
        $schema = self::getSchema( $targetClass );
        $cos = Citrus\Citrus::getInstance();
        $cos->db->execute( 
            "DELETE FROM " . $schema->tableName . "
            WHERE project_id = '" . $this->id . "'"
        );
        foreach ( $listIds as $id ) {
            $lnk = new $targetClass();
            $lnk->dev_id = $id;
            $lnk->project_id = $this->id;
            $lnk->save();
        }
    }*/

    public function countTickets() {
        $c = new Citrus\data\ModelCollection( '\core\tkr\Ticket' );
        $c->query->addWhere( 'project_id =' . $this->id );
        $c->fetch();
        return $c->count();
    }

    public function countUnassignedTickets() {
        $c = new Citrus\data\ModelCollection( '\core\tkr\Ticket' );
        $c->query->addWhere( 'tkr_ticket.status =' . \core\tkr\Ticket::STATUS_WAITING );
        $c->query->addWhere( 'project_id =' . $this->id );
        $c->fetch();
        return $c->count();
    }

    public function countClientWaitingTickets() {
        $cos = Citrus\Citrus::getInstance();

        $c = new Citrus\data\ModelCollection( '\core\tkr\Ticket' );
        $c->query->addWhere( 'tkr_ticket.status =' . \core\tkr\Ticket::STATUS_CLIENT_WAITING );
        $c->query->addWhere( 'project_id =' . $this->id );
        $c->query->addWhere( 'author_id =' . $cos->user->id );
        $c->fetch();
        return $c->count();

    }

    public function countAssignedTickets() {
        $c = new Citrus\data\ModelCollection( '\core\tkr\Ticket' );
        $c->query->addWhere( 'tkr_ticket.status =' . \core\tkr\Ticket::STATUS_ASSIGNED );
        $c->query->addWhere( 'project_id =' . $this->id );
        $c->fetch();
        return $c->count();
    }

    public function countFixedTickets() {
        $c = new Citrus\data\ModelCollection( '\core\tkr\Ticket' );
        $c->query->addWhere( 'tkr_ticket.status =' . \core\tkr\Ticket::STATUS_FIXED );
        $c->query->addWhere( 'project_id =' . $this->id );
        $c->fetch();
        return $c->count();
    }

    public function countAbortedTickets() {
        $c = new Citrus\data\ModelCollection( '\core\tkr\Ticket' );
        $c->query->addWhere( 'tkr_ticket.status =' . \core\tkr\Ticket::STATUS_ABORTED );
        $c->query->addWhere( 'project_id =' . $this->id );
        $c->fetch();
        return $c->count();
    }

    public function getStatus() {
        switch ( intval( $this->status ) ) {
            case self::PROJECT_STATUS_WAITING:
                return 'en attente';
                break;
            case self::PROJECT_STATUS_RUNNING:
                return 'en cours';
                break;
            case self::PROJECT_STATUS_FINISHED:
                return 'terminé';
                break;
            default:
                return '';
                break;
        }
    }   
}