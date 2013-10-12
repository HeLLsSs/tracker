<?php

namespace apps\backend\modules\tickets;
use \core\Citrus\mvc;
use \core\Citrus;
use \core\Citrus\data;
use \core\Citrus\http;
use \core\Citrus\html\form\Form;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\Ticket';

    public function do_edit( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $schema = data\Model::getSchema( $this->className );
        $this->view->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = data\Model::selectOne( $this->className, $id );
            $project_ids = $cos->user->getProjectsIds();
            if ( !in_array( $res->project_id, $project_ids ) && !$cos->user->isadmin ) {
                Citrus\Citrus::pageNotFound();
                return false;
            }
        } else {
            $res = new $this->className();
            $res->author_id = $cos->user->id;
        }
        $form = Form::generateForm( $res );
        $this->view->assign( 'res', $res );
        $this->view->assign( 'form', $form );
        $this->view->assign( 'schema', $schema );
        $this->view->assign( 'layout', $this->view->layout );
    }

    public function do_view( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $schema = data\Model::getSchema( $this->className );
        $this->view->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = data\Model::selectOne( $this->className, $id );

            if ( $res ) {
                $project_ids = $cos->user->getProjectsIds();
                if ( !in_array( $res->project_id, $project_ids ) && !$cos->user->isadmin ) {
                    Citrus\Citrus::pageNotFound();
                    return false;
                }
                $this->view->assign( 'res', $res );
                $this->view->assign( 'schema', $schema );
                $this->view->assign( 'layout', $this->view->layout );

                $devColl = new data\ModelCollection( '\core\tkr\User' );
                $devColl->query->addWhere( 'isadmin = 1' );
                // $devColl->query->addWhere( 'id <> ' . $cos->user->id );
                $devColl->fetch();
                $this->view->assign( 'devs', $devColl->items );
            } else Citrus\Citrus::pageNotFound();
        }
    }

    public function do_save( $request ) {
        $this->view->layout = !$request->isXHR;
        $report = Array();
        $cos = Citrus\Citrus::getInstance();

        if ( $request->method != 'POST' ) {
            if ( $cos->debug ) {
                throw new Exception( 'Bad method request' );
            } else {
                Citrus\Citrus::pageNotFound();
            }
        } else {
            #vexp($_POST);
            $id = $request->param( 'id', 'int' );
            $project_ids = $cos->user->getProjectsIds();
            if ( !in_array( $id, $project_ids ) && !$cos->user->isadmin ) {
                Citrus::pageNotFound();
                return false;
            }
            $type = $request->param( 'modelType', 'string' );

            if ( class_exists( $type ) ) {
                $inst = new $type();
                
                $inst->status = \core\tkr\Ticket::STATUS_WAITING;
                $inst->hydrateByFilters();
                $is_new = $inst->id;
                $rec = $inst->save();
                $inst->hydrateManyByFilters();
                
                if ( $request->isXHR ) {
                    $this->view = new mvc\View( 'json-response' );
                    $this->view->layout = false;
                    $response = Array();
                    if ( $rec ) {
                        $this->view->assign('status', "success");
                        $response['status'] = "success";
                        $response['return_url'] = CITRUS_PROJECT_URL . $cos->app->name . '/tickets/' . $inst->id . '/view';
                        $response['message'] = "Le ticket a été enregistré.";
                    } else {
                        $response['status'] = "error";
                    }
                    $cos->response->contentType = "application/json";
                    $this->view->assign( 'response', $response );
                } else {
                    $loc = CITRUS_PROJECT_URL . $cos->app->name . '/tickets/' . $inst->id . '/view';
                    http\Http::redirect( $loc );
                }
            } else throw new sys\Exception( "Unknown class '$type'" );
        }

        return;
    }

    public function do_status( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $this->view->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        $status = $request->param( 'status', 'int' );
        if ( $id && $status ) {
            $res = data\Model::selectOne( $this->className, $id );
            $project_ids = $cos->user->getProjectsIds();
            if ( !in_array( $res->project_id, $project_ids ) && !$cos->user->isadmin ) {
                Citrus\Citrus::pageNotFound();
                return false;
            }
            $res->status = $status;
            $rec = $res->save();
            $response = Array();
            if ( $request->isXHR ) {
                $this->view = new mvc\View( 'json-response' );
                if ( $rec ) {
                    $response['status'] = "success";
                    $response['data']['status'] = (int) $res->status;
                } else {
                    $response['status'] = "error";
                }
                $cos->response->contentType = "application/json";
                $this->view->assign( 'response', $response );
            } #else http\Http::redirect( $request->referer );
        } else Citrus\Citrus::pageNotFound();
    }

    public function do_dev( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $this->view->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        $dev_id = $request->param( 'dev_id', 'int' );
        if ( $id && $dev_id ) {
            $res = data\Model::selectOne( $this->className, $id );
            $project_ids = $cos->user->getProjectsIds();
            if ( !in_array( $res->project_id, $project_ids ) && !$cos->user->isadmin ) {
                Citrus\Citrus::pageNotFound();
                return false;
            }
            $res->developer_id = $dev_id;
            $rec = $res->save();
            $response = Array();
            if ( $request->isXHR ) {
                $this->view = new mvc\View( 'json-response' );
                if ( $rec ) {
                    $response['status'] = "success";
                    $response['data']['status'] = (int) $res->status;
                } else {
                    $response['status'] = "error";
                }
                $cos->response->contentType = "application/json";
                $this->view->assign( 'response', $response );
            } else http\Http::redirect( $request->referer );
        } else Citrus\Citrus::pageNotFound();
    }

    public function do__status_switch( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $this->view->layout = false;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = data\Model::selectOne( $this->className, $id );
            // if ( $res->status == \core\tkr\Ticket::STATUS_WAITING ) 
                // $res->status = \core\tkr\Ticket::STATUS_ASSIGNED;
            $this->view->assign( 'res', $res );
            
        } else Citrus\Citrus::pageNotFound();
    }

    public function do_index( $request ) {
        $cos = Citrus\Citrus::getInstance();
        if ( $cos->user->isadmin != '1' ) {
            Citrus\Citrus::pageNotFound();
        } else parent::do_index( $request );
    }

    public function do_comments( $request ) {
        $request->isXHR = true;
        if ( $request->isXHR ) {
            $this->view = new mvc\View( '_comments' );
            $this->view->layout = false;
            $id = $request->param( 'id', 'int' );
            $comments = Array();
            if ( $id ) {
                $comments = call_user_func_array( 
                    Array( $this->className, 'getTicketsComments' ), 
                    Array( $id )
                );
            }
            $this->view->assign( 'comments', $comments );
        } else Citrus\Citrus::pageNotFound();
    }
}