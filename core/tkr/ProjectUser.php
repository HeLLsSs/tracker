<?php

namespace core\tkr;
use \core\Citrus as Citrus;

class ProjectUser extends Citrus\data\Model {
    
    private $id;
    private $user_id;
    private $user;
    
    private $project_id; 
    private $project; 
    
    const TABLENAME = 'tkr_projectuser';

    public function __construct() {
        parent::__construct();
    }    
    
    public function __get( $name ) {
        switch ( $name ) {
            default :
                if ( property_exists( $this, $name ) ) return $this->$name;
                else return parent::__get( $name );
            break;
        }
    }
    
    public function __set( $name, $value ) {
        switch ( $name ) {
            default :
                if ( property_exists( $this, $name ) ) $this->$name = $value;
                else return parent::__set( $name, $value );
            break;
        }
    }
    
    public function toArray( $merged = array() ) {
        return parent::toArray( get_object_vars( $this ) );
    }
}