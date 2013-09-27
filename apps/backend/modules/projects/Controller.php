<?php

namespace apps\backend\modules\projects;
use \core\Citrus\mvc;
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
            $project_ids = $cos->user->getProjectsIds();
            if ( $project_ids ) {
                $where[] = 'id IN (' . implode( ',', $project_ids ) . ')';
            }
            if ( !$project_ids && !$cos->user->isadmin ) {
                $list = Array();
            } else {

                $list = $pager->getCollection( 
                    $where,
                    isset( $order ) ? $order : false, 
                    isset( $orderType ) ? $orderType : false
                );
            }
            
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

        // "filters" is read in uri by the router
        // pattern example : /status:1,2/type:1/priority:3
        $params = $request->param( 'filters', 'string' );
        if ( $params ) {
            $params = explode( '/', trim( $params, '/' ) );

            foreach ( $params as $f ) {
                list( $name, $value ) = explode( ':', $f );
                $filters[$name][] = $value === false ? array() : $value;
            }
            if ( isset( $filters['page'] ) && count( $filters['page'] ) )
                $filters['page'] = $filters['page'][0];
            if ( count ( $filters ) ) $request->addParams( $filters );
        }

        if ( $id ) {
            // fetching project
            $res = \core\Citrus\data\Model::selectOne( $this->className, $id );
            $this->template->assign( 'res', $res );
            $this->template->assign( 'schema_product', $schema_product );
            $this->template->assign( 'layout', $this->layout );

            $schema_tickets = data\Model::getSchema( '\core\tkr\Ticket' );
            $cos = Citrus::getInstance();

            if ( $schema_tickets ) {
                $origin     = $request->param( 'origin', 'string' );
                $search     = $request->param( 'search', 'string' );
                $order      = $request->param( 'order', 'string' );
                $orderType  = $request->param( 'orderType', 'string' );
                $statuses   = $request->param( 'status', 'array[int]' );
                $types      = $request->param( 'type', 'array[int]' );
                $priorities = $request->param( 'priority', 'array[int]' );

                if ( $types === false ) $types = Array();
                if ( $statuses === false ) $statuses = Array();
                if ( $priorities === false ) $priorities = Array();

                $pager_min = 20;
                $pager = new \core\Citrus\data\Pager( $schema_tickets->className, $pager_min );

                // only tickets related to the project $res
                $where = Array(
                    'project_id = ' . $res->id
                );

                // search / filter parameters
                if ( $search !== false ) {
                    if ( $origin == "search-form" ) {
                        $this->template = new Template( '_tickets_list' );
                    }
                    foreach ( $schema_tickets->linkColumns as $cols ) {
                        $where[] = "$cols LIKE '%$search%'"; 
                    }
                }
                if ( $statuses && count( $statuses ) ) {
                    $where_status = Array();
                    foreach ( $statuses as $s )
                        $where_status[] = '`tkr_ticket`.`status` = ' . $s;
                    $where[] = '(' . implode( ' OR ', $where_status ) . ')';
                }

                if ( $types && count( $types ) ) {
                    $where_type = Array();
                    foreach ( $types as $s )
                        $where_type[] = '`tkr_ticket`.`type` = ' . $s;
                    $where[] = '(' . implode( ' OR ', $where_type ) . ')';
                }
                if ( $priorities && count( $priorities ) ) {
                    $where_prio = Array();
                    foreach ( $priorities as $s )
                        $where_prio[] = '`tkr_ticket`.`priority` = ' . $s;
                    $where[] = '(' . implode( ' OR ', $where_prio ) . ')';
                }


                // fetching tickets
                $list = $pager->getCollection( 
                    $where,
                    $order !== false ? $order : isset( $schema_tickets->orderColumn ) ? $schema_tickets->orderColumn : false, 
                    $orderType !== false ? $orderType : false
                );
                $this->template->assign( Array(
                    'pager'         => $pager,
                    'search'        => $search,
                    'order'         => $order,
                    'orderType'     => $orderType,
                    'schema_tkt'    => $schema_tickets,
                    'tickets'       => $list,
                    'statuses'      => $statuses,  
                    'types'         => $types,
                    'priorities'    => $priorities,
                ) );
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