<?php

namespace core\tkr;
use \core\Citrus\Citrus;
use \core\Citrus\data;
use \core\Citrus\db;

class User extends \core\Citrus\data\Model {
    const TABLENAME = 'tkr_user';
    public $id;
    public $lastname;
    public $firstname;
    public $email;
    public $password;
    public $isadmin;
    public $valid;
    // public $datecreated;
    // public $datemodified;

    public function __toString()  {
        $str = (string) $this->firstname;
        if ( !$this->isadmin ) $str .= ' ' . $this->lastname;
        return $str;
    }

    private function fetchUser( $login, $password ) {
        $cos = Citrus::getInstance();
        
        $password = md5( $password );
        
        $exists = $cos->db->execute( 
            "SELECT * FROM " . self::TABLENAME . "
            WHERE email = '$login' 
            AND password = '$password'"
        )->fetchObject( '\\core\\tkr\\User' );
        
        if ( $exists ) {
            $this->login    = $exists->login;
            $this->name     = $exists->name;
            $this->email    = $exists->email;
            $this->id       = $exists->id;
        }
        return $exists;
    }

    public function isLogged() {
        return ( 
            isset( $_SESSION['CitrusUserLogin'] )  && 
            isset( $_SESSION['CitrusUserId'] )
        );
    }

    public function login( $login, $password ) {
        $user = $this->fetchUser( $login, $password );
        if ( $user ) {
            $_SESSION['CitrusUserLogin']    = $this->email;
            $_SESSION['CitrusUserId']       = $this->id;
            $_SESSION['CitrusUser']         = $user;
        }
        return $user;
    }

    public function getProjectsIds() {
        // $col = $this->isadmin ? 'develo'
        $q = new db\SelectQuery();
        $q->table = 'tkr_projectuser';
        $q->columns = Array( 'project_id' );
        $q->addWhere( 'user_id = ' . $this->id );
        return $q->execute()->fetchAll( \PDO::FETCH_COLUMN );
    }
    
}