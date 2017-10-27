<?php
/**
 * JSONResponse
 *
 * @package Core-o-Graphy
 */

class JSONResponse extends Response {

    /**
     * __construct
     *
     * @package Core-o-Graphy
     */
    public function __construct ($content="") {
    
        // Force the content type
        $this->setContentType ('application/json; charset=utf-8');
        
        
        // Delegate
        parent::__construct ($content);
        
    }

}