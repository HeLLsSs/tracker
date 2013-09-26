<?php

namespace apps\backend\modules\users;
use \core\Citrus\mvc;
use \core\Citrus\Citrus;
use \core\Citrus\http;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\User';
    
    public $is_protected = true;
    public $security_exceptions = Array( 'login', 'logout' );

    public function do_login( $request ) {
        $cos = Citrus::getInstance();
        if ( $cos->user->isLogged() ) {
            http\Http::redirect( '/backend/projects/' );
        }
        $redir = $cos->projectName . '_REDIRECT_URI';
        $this->pageTitle = 'Administration';
        if ( $request->method == 'POST' ) {
            $login = $request->param( 'email', 'string' );
            $password = $request->param( 'password', 'string' );

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
    
    public function do_logout( $request ) {
        $cos = Citrus::getInstance();
        unset( $cos );
        session_destroy();
        http\Http::redirect( CITRUS_PROJECT_URL . 'backend/login' );
    }
    
    public function do_checkAvailable( $request ) {
        if ( $request->method == 'POST' ) {
            $cos = Citrus::getInstance();
            
            $this->layout = false;
            $data = $request->param( 'value', FILTER_SANITIZE_STRING );
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

    public function do_index( $request ) {
        $cos = Citrus::getInstance();
        if ( $cos->user->isadmin != '1' ) {
            Citrus::pageNotFound();
        } else parent::do_index( $request );
    }

    public function do_edit( $request ) {
        $cos = Citrus::getInstance();
        if ( $cos->user->isadmin != '1' ) {
            Citrus::pageNotFound();
        } else parent::do_edit( $request );
    }
    
    /*public function do_save( $request ) {
        $cos = Citrus::getInstance();
        if ( $request->method == 'POST' ) {
            $type = $request->param( 'modelType', 'string' );
            vexp($request);exit;
            if ( class_exists( $type ) ) {
                $inst = new $type();
                $inst->hydrateByFilters();
                $pass1 = $request->param( 'password1', 'string' );
                $pass2 = $request->param( 'password2', 'string' );
                if ( $pass1 === $pass2 ) {
                    $inst->args['password'] = md5( $pass1 );
                }
                $rec = $inst->save();
                vexp($rec);exit();

                if ( $request->isXHR ) {
                    $this->template = new \core\Citrus\mvc\Template( 'json-response' );
                    $this->layout = false;
                    if ( $rec ) {
                        $this->template->assign('status', "success");
                        $response['status'] = "success";
                        $response['return_url'] = $cos->app->getControllerUrl();
                    } else {
                        $response['status'] = "error";
                    }
                    $cos->response->contentType = "application/json";
                    $this->template->assign( 'response', $response );
                } else {
                    $loc = $cos->app->getControllerUrl();
                    http\Http::redirect( $loc );
                }
            }
        } else {
            die( 'Bad method request' );
        }
    }*/
}