<?php

namespace ANSR\Library\Request;

class Request {
    
    /**
     * @var array
     */
    private $_params;
    
    /**
     * @var Post
     */
    private $_post;

    /**
     * @var Put
     */
    private $_put;

    const TYPE_GET = 'GET';
    const TYPE_PUT = 'PUT';
    const TYPE_POST = 'POST';
    const TYPE_DELETE = 'DELETE';
    const TYPE_STANDARD = 'GET|POST';
    
    
    public function __construct($params, Post $post, Put $put) {
        $this->_params = $params;
        $this->_post = $post;
        $this->_put = $put;
    }
    
    /**
     * @return Post
     */
    public function getPost() {
        return $this->_post;
    }

    /**
     * @return Put
     */
    public function getPut() {
        return $this->_put;
    }
    
    public function getParams() {
        return $this->_params;
    }
    
    public function getParam($param) {
        return $this->_params[$param];
    }
}