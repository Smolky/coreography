<?php

namespace CoreOGraphy;

/**
 * BaseController
 *
 * @package Core-o-Graphy
 */
abstract class BaseController {


    /** @var $_template */
    protected $_template;
    
    
    /** @var $_container */
    protected $_container;
    
    
    /** @var response */
    protected $_response;
    
    
    /**
     * handleRequest
     *
     * This method has to be implemented by the controllers
     *
     * @package Core-o-Graphy
     */
    
    public abstract function handleRequest () ;
    
    
    /**
     * handles
     *
     * @package Core-o-Graphy
     */
    
    public function handle () {
        $this->handleRequest ();
        return $this->_response;
    }
    
    
    /**
     * __construct
     *
     * @package Core-o-Graphy
     */
    public function __construct () {
        
        // Reference container
        global $container;
        
        
        // Store
        $this->_container = $container;
        
       
        // Get class info for the current controller
        $class_info = new \ReflectionClass ($this);
        $class_path = dirname ($class_info->getFileName()); 
        $class_path = str_replace (getcwd (), '', $class_path);
        $class_path = trim ($class_path, '/');
        
        
        // Fetch template system
        if ($container['templates']) {
        
            $twig = $container['templates'];
            $loader = $container['loader'];
            $loader->addPath ($class_path . '/templates/');

            // Store
            $this->_template = $twig;
        
        }
        
        
        // Create response
        $this->_response = new \CoreOGraphy\Response ();

    }
}
