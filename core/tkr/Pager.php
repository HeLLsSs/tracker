<?php
namespace core\tkr;
use \core\Citrus\data;
use \core\Citrus\Citrus;

class Pager extends data\Pager {
    public function renderPagesLinks( $start, $end, $extParam ) {
        $html = '';
        $cos = Citrus::getInstance();
        $search = $cos->request->param( 'search', 'string' );
        $order = $cos->request->param( 'order', 'string' );
        $orderType = $cos->request->param( 'orderType', 'string' );
        $loc = CITRUS_PROJECT_URL . "{$cos->app->name}/{$cos->app->controller->name}/{$cos->app->controller->action}";

        
        for ( $i = $start; $i <= $end; $i++ ) {
            if ( $i == $this->currentPage ) {
                $html .= '<li class="active"><a href="#">' . $i . '</a></li>';
            } else {
                $html .= '<li><a href="page:' . $i . '">' . $i . '</a><li>';
            }
            $html .= ' ';
        }
        return $html;
    }
    
    
    /**
     * Displays start button links (first, previous)
     *
     * @return  string  $html  HTML for links
     */
    public function renderStartButtons( $extParam ) {
        $html = '';
        $cos = Citrus::getInstance();
        $search = $cos->request->param( 'search', 'string' );
        $order = $cos->request->param( 'order', 'string' );
        $orderType = $cos->request->param( 'orderType', 'string' );
        $loc = CITRUS_PROJECT_URL . "{$cos->app->name}/{$cos->app->controller->name}/{$cos->app->controller->action}";
        
        if ( $this->currentPage != 1 ) {
            $html .= '<li>' . link_to( 
                $loc . '/page/1' .
                    ( $search ? '/search/'.$search : '' ) .
                    ( $order ? '/order/' . $order : '' ) . 
                    ( $orderType ? '/orderType/'.$orderType : '' ),
                '‹‹'
            ) . '</li>';
            $prev = $this->currentPage - 1;
            $html .= '<li>' . link_to( 
                $loc . '/page/' . $prev . 
                    ( $search ? '/search/'.$search : '' ) .
                    ( $order ? '/order/' . $order : '' ) . 
                    ( $orderType ? '/orderType/'.$orderType : '' ),
                '‹'
            ) . '</li>';
        }
        return "$html";
    }
    
    
    /**
     * Displays end of pagination links (next, last)
     *
     * @return  string  $html  HTML for links
     */
    public function renderEndButtons( $extParam ) {
        $html = '';
        $cos = Citrus::getInstance();
        $search = $cos->request->param( 'search', 'string' );
        $order = $cos->request->param( 'order', 'string' );
        $orderType = $cos->request->param( 'orderType', 'string' );
        $loc = CITRUS_PROJECT_URL . "{$cos->app->name}/{$cos->app->controller->name}/{$cos->app->controller->action}";
        
        if ( $this->currentPage != $this->nbPages ) {
            $next = $this->currentPage + 1;
            // $html = '<li>'
            $html .= '<li>' . link_to( 
                $loc . '/page/' . $next . 
                    ( $search ? '/search/'.$search : '' ) .
                    ( $order ? '/order/' . $order : '' ) . 
                    ( $orderType ? '/orderType/'.$orderType : '' ),
                '›' 
            ) . '</li>';
    
            $html .= '<li>' . link_to( 
                $loc . '/page/' . $this->nbPages . 
                    ( $search ? '/search/'.$search : '' ) .
                    ( $order ? '/order/' . $order : '' ) . 
                    ( $orderType ? '/orderType/'.$orderType : '' ), 
                '››'
            ) . '</li>';
        }
        return $html;
    }
}