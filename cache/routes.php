<?php return array (
  'GET' => 
  array (
    'template' => 
    array (
      '/' => 
      array (
        'controller' => 'DefaultApp\\Controller\\HomeController',
        'action' => 'index',
        'args' => 
        array (
        ),
        'name' => 'home_index',
      ),
      '/intercepted' => 
      array (
        'controller' => 'DefaultApp\\Controller\\HomeController',
        'action' => 'intercepted',
        'args' => 
        array (
        ),
        'name' => 'intercepted',
      ),
      '/login' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'login',
        'args' => 
        array (
        ),
        'name' => 'login',
      ),
      '/users/register' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'register',
        'args' => 
        array (
        ),
        'name' => 'register_user',
      ),
      '/users/profile' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'profile',
        'args' => 
        array (
        ),
        'name' => 'user_profile',
      ),
      '/logout' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'logout',
        'args' => 
        array (
        ),
        'name' => 'logout',
      ),
      '/", name="home_index' => 
      array (
        'controller' => 'DefaultApp\\Controller\\HomeController',
        'action' => 'index',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/intercepted", name="intercepted' => 
      array (
        'controller' => 'DefaultApp\\Controller\\HomeController',
        'action' => 'intercepted',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/login", name="login", method="GET' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'login',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/login", name="login_process", method="POST' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'loginProcess',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/users/register", name="register_user", method="GET' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'register',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/users/register", name="register_user_process", method="POST' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'registerProcess',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/users/profile", name="user_profile", method="GET' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'profile',
        'args' => 
        array (
        ),
        'name' => '',
      ),
      '/logout", name="logout' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'logout',
        'args' => 
        array (
        ),
        'name' => '',
      ),
    ),
    'name' => 
    array (
      'home_index' => 
      array (
        'controller' => 'DefaultApp\\Controller\\HomeController',
        'action' => 'index',
        'args' => 
        array (
        ),
        'template' => '/',
      ),
      'intercepted' => 
      array (
        'controller' => 'DefaultApp\\Controller\\HomeController',
        'action' => 'intercepted',
        'args' => 
        array (
        ),
        'template' => '/intercepted',
      ),
      'login' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'login',
        'args' => 
        array (
        ),
        'template' => '/login',
      ),
      'register_user' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'register',
        'args' => 
        array (
        ),
        'template' => '/users/register',
      ),
      'user_profile' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'profile',
        'args' => 
        array (
        ),
        'template' => '/users/profile',
      ),
      'logout' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'logout',
        'args' => 
        array (
        ),
        'template' => '/logout',
      ),
    ),
  ),
  'POST' => 
  array (
    'template' => 
    array (
      '/login' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'loginProcess',
        'args' => 
        array (
        ),
        'name' => 'login_process',
      ),
      '/users/register' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'registerProcess',
        'args' => 
        array (
        ),
        'name' => 'register_user_process',
      ),
    ),
    'name' => 
    array (
      'login_process' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'loginProcess',
        'args' => 
        array (
        ),
        'template' => '/login',
      ),
      'register_user_process' => 
      array (
        'controller' => 'DefaultApp\\Controller\\UsersController',
        'action' => 'registerProcess',
        'args' => 
        array (
        ),
        'template' => '/users/register',
      ),
    ),
  ),
);