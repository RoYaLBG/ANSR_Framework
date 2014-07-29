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
    
    
    public function __construct($params, Post $post) {
        $this->_params = $params;
        $this->_post = $post;
    }
    
    /**
     * @return Post
     */
    public function getPost() {
        return $this->_post;
    }
    
    public function getParams() {
        return $this->_params;
    }
    
    public function getParam($param) {
        return $this->_params[$param];
    }
}