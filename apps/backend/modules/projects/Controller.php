<?php

namespace apps\backend\modules\projects;
use \core\Citrus\mvc;
// use \core\Citrus;
use \core\Citrus\Citrus;
use \core\Citrus\data;
use \core\Citrus\mvc\Template;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\Project';

    public function do_view() {
        $schema = data\Model::getSchema( $this->className );
        $this->layout = !$this->request->isXHR;
        $id = $this->request->param( 'id', 'int' );
        if ( $id ) {
            $res = \core\Citrus\data\Model::selectOne( $this->className, $id );
        } else {
            $res = new $this->className();
        }
        $this->template->assign( 'res', $res );
        $this->template->assign( 'schema', $schema );
        $this->template->assign( 'layout', $this->layout );
    }

    public function do_tickets() {
        $className = '\core\tkr\Ticket';
        $schema = data\Model::getSchema( $className );
        $cos = Citrus::getInstance();
        if ( $schema ) {
            $pager_min = 5;
            $pager = new \core\Citrus\data\Pager( $schema->className, $pager_min );

            if ( $this->request->isXHR ) $this->layout = false;

            $origin     = $this->request->param( 'origin', 'string' );
            $search     = $this->request->param( 'search', 'string' );
            $order      = $this->request->param( 'order', 'string' );
            $orderType  = $this->request->param( 'orderType', 'string' );
            $status     = $this->request->param( 'status', 'array[int]' );
            $type       = $this->request->param( 'type', 'array[int]' );

            $where = array();

            if ( $search !== false ) {
                if ( $origin == "search-form" ) {
                    $this->template = new Template( '_bugs_list2' );
                }
                foreach ( $schema->linkColumns as $cols ) {
                    $where[] = "$cols LIKE '%$search%'"; 
                }
            }
            if ( $status && count( $status ) ) {
                $where_status = Array();
                foreach ( $status as $s ) {
                    $where_status[] = '`tkr_ticket`.`status` = ' . $s;
                }
                $where[] = '(' . implode( ' OR ', $where_status ) . ')';
            }

            if ( $type && count( $type ) ) {
                $where_type = Array();
                foreach ( $type as $s ) {
                    $where_type[] = '`tkr_ticket`.`type` = ' . $s;
                }
                $where[] = '(' . implode( ' OR ', $where_type ) . ')';
            }

            $list = $pager->getCollection( 
                $where,
                $order !== false ? $order : isset( $schema->orderColumn ) ? $schema->orderColumn : false, 
                $orderType !== false ? $orderType : false
            );

            $this->template->assign( 'search', $search );
            $this->template->assign( 'order', $order );
            $this->template->assign( 'orderType', $orderType );

            $this->template->assign( 'schema', $schema );
            $this->template->assign( 'list', $list );
            $this->template->assign( 'pager', $pager );
        }
        else Citrus::pageForbidden();
    }
}