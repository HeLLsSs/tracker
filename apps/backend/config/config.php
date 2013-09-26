<?php 

$this->titleTag             = "";
$this->layout               = 'main';
$this->security_exceptions  = Array();

$this->is_protected 		= true;


$self = $this;

$this->isAccessAllowed  = function() use( &$self ) {
    // app : $self
    $cos = \core\Citrus\Citrus::getInstance();
    
    if ( isset( $_SESSION['CitrusUser'] ) && get_class( $_SESSION['CitrusUser'] ) ) {
        $cos->user = $_SESSION['CitrusUser'];
    } if ( isset($_SESSION['CitrusUserId'] ) && filter_var( $_SESSION['CitrusUserId'], FILTER_VALIDATE_INT ) ) {
        $cos->user = \core\Citrus\data\Model::selectOne(
            '\core\tkr\User', (integer) $_SESSION['CitrusUserId']);
        if ( !$cos->user ) $cos->user = new \core\tkr\User();
    } else {
        $cos->user = new \core\tkr\User();
    }

    $logged = $cos->user->isLogged();

    if ( $self->is_protected ) {
        if ( $self->controller->isActionProtected() ) $ret = $logged;
        else $ret = true;
    } else {
        if ( $self->controller->isActionProtected() ) $ret = $logged;
        else $ret = true;
    }
    return $ret;
};


$this->onActionProtected = function() {
    \core\Citrus\http\Http::redirect( CITRUS_PROJECT_URL . 'backend/login' );
};