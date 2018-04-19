<?php

use \CoreOGraphy\RepoUsers;
use \CoreOGraphy\BaseController;


/**
 * Index
 *
 * This controllers handles the logic about the authentication
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
        
        /** @var $_error Boolean States when the form is valid or not */
        $_error = false;
        
        
        /** @var $params Array Get params for the request */
        $params = $this->_request->getParsedBody ();
        
        
        /** @var $is_form_submited Boolean */
        $is_form_submited = isset ($params['action']) && 'login-form' == $params['action'];
        
        
        // Has the form been submitted by the user?
        if ($is_form_submited) {
            
            /** @var $email String The user email */
            $email = filter_var ($params['email'], FILTER_VALIDATE_EMAIL);
            
            
            /** @var $password String The user password */
            $password = filter_var ($params['password'], FILTER_UNSAFE_RAW);
            
            
            /** @var $repousers RepoUsers The user repository */
            $repousers = new RepoUsers ();
            
            
            /** @var $user User Fetch user against the credentials introduced by the user */
            $user = $repousers->getByEmailAndPassword ($email, md5 ($password));
            
            
            // No user?! Then check the error and load again the form
            if ( ! $user) {
                $_error = true;
                
            } else {
            
                // Store user in session
                $_SESSION['logged'] = true;
                $_SESSION['user_id'] = $user->getId ();
                
                
                // Redirect. 
                // As the user is now in session the URLs should 
                // be accessible
                header ('Location: ' . $_SERVER['REQUEST_URI']);
                die ();
            
            }
        }
        
        
        // Load the authentication form
        $this->_response->getBody ()->write ($this->_template->render ('login.html', ['error' => $_error]));
        
    }
}