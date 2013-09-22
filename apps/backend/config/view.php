<?php

$this->view->setStyleSheets( array(
    'backend/backend.css',
	'backend/forms.css',
    'backend/bootstrap.min.css',
    'tracker.less',
) );

$this->view->addStyleSheet( 
    CITRUS_PROJECT_URL . 
    'js/jQuery/jquery-ui-1.8.6.custom/css/custom-theme/jquery-ui-1.8.6.custom.css' 
);

$this->view->setJavascriptFiles( array(
	'jQuery/jquery-1.7.1.min.js',
	'jQuery/jquery-ui-1.8.6.custom/js/jquery-ui-1.8.6.custom.min.js',
	'jQuery/jquery.ui.datepicker-fr.js',
	'jQuery/jquery.validate-fr.js',
    'less-1.4.1.min.js',
    // 'ckeditor/ckeditor.js',
    // 'ckeditor/adapters/jquery.js',
    'tinymce/js/tinymce/jquery.tinymce.min.js',
    'tinymce/js/tinymce/tinymce.min.js',
    'backend/form.js',
    'backend/listing.js',
    'backend/bootstrap.min.js',
    'backend/spin.min.js',
    'backend/cos-backend.js',
    'backend/fileuploader.js',
    'backend/Medias.js',
    'backend/backend.js',
    'tracker.js',
) );


if ( !isset( $cos ) ) $cos = \core\Citrus\Citrus::getInstance();
if ( $cos->debug ) {
    $this->view->addStyleSheet( '/citrus-debug/css/citrus.min.css' );
    $this->view->addStyleSheet( '/citrus-debug/css/font-awesome.min.css' );
    $this->view->addJavascript( '/citrus-debug/js/debug.js' );
}