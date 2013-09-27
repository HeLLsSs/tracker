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
        $this->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = data\Model::selectOne( $this->className, $id );
        } else {
            $res = new $this->className();
            $res->author_id = $cos->user->id;
        }
        $form = Form::generateForm( $res );
        $this->template->assign( 'res', $res );
        $this->template->assign( 'form', $form );
        $this->template->assign( 'schema', $schema );
        $this->template->assign( 'layout', $this->layout );
    }

    public function do_view( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $schema = data\Model::getSchema( $this->className );
        $this->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = data\Model::selectOne( $this->className, $id );

            if ( $res ) {
                $this->template->assign( 'res', $res );
                $this->template->assign( 'schema', $schema );
                $this->template->assign( 'layout', $this->layout );

                $devColl = new data\ModelCollection( '\core\tkr\User' );
                $devColl->query->addWhere( 'isadmin = 1' );
                // $devColl->query->addWhere( 'id <> ' . $cos->user->id );
                $devColl->fetch();
                $this->template->assign( 'devs', $devColl->items );
            } else Citrus\Citrus::pageNotFound();
        }
    }

    public function do_save( $request ) {
        $this->layout = !$request->isXHR;
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
            $type = $request->param( 'modelType', 'string' );

            if ( class_exists( $type ) ) {
                $inst = new $type();
                
                $inst->status = \core\tkr\Ticket::STATUS_WAITING;
                $inst->hydrateByFilters();
                $rec = $inst->save();
                $inst->hydrateManyByFilters();
                
                if ( $request->isXHR ) {
                    $this->template = new mvc\Template( 'json-response' );
                    $this->layout = false;
                    $response = Array();
                    if ( $rec ) {
                        $this->template->assign('status', "success");
                        $response['status'] = "success";
                        $response['return_url'] = CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $inst->project_id . '/view';
                    } else {
                        $response['status'] = "error";
                    }
                    $cos->response->contentType = "application/json";
                    $this->template->assign( 'response', $response );
                } else {
                    $loc = CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $inst->project_id . '/view';
                    http\Http::redirect( $loc );
                }
            } else throw new sys\Exception( "Unknown class '$type'" );
        }

        return;
    }

    public function do_status( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $this->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        $status = $request->param( 'status', 'int' );
        if ( $id && $status ) {
            $res = data\Model::selectOne( $this->className, $id );
            $res->status = $status;
            $rec = $res->save();
            $response = Array();
            if ( $request->isXHR ) {
                if ( $rec ) {
                    $this->template = new mvc\Template( 'json-response' );
                    $response['status'] = "success";
                    $response['data']['status'] = (int) $res->status;
                } else {
                    $response['status'] = "error";
                }
                $cos->response->contentType = "application/json";
                $this->template->assign( 'response', $response );
            } else http\Http::redirect( $request->referer );
        } else Citrus\Citrus::pageNotFound();
    }

    public function do_dev( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $this->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        $dev_id = $request->param( 'dev_id', 'int' );
        if ( $id && $dev_id ) {
            $res = data\Model::selectOne( $this->className, $id );
            $res->developer_id = $dev_id;
            $rec = $res->save();
            $response = Array();
            if ( $request->isXHR ) {
                if ( $rec ) {
                    $this->template = new mvc\Template( 'json-response' );
                    $response['status'] = "success";
                    $response['data']['status'] = (int) $res->status;
                } else {
                    $response['status'] = "error";
                }
                $cos->response->contentType = "application/json";
                $this->template->assign( 'response', $response );
            } else http\Http::redirect( $request->referer );
        } else Citrus\Citrus::pageNotFound();
    }

    public function do__status_switch( $request ) {
        $cos = Citrus\Citrus::getInstance();
        $this->layout = false;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = data\Model::selectOne( $this->className, $id );
            // if ( $res->status == \core\tkr\Ticket::STATUS_WAITING ) 
                // $res->status = \core\tkr\Ticket::STATUS_ASSIGNED;
            $this->template->assign( 'res', $res );
            
        } else Citrus\Citrus::pageNotFound();
    }

    public function do_index( $request ) {
        $cos = Citrus\Citrus::getInstance();
        if ( $cos->user->isadmin != '1' ) {
            Citrus\Citrus::pageNotFound();
        } else parent::do_index( $request );
    }
}