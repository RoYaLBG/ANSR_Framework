<?php

namespace ANSR\Controllers;

use ANSR\ModelStates\Person;

class Test extends Controller {

    public function print_smth() {
        $this->getView()->title = "This is test view";
        //$this->getView()->results = $this->getApp()->TestModel->getByTitleAndPrice();
    }

    public function another() {
        $this->getView()->title = "This is another action from the same controller";
        var_dump($this->getRequest()->getParams());
        return [
            "a" => "b",
            "b" => "c"
        ];
    }

    public function validatedView() {
        echo <<<EOL
<form action="validated" method="post">
    <input type="text" name="name"/>
    <input type="text" name="age"/>
    <input type="submit" />
</form>
EOL;
        return [];
    }

    public function invalidView() {
        echo <<<EOL
<form action="validated" method="post">
    <input type="text" name="name"/>
    <input type="text" name="ag1e"/>
    <input type="submit" />
</form>
EOL;
        return [];
    }

    public function noValidation() {
        echo <<<EOL
<form action="free" method="post">
    <input type="text" name="name"/>
    <input type="text" name="ag1e"/>
    <input type="submit" />
</form>
EOL;
        return [];
    }

    /**
     * @param Person $person
     * @return Person
     * @ModelValidation
     */
    public function validated(Person $person) {
        return ["name" => $person->getName(), "age" => $person->getAge()];
    }

    public function free() {
        return [333];
    }

}

