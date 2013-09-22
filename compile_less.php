<?php

require 'core/lib/lessphp/lessc.inc.php';

try {
    lessc::ccompile( 'web/css/master.less', 'web/css/master.css' );
    lessc::ccompile( 'web/css/mobile.less', 'web/css/mobile.css' );
} catch ( Exception $ex ) {
    exit( 'lessc fatal error:<br />'.$ex->getMessage() );
}