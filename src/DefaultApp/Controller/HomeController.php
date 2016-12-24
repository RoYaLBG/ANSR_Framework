<?php
/**
 * Created by IntelliJ IDEA.
 * User: RoYaL
 * Date: 12/24/2016
 * Time: 1:21 AM
 */

namespace DefaultApp\Controller;


use ANSR\Core\Controller\Controller;
use ANSR\Core\Annotation\Type\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_index")
     *
     * @return \ANSR\Core\Http\Response\ViewResponse
     */
    public function index()
    {
        return $this->view("src/DefaultApp/views/home/index");
    }
}