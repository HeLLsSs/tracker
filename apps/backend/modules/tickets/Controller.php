<?php

namespace apps\backend\modules\tickets;
use \core\Citrus\mvc;
use \core\Citrus;
use \core\Citrus\data;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\Ticket';

    public function do_edit() {
        $cos = Citrus\Citrus::getInstance();
        $schema = data\Model::getSchema( $this->className );
        $this->layout = !$this->request->isXHR;
        $id = $this->request->param( 'id', 'int' );
        if ( $id ) {
            $res = \core\Citrus\data\Model::selectOne( $this->className, $id );
        } else {
            $res = new $this->className();
            $res->author_id = $cos->user->id;
        }
        $res->generateForm();
        $this->template->assign( 'res', $res );
        $this->template->assign( 'schema', $schema );
        $this->template->assign( 'layout', $this->layout );
    }

    public function do_view() {
        $cos = Citrus\Citrus::getInstance();
        $schema = data\Model::getSchema( $this->className );
        $this->layout = !$this->request->isXHR;
        $id = $this->request->param( 'id', 'int' );
        if ( $id ) {
            $res = \core\Citrus\data\Model::selectOne( $this->className, $id );

            if ( $res ) {
                $this->template->assign( 'res', $res );
                $this->template->assign( 'schema', $schema );
                $this->template->assign( 'layout', $this->layout );

                $devColl = new data\ModelCollection( '\core\tkr\User' );
                $devColl->query->addWhere( 'isadmin = 1' );
                $devColl->query->addWhere( 'id <> ' . $cos->user->id );
                $devColl->fetch();
                $this->template->assign( 'devs', $devColl->items );
            } else Citrus\Citrus::pageNotFound();
        }
    }

    public function do_create() {
        $cos = Citrus\Citrus::getInstance();
        $schema = data\Model::getSchema( $this->className );
        $this->layout = !$this->request->isXHR;
        $res = new $this->className();
        $res->author_id = $cos->user->id;
        $res->generateForm();
        $this->template->assign( 'res', $res );
        $this->template->assign( 'schema', $schema );
        $this->template->assign( 'layout', $this->layout );
    }
}