<?php

/**
 * NotFound404
 *
 * @package Core-o-Graphy
 */
class NotFound404 extends CoreOGraphy\BaseController {

    /**
     * handleRequest
     *
     * @package Core-o-Graphy
     */
    public function handleRequest () {
        $this->_response->setStatus ('404 Not Found');
        $this->_response->setContent ($this->_template->render ('404.html'));
    }
}
