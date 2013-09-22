<?php

namespace apps\backend\modules\main;
use \core\Citrus\mvc;
use \core\Citrus;

class Controller extends mvc\Controller {
    public function do_index() {
        Citrus\http\Http::redirect( '/backend/projects/' );
    }
}