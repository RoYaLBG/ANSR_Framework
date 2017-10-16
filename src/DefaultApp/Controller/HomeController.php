<?php

namespace DefaultApp\Controller;


use ANSR\Core\Controller\Controller;
use ANSR\Core\Annotation\Type\Route;

/**
 * @author Ivan Yonkov <ivanynkv@gmail.com>
 */
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