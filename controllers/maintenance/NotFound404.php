<?php

use \Zend\Diactoros\Response\JsonResponse;
use \CoreOGraphy\BaseController;


/**
 * NotFound404
 *
 * This controllers represents the 404 responses.
 *
 * @package Core-o-Graphy
 */
class NotFound404 extends BaseController {

    /**
     * handleRequest
     *
     * @package Core-o-Graphy
     */
    public function handleRequest () {
    
        /** @var $url String The request uri */
        $url = $this->_request->getRequestTarget ();
        
        
        // Detect the type of the request. checking if the API word 
        // is present
        if (false === strpos ($url, '/api/')) {
            
            // Render a 404 HTML page file
            $this->_response->getBody ()->write ($this->_template->render ('404.html.twig'));
            
        } else {
            
            // A JSON Response alerting that the method was not found
            $this->_response = new JsonResponse (['message' => 'Method not found']);
            
        }
        
        
        // Set 404 code
        $this->_response = $this->_response->withStatus (404);
        
    }
}
