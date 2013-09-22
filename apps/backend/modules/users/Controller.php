<?php

namespace apps\backend\modules\users;
use \core\Citrus\mvc;
use \core\Citrus\Citrus;
use \core\Citrus\http;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\User';
    
    public $is_protected = true;
    public $security_exceptions = Array( 'login', 'logout' );

    public function do_login() {
        $cos = Citrus::getInstance();
        if ( $cos->user->isLogged() ) {
            http\Http::redirect( '/backend/projects/' );
        }
        $redir = $cos->projectName . '_REDIRECT_URI';
        $this->pageTitle = 'Administration';
        if ( $this->request->method == 'POST' ) {
            $login = $this->request->param( 'email', 'string' );
            $password = $this->request->param( 'password', 'string' );

            if ( $cos->user->login( $login, $password ) ) {
                /*if (isset($_SESSION[$redir])) {
                    http\Http::redirect( $_SESSION[$redir] );
                    unset($_SESSION[$redir]);
                }
                else*/ http\Http::redirect( '/backend/projects/' );
            } else {
                http\Http::redirect( '/backend/projects/' );
            }
        }
    }
    
    public function do_logout() {
        $cos = Citrus::getInstance();
        unset( $cos );
        session_destroy();
        http\Http::redirect( CITRUS_PROJECT_URL . 'backend/login' );
    }
    
    public function do_checkAvailable() {
        if ( $this->request->method == 'POST' ) {
            $cos = Citrus::getInstance();
            
            $this->layout = false;
            $data = $this->request->param( 'value', FILTER_SANITIZE_STRING );
            if ( $data ) {
                $test = $cos->db->execute(
                    "SELECT `login` 
                    FROM `citrus_user` 
                    WHERE `login` = '$data'"
                )->fetchColumn( 0 );
                if ( $test ) {
                    echo '1';
                    exit;
                }
            }
            echo '0';
            exit;
        }
    }
    
    public function do_save() {
        $cos = Citrus::getInstance();
        if ( $this->request->method == 'POST' ) {
            $type = $this->request->param( 'modelType', FILTER_SANITIZE_STRING );
            if ( class_exists( $type ) ) {
                $inst = new $type();
                $inst->hydrateByFilters();
                $pass1 = $this->request->param( 'password1', FILTER_SANITIZE_STRING );
                $pass2 = $this->request->param( 'password2', FILTER_SANITIZE_STRING );
                if ( $pass1 === $pass2 ) {
                    $inst->args['password'] = md5( $pass1 );
                }
                $rec = $inst->save();
                #vexp($rec);exit();

                $loc = CITRUS_PROJECT_URL . "{$cos->app->name}/{$cos->router->module}/index.html";
                Citrus_Http::redirect( $loc );
            }
        } else {
            die( 'Bad method request' );
        }
    }
}