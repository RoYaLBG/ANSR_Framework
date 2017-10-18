<?php

namespace DefaultApp\Controller;


use ANSR\Core\Controller\Controller;
use ANSR\Core\Annotation\Type\Route;
use ANSR\Core\Annotation\Type\Intercepted;
use DefaultApp\Interceptor\LoginRequiredInterceptor;
use DefaultApp\Interceptor\RoleRequiredInterceptor;

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

    /**
     * @Route("/intercepted", name="intercepted")
     *
     * @Intercepted("LoginRequiredInterceptor, RoleRequiredInterceptor")
     */
    public function intercepted()
    {
        return $this->view();
    }
}