<?php 

#include 'lib/Curl.php';
#include 'lib/CurlExecFailedException.php';

namespace core\lib\minifiers;

class CSSMinifier {
    const MINIFIER_URL = "http://cssminifier.com/raw";

    public static function minify( $in, $out ) {
        if ( file_exists( $in ) ) {
            $data = file_get_contents( $in );
            $req = new \core\Citrus\http\Curl( self::MINIFIER_URL );
            $req->addPostData( 'input', "'$data'" );
            $minified = $req->doRequest();
            // echo urldecode($minified);exit;
            if ( is_dir( dirname( $out ) ) ) {
                file_put_contents( $out, trim( $minified, "'" ) );
            } else {
                throw new \core\Citrus\sys\Exception( "Output folder doesn't exist.\n" );   
            }
        } else throw new \core\Citrus\sys\Exception( "Input file doesn't exist.\n" );
    }

}