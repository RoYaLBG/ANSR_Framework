<?php

namespace ANSR\Controllers;

class Test extends Controller {

    public function print_smth() {
        $this->getView()->title = "This is test view";
        $this->getView()->results = $this->getApp()->TestModel->getByTitleAndPrice();
    }

    public function another() {
        $this->getView()->title = "This is another action from the same controller";
        var_dump($this->getRequest()->getParams());
    }

}

