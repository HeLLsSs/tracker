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
                http\Http::redirect( '/backend/projects/' );
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
            
            $this->view->layout = false;
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
    
    public function do_save( $request ) {
        $this->view->layout = !$request->isXHR;
        $report = Array();
        $cos = Citrus::getInstance();
        if ( $request->method != 'POST' ) {
            if ( $cos->debug ) {
                throw new Exception( 'Bad method request' );
            } else {
                Citrus::pageNotFound();
            }
        } else {
            if ( class_exists( $this->className ) ) {
                $inst = new $this->className();
                if ( isset( $_FILES ) ) {
                    foreach ( $_FILES as $name => $file ) {
                        if ( !empty( $file['name'] ) ) {
                            if ( $inst->$name ) {
                                unlink( CITRUS_PATH . 'www/upload' . $inst->$name );
                            }
                            $upld = new kos_http_Uploader( $file );
                            $upld->readFile();
                            $up = $upld->moveFile( CITRUS_PATH . '/www/upload/' );
                            $inst->args[$name] = $inst->$name = '/www/upload/' . $upld->fileName;
                        }
                    }
                }
                $password = $request->param( 'password', 'string' );
                $inst->hydrateByFilters();
                if ( $password && $password != '' ) $inst->password = sha1( $inst->password );

                $rec = $inst->save();
                $inst->hydrateManyByFilters();
                
                if ( $request->isXHR ) {
                    $this->view = new mvc\View( 'json-response' );
                    $this->view->layout = false;
                    if ( $rec ) {
                        $this->view->assign('status', "success");
                        $response['status'] = "success";
                        $response['return_url'] = $cos->app->getControllerUrl();
                        $response['message'] = "L'utilisateur a été enregistré.";
                    } else {
                        $response['status'] = "error";
                    }
                    $cos->response->contentType = "application/json";
                    $this->view->assign( 'response', $response );
                } else {
                    $loc = $cos->app->getControllerUrl();
                    http\Http::redirect( $loc );
                }
            } else throw new sys\Exception( "Unknown class '$type'" );
        }

        return;
    }
}