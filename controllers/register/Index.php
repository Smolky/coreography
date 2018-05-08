<?php

use \CoreOGraphy\RepoUsers;
use \CoreOGraphy\BaseController;


/**
 * Index
 *
 * This controllers handles the logic about the registration
 * form of the application
 *
 * @package Core-o-Graphy
 */
class Index extends BaseController {
    
    /**
     * handleRequest
     *
     * @package Core-o-Graphy
     */
    public function handleRequest () {
        
        /** $_error Boolean States when the form is valid or not */
        $_error = false;
        
        
        /** @var $params Array Get params for the request */
        $params = $this->_request->getParsedBody ();
        
        
        /** @var $is_form_submited Boolean */
        $is_form_submited = isset ($params['action']) && 'register-form' == $params['action'];
        
        
        // Has the form been submitted by the user?
        if ($is_form_submited) {

            /** @var $email String The user email */
            $email = filter_var ($params['email'], FILTER_SANITIZE_EMAIL);
            
            
            /** @var $password String The user password */
            $password = $params['password'];
        
            
            /** @var $repousers RepoUsers The user repository */
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