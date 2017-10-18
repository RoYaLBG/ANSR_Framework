<?php return array (
  'DefaultApp\\Controller\\HomeController' => 
  array (
    'intercepted' => 
    array (
      0 => 'DefaultApp\\Interceptor\\LoginRequiredInterceptor',
      1 => 'DefaultApp\\Interceptor\\RoleRequiredInterceptor',
    ),
  ),
);