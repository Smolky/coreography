<?php

use CoreOGraphy\RepoUsers;

/**
 * Index
 *
 * This controllers handles the logic about the registration
 * form of the application
 *
 * @package Core-o-Graphy
 */
class Index extends \CoreOGraphy\BaseController {
    
    /**
     * handleRequest
     *
     * @package Core-o-Graphy
     */
    public function handleRequest () {
        
        /** $_error Boolean States when the form is valid or not */
        $_error = false;
        
        
        // Get params for the request
        $params = $this->_request->getParsedBody ();
        
        
        // Has the form been submitted by the user?
        if (isset ($params['action']) && 'register-form' == $params['action']) {

            // Get params
            $email = filter_var ($params['email'], FILTER_SANITIZE_EMAIL);
            $password = $params['password'];        
        
            
            // Get a user repository 
            $repousers = new RepoUsers ();
            
            
            // Send an email to the user
            $send_email = new Email ('validate-account.html', ['link' => FULL_URL . 'validate?token=' . $uid]);
            $send_email->setTo ($email);
            $send_email->send ();            
            
            
        }
        
        
        // Load the authentication form
        $this->_response->getBody ()->write ($this->_template->render ('register.html', ['error' => $_error]));
        
    }
}