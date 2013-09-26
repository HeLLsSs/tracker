<?php

namespace apps\backend\modules\projects;
use \core\Citrus\mvc;
// use \core\Citrus;
use \core\Citrus\Citrus;
use \core\Citrus\data;
use \core\Citrus\mvc\Template;
use \core\Citrus\html\form\Form;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\Project';

    public function do_index( $request ) {
        // if ( $request->isXHR ) sleep(2);
        $schema = data\Model::getSchema( $this->className );
        $cos = Citrus::getInstance();
        
        if ( $schema ) {
            $pager_min = 5;
            $pager = new \core\Citrus\data\Pager( $schema->className, $pager_min );

            if ( $request->isXHR ) $this->layout = false;

            $origin     = $request->param( 'origin', 'string' );
            $search     = $request->param( 'search', 'string' );
            $order      = $request->param( 'order', 'string' );
            $orderType  = $request->param( 'orderType', 'string' );
            
            $where = array();

            if ( $search !== false ) {
                if ( $origin == "search-form" ) {
                    $this->template = new Template( '_index-list' );
                }
                foreach ( $schema->linkColumns as $cols ) {
                    $where[] = "$cols LIKE '%$search%'"; 
                }
            }
            $list = $pager->getCollection( 
                $where,
                isset( $order ) ? $order : false, 
                isset( $orderType ) ? $orderType : false
            );
            
            // $this->template = new Template( '_index-list' );
            $this->template->assign( 'search', $search );
            $this->template->assign( 'order', $order );
            $this->template->assign( 'orderType', $orderType );

            $this->template->assign( 'schema', $schema );
            $this->template->assign( 'list', $list );
            $this->template->assign( 'pager', $pager );
        }
        else Citrus::pageForbidden();
    }

    public function do_view( $request ) {
        $schema_product = data\Model::getSchema( $this->className );
        $this->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        $params = $request->param( 'filters', 'string' );
        if ( $params ) {
            $params = trim( $params, '/' );
            $params = explode( '/', $params );
            foreach ( $params as $f ) {
                list( $name, $value ) = explode( ':', $f );
                $filters[$name] = $value;
            }
            if ( count ( $filters ) ) $request->addParams( $filters );
        }

        if ( $id ) {
            $res = \core\Citrus\data\Model::selectOne( $this->className, $id );
            $this->template->assign( 'res', $res );
            $this->template->assign( 'schema_product', $schema_product );
            $this->template->assign( 'layout', $this->layout );

            $schema_tickets = data\Model::getSchema( '\core\tkr\Ticket' );
            $cos = Citrus::getInstance();

            if ( $schema_tickets ) {
                $pager_min = 20;
                $pager = new \core\Citrus\data\Pager( $schema_tickets->className, $pager_min );

                $origin     = $request->param( 'origin', 'string' );
                $search     = $request->param( 'search', 'string' );
                $order      = $request->param( 'order', 'string' );
                $orderType  = $request->param( 'orderType', 'string' );
                $status     = $request->param( 'status', 'array[int]' );
                $type       = $request->param( 'type', 'array[int]' );
                $priority   = $request->param( 'priority', 'array[int]' );

                $where = array();

                if ( $search !== false ) {
                    if ( $origin == "search-form" ) {
                        $this->template = new Template( '_tickets_list' );
                    }
                    foreach ( $schema_tickets->linkColumns as $cols ) {
                        $where[] = "$cols LIKE '%$search%'"; 
                    }
                }
                if ( $status && count( $status ) ) {
                    $where_status = Array();
                    foreach ( $status as $s )
                        $where_status[] = '`tkr_ticket`.`status` = ' . $s;
                    $where[] = '(' . implode( ' OR ', $where_status ) . ')';
                }

                if ( $type && count( $type ) ) {
                    $where_type = Array();
                    foreach ( $type as $s )
                        $where_type[] = '`tkr_ticket`.`type` = ' . $s;
                    $where[] = '(' . implode( ' OR ', $where_type ) . ')';
                }
                if ( $priority && count( $priority ) ) {
                    $where_prio = Array();
                    foreach ( $priority as $s )
                        $where_prio[] = '`tkr_ticket`.`priority` = ' . $s;
                    $where[] = '(' . implode( ' OR ', $where_prio ) . ')';
                }

                $list = $pager->getCollection( 
                    $where,
                    $order !== false ? $order : isset( $schema_tickets->orderColumn ) ? $schema_tickets->orderColumn : false, 
                    $orderType !== false ? $orderType : false
                );

                $this->template->assign( 'search', $search );
                $this->template->assign( 'order', $order );
                $this->template->assign( 'orderType', $orderType );

                $this->template->assign( 'schema_tkt', $schema_tickets );
                $this->template->assign( 'tickets', $list );
                $this->template->assign( 'pager', $pager );
            }

        } else Citrus::pageNotFound();
    }

    public function do_tickets( $request ) {
        
        // else Citrus::pageForbidden();
    }

    public function do_createTicket( $request ) {
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $project = \core\Citrus\data\Model::selectOne( $this->className, $id );
            if ( $project ) { 
                $cos = Citrus::getInstance();
                $schema = data\Model::getSchema( '\core\tkr\Ticket' );
                $this->layout = !$request->isXHR;
                $res = new \core\tkr\Ticket();
                $res->author_id = $cos->user->id;
                $res->project_id = $project->id;
                $res->author = $cos->user;
                $res->project = $project;
                $form = Form::generateForm( $res );
                $this->template->assign( 'res', $res );
                $this->template->assign( 'form', $form );
                $this->template->assign( 'schema', $schema );
                $this->template->assign( 'layout', $this->layout );

            } else Citrus::pageNotFound();
        } else Citrus::pageNotFound();
    }


    public function do_edit( $request ) {
        $schema = data\Model::getSchema( $this->className );
        $this->layout = !$request->isXHR;
        $id = $request->param( 'id', 'int' );
        if ( $id ) {
            $res = \core\Citrus\data\Model::selectOne( $this->className, $id );
        } else {
            $res = new $this->className();
        }
        $form = Form::generateForm( $res );
        
        $this->template->assign( 'res', $res );
        $this->template->assign( 'form', $form );
        $this->template->assign( 'schema', $schema );
        $this->template->assign( 'layout', $this->layout );
    }
}