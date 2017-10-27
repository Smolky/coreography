<?php 

namespace CoreOGraphy;

/**
 * Response
 *
 * @package Core-o-Graphy
 */

class Response {

    /** @var $_content String */
    private $_content;
    
    
    /** @var $_content_type String */
    private $_content_type = 'text/html; charset=utf-8';
    
    
    /** @var $_status String */
    private $_status;
    
    
    /** @var $_headers */
    private $_headers = array ();
    
    
    /**
     * __construct
     *
     * @package Core-o-Graphy
     */
    public function __construct ($content="") {
        $this->setContent ($content);
    }
    
    
    
    /**
     * getContentType
     *
     * @return String
     *
     * @package Core-o-Graphy
     */
    public function getContentType () {
        return $this->_content_type;
    }    
    
    /**
     * setContentType
     *
     * @package Core-o-Graphy
     */
    public function setContentType ($content_type) {
        $this->_content_type = $content_type;
    }    

    
    /**
     * setContent
     *
     * @package Core-o-Graphy
     */
    public function setContent ($content) {
        if (is_array ($content)) {
            $this->_content = json_encode ($content, true);
        } else {
            $this->_content = $content;
        }        
        
    }
    
    
    /**
     * getStatus
     *
     * @return String
     *
     * @package Core-o-Graphy
     */
    public function getStatus () {
        return $this->_status;
    }        
    
    /**
     * setStatus
     *
     * @package Core-o-Graphy
     */
    public function setStatus ($status) {
        $this->_status = $status;
    }    
    
    
    /**
     * addHeader
     *
     * @param $header String
     *
     * @package Core-o-Graphy
     */
    public function addHeader ($header) {
        $this->_headers[] = $header;
    }    
    
    
    /**
     * __toString
     *
     * @package Core-o-Graphy
     */
    public function __toString () {
    
        // Set status
        if ($this->getStatus ()) {
            header ($_SERVER["SERVER_PROTOCOL"] . ' ' . $this->getStatus ());
        }
        
    
        // Set headers
        header ('Content-Type: ' . $this->getContentType ());
        foreach ($this->_headers as $_header) {
            header ($_header);
        } 
        
        
        // Cache headers
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {


            // set last-modified header
            header ('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
            header ('Cache-Control: public');
        }
        
        
        // Return content
        return $this->_content;
    }

}