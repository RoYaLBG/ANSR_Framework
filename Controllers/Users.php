<?php

namespace ANSR\Controllers;

class Users extends Controller {

    public function register() {
        if ($this->getRequest()->getPost()) {
            if ($this->getApp()->UserModel->register(
                $this->getRequest()->getPost()->getParamm('username'),
                $this->getRequest()->getPost()->getParamm('email'),
                $this->getRequest()->getPost()->getParamm('password')
            )) {
                return $this->success();
            }

            return $this->error();
        }
    }

    public function login() {
        if ($this->getRequest()->getPost()) {
            if ($this->getApp()->UserModel->login(
                $this->getRequest()->getPost()->getParamm('username'),
                $this->getRequest()->getPost()->getParamm('password')
            )) {
                return $this->success();
            }

            return $this->error();
        }
    }

    public function view() {
        $id = $this->getRequest()->getParam('id');

        return $this->getApp()->UserModel->getUserById($id);
    }

    public function edit() {
        $id = $this->getRequest()->getParam('id');
        $params = $this->getRequest()->getPut()->getParams();

        return array_merge($params, [$id]);
    }

    public function delete() {
        return ['delete' => 'yes'];
    }
}

