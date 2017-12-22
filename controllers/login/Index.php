<?php

use CoreOGraphy\RepoUsers;

/**
 * Index
 *
 * This controllers handles the logic about the authentication
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
        
        
        // Has the form been submitted by the user?
        if (isset ($_POST['action']) && 'login-form' == $_POST['action']) {
            
            // Get a user repository 
            $repousers = new RepoUsers ();
            
            
            // Fetch user against the credentials introduced by the 
            // user
            $user = $repousers->getByEmailAndPassword ($_POST['email'], md5 ($_POST['password']));
            
            
            // No user?! Then check the error and load again the form
            if ( ! $user) {
                $_error = true;
                
            } else {
            
                // Store user in session
                $_SESSION['logged'] = true;
                $_SESSION['user_id'] = $user->getId ();
                
                
                // Redirect. As the user is now in session the URLs should 
                // be accessible
                header ('Location: ' . $_SERVER['REQUEST_URI']);
                die ();
            
            }
        }
        
        
        // Load the authentication form
        $this->_response->getBody ()->write ($this->_template->render ('login.html', ['error' => $_error]));
        
    }
}