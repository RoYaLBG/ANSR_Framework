<?php

namespace ANSR\Models;

class TestModel extends Model {

    public function getByTitleAndPrice() {
        $this->getDb()->prepare("SELECT * FROM test WHERE title = ? AND price = ?");
        $this->getDb()->bindParam(array('ss', 'mobile devices', '20.000'));
        foreach ($this->getDb()->execute()->setFetch('test')->getContent('test') as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

}

