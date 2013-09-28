<?php

namespace apps\backend\modules\comments;
use \core\Citrus\mvc;
use \core\Citrus\Citrus;
#use \core\Citrus\data;
use \core\Citrus\http;
#use \core\Citrus\html\form\Form;

class Controller extends mvc\ObjectController {
    public $className = '\core\tkr\Comment';

    public function do_save( $request ) {
        $this->layout = !$request->isXHR;
        $report = Array();
        $cos = Citrus::getInstance();
        if ( $request->method != 'POST' ) {
            if ( $cos->debug ) {
                throw new sys\Exception( 'Bad method request' );
            } else {
                Citrus::pageNotFound();
            }
        } else {
            $type = $this->className;

            if ( class_exists( $type ) ) {
                $inst = new $type();

                $inst->hydrateByFilters();
                $inst->content = nl2br( $inst->content );
                $rec = $inst->save();
                
                $loc = CITRUS_PROJECT_URL . $cos->app->name . '/tickets/' . $inst->ticket_id . '/comments';
                http\Http::redirect( $loc );
            } else throw new sys\Exception( "Unknown class '$type'" );
        }

        return;
    }
}
