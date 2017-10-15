<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 10/15/2017
 * Time: 7:25 PM
 */

namespace ANSR\Core;


interface ApplicationDelegate
{
    public function __invoke(Application $app);
}