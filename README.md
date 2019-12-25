# ANSR_Framework

ANSR Framework is a simple web application framework, yet advocating enterprise practices. It's highly inspired from the major players in
Java, .NET and PHP world, namely Spring, ASP.NET Core and Symfony.

# What do you get?

## Routing
You can route a web request to a specific class based function, when you decorate a function with the `@Route` annotation in the docblock.

## Model Binding
An automatic mapping of the request body to an object of certain class. No more manually handling the request (using superglobals is discouraged).

## Inversion of Control
The framework starts and then it loads your application, putting it in it's own control. It might sounds scary, but this way you do not need
to care about how and when objects are instantiated.

###
Dependency Injection
IoC leads to dependency injection. Whenever you need a certain business object, you just require it in the constructor or the function arguments.
ANSR Framework will do its work.

## Returning View's
If your application is classical server side rendered app, your actions (functions in your controllers) can return views with certain model.
Remember, we do not advocate the "bunch of variables assigned to view" practice. They need to be encapsulated in a class.

## Returning JSON
If your application is a Web API then you can feel free to return the a model as JSON.

# Intercepting Requests
You need a common logic for a bunch of requests, for instance checking whether the user is logged in? No more need to invoke one and the same
method everywhere. Just write an interceptor to `preHandle` the requests.

# Example
See an example of how the framework is used in [src/DefaultApp](https://github.com/RoYaLBG/ANSR_Framework/tree/master/src/DefaultApp)

# How to use it?
## Rewrite paths
You need to set a single point of execution - `index.php` and a folder for static resources `web`. It depends on your web server.
There's already built in runtime configuration for apache httpd (`.htaccess`), which can be used for testing purposes. Just copy the
framework folder somewhere in your document root and it will work.

## Register your application
Multiple application (bundles, modules, etc., ...) can reside in a single instance of the framework. What you need to do is as follows:

1. Create a new folder with your application in `src` folder. This will be the rootnamespace of your app, for instance create `ForumApp`
2. Create a class named the same way (`ForumApp`) which extends `ANSR\Core\FrameworkConsumer`
3. Go to `index.php` and inside the kernel booting callback:
```
$kernel->boot(function (\ANSR\Core\Application $app) {
   
});
```
Register your app using `$app->registerApplication('ForumApp');`

4. You are ready. The framework will now scan your application to build dependency graph and check for routes that reside there.

## Write your first controller
A controller is nothing more than just a class which holds functions which accepts the HTTP Request and are responsible to return an HTTP Response.
An HTTP Response is everything that is a subtype of [ANSR\Core\Http\Response\ResponseInterface](https://github.com/RoYaLBG/ANSR_Framework/blob/master/Core/Http/Response/ResponseInterface.php).
Currently we support `ViewResponse`, `JsonResponse`, `RedirectResponse` and a special internal type for the interceptor chain - `ActionInterceptedResponse`.
Feel free to contribute with more subtypes. However, let's return to creating controllers.

1. Create a folder inside `ForumApp` called `Controller`
2. Create a PHP Class inside `Controller` folder named `HomeController`
3. Make the class extends `ANSR\Core\Controller\Controller` so it can easily generate response and other handy functions will be there
4. Create a method named `index()`
5. Make it return an empty view response, e.g.:
```
    public function index()
    {
        return $this->view();
    }
```
6. Import the `@Route` annotation using `use ANSR\Core\Annotation\Type\Route;`
7. Decorate the method with this annotation using this docblock (write the following above the method definition)
```
    /**
     * @Route("/index", name="my_index")
     *
     * @return \ANSR\Core\Http\Response\ViewResponse
     */
```
8. You are ready with the controller, but what does this mean?
* `@Route("index"` means that everytime the user wants to access `yoursite.com/index` the framework will instantiate your controller
and invoke the `index()` method (passing it all arguments needed, if any, but that we will discuss later).
* `name="my_index"` means the route is named. Everytime you want to refer to this route, you use the name, not the path. Paths may change,
but we advise to not change names.
* `@return \ANSR\Core\Http\Response\ViewResponse` is just a standard PHPDoc for what the function is returning. You can omit it,
but smart IDEs like `PHPStorm` will warn you that the `@return` tag is missing.
* `return $this->view()` - the `view()` method comes from the `Controller` you have already extended. It invokes the [render](https://github.com/RoYaLBG/ANSR_Framework/blob/master/View/View.php#L49)
method in `ViewInterface` which in its only implementation tries to create a response from a `viewName`, if it's missing, it uses the
controller name for a folder and the method name for a file, to find a view inside `views` folder in your app folder. So in this example
it will try to find a file `src/ForumApp/views/home/index.php`. There's no such file, so we can create it.

## Create a view
A view is nothing more than a simple php file which is included in the context of the [ViewInterface::send()](https://github.com/RoYaLBG/ANSR_Framework/blob/master/Core/Http/Response/ViewResponse.php#L31) method. But since it's
included in this method, it means the file can benefit from the state of the method, having access to all of its local variables,
namely `$model` (containing the information sent from the controller) and `$view` (which is the `ViewInterface`).
But now let's make it simple:

1. Create a folder `views` in your `ForumApp` directory
2. Create then `home` folder there
3. And finally create `index.php` in the `home` folder
4. Just omit all the contents of the file and use it like a simple HTML file which has one line `<h1>Hello World</h1>`
5. You are ready. Open `your.site/index` and you will see `Hello World` in Heading 1 format

## Handling form submissions
Suppose we have a register form. Hey, why not have one, instead. 
1. Create a controller `UsersController` the same way as the home one
2. Create a method `register()` which will render the form:
```
    /**
     * @Route("/register", name="register", method="GET")
     *
     * @return ViewResponse
     */
    public function register()
    {
        return $this->view();
    }
```
If you are wondering what is the attribute `method="GET"` - this means that this method `register()` will be invoke only if the
request method is HTTP GET. For any other method, it won't be invoked. We highly recommended separation from GET and POST, so we will use
another method for handling the form submission.
3. Create a view in `src/ForumApp/views/users/register.php` which renders a form:
```
<h1>Register</h1>
<form action="<?=$view->url("register_handler");?>" method="post">
    <div>
        Username:
        <input type="text" name="username"/>
    </div>
    <div>
        Password:
        <input type="password" name="password"/>
    </div>
    <div>
        Confirm password:
        <input type="password" name="confirmPassword"/>
    </div>
    <div>
        <input type="submit" value="Register!"/>
    </div>
</form>
```
If you wonder what the hell is `<?=$view->url("register_handler");?>` you need to remember that view resides in the `ViewResponse::send()` method
and has access to the `$view` variable, which is [ViewInterface](https://github.com/RoYaLBG/ANSR_Framework/blob/master/View/ViewInterface.php). 
If you remembered that we will not use paths, but names, now it should make it clear. The `url()` method in `ViewInterface` receives a name
of a route and build the url (optionally, if it has path variables, as well). So `register_handler` will be our method that will handle
the form submission. It will be ocassionally on the same path, but this is not something the view should now.

4. It's highly recommended to use model binding for form submissions. The form from above has three fields - `username`, `password` and `confirmPassword`.
Create a the following file and folders in `src/ForumApp` -> `Model/Form/User/UserRegisterRequestModel.php`:
```
class UserRegisterRequestModel
{
    private $username;

    private $password;

    private $confirmPassword;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }
}
```

5. Now create a method in `UsersController` called `registerHandler` which accepts `UsersRegisterRequestModel` and returns a view with it
```
    /**
     * @Route("/register", name="register_handler", method="POST")
     *
     * @param UserRegisterRequestModel $model
     * @return ViewResponse
     */
    public function registerHandler(UserRegisterBindingModel $model)
    {
        return $this->view($model);
    }
```
6. Create a view `src/ForumApp/views/users/registerHandler.php` with the following content
```
<?php /** @var \ForumApp\Model\Form\User\UserRegisterRequestModel $model */ ?>

<h1>You registered with</h1>
<h2>Username <?= $model->getUsername(); ?></h2>
<h2>Password <?= $model->getPassword(); ?></h2>
```
7. Try to submit your form, it should print the request username and password

## Using a Database
We do not provide an ORM. There's thin layer over PDO which provides separation between statements and result sets.
It resides [here](https://github.com/RoYaLBG/ANSR_Framework/blob/master/Driver/PDODatabase.php) for MySQL and uses configuration for the connection.
You need to change the `Variables::$args` array to export `db.host`, `db.user` and so on to one you needed

1. You can inject `DatabaseInterface` object wherever you want (Controller's constructor or method signature) and start using it
2. But we highly recommend not to use database queries or any other application logic in the controllers. Leave them only for accepting
requests and building responses.
3. Use another layer for data access (e.g. repositories) - classes that solely do data access
4. Create `src/ForumApp/Model/Entity/User.php` which has only `username` and `password` fields
5. Create `src/ForumApp/Repository/UserRepositoryInterface.php` with the following content:
```
<?php

namespace ForumApp\Repository;

use ForumApp\Model\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user);
}
```

6. Create implementation `src/ForumApp/Repository/UserRepository.php` with the following content:
```
<?php

namespace ForumApp\Repository;

use ANSR\Driver\DatabaseInterface;
use ForumApp\Model\Entity\User;

class UserRepository implements UserRepositoryInterface 
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }
    
    public function save(User $user)
    {
        $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)")
            ->execute(
                [
                    $user->getUsername(),
                    $user->getPassword()
                ]
            );
    }
}
```

7. As we also highly recommen separation of the business logic from the data access, introduce a new layer of services for business logic.
Create `src/ForumApp/Service/UserServiceInterface.php` with the following content:
```
namespace ForumApp\Service;

use ForumApp\Model\Form\User\UserRegisterRequestModel;

interface UserServiceInterface
{
    public function register(UserRegisterRequestModel $user);
}
```

8. And its implementation `src/ForumApp/Service/UserService.php` with the following content:
```
<?php

namespace ForumApp\Service;

use ANSR\Core\Service\Encryption\EncryptionServiceInterface;
use ForumApp\Repository\UserRepositoryInterface;
use ForumApp\Model\Form\User\UserRegisterRequestModel;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EncryptionServiceInterface
     */
    private $encryptionService;

    public function __construct(UserRepositoryInterface $userRepository, EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    public function register(UserRegisterRequestModel $user)
    {
        $this->userRepository->save(
            new User(
                $user->getUsername(),
                $this->encryptionService->encrypt($user->getPassword())
            )
        );
        
        return true;
    }
}
```

As you might see, the application specific logic here is encrypting the password. This does not belong to the data access layer and also
the actual RDBMS insert does not belong to the business layer, so they are now separated.

9. Let's use the service in `registerHandler()`:
```
    /**
     * @Route("/register", name="register_handler", method="POST")
     *
     * @param UserServiceInterface $userService
     * @param UserRegisterRequestModel $model
     * @return RedirectResponse
     */
    public function registerHandler(UserServiceInterface $userService, UserRegisterRequestModel $model)
    {
        if ($model->getPassword() != $model->getConfirmPassword()) {
            $this->addFlash(SessionInterface::KEY_FLASH_ERROR, "Passwords mismatch");

            return $this->redirectToRoute("register");
        }

        if ($userService->register($model)) {
            $this->addFlash(SessionInterface::KEY_FLASH_SUCCESS, "Register successful");

            return $this->redirectToRoute("login");
        }

        $this->addFlash(SessionInterface::KEY_FLASH_ERROR, "Username already taken");

        return $this->redirectToRoute("register");
    }
 ```
 As you can see, since `UserServiceInterface` is ANSR managed object and so does the `UsersController::registerHandler` then the framework inject
 the object so you just use it there.
 `addFlash` is a handy method from `Controller` which creates flash messages - a message that persists only one request (after redirect).
 We highly recommend `Redirect after post` pattern.
 
 10. Now we need to change our register view a little bit to show the messages. Add before the form the following
 ```
<?php foreach ($view->getFlash('error') as $error): ?>
    <div style="color: red">
        Error: <b><?=$error;?></b>
    </div>
<?php endforeach; ?>
```

`getFlash()` gets you the bag inside a specific key, this time - `error`. When it is empty (no one said the last request `addFlash('error', 'some message')`
the foreach will not trigger and no messages will be shown. Once they are shown, they are disposed, so after a refresh you won't see them.

**Just to let you know, I've lied a little bit. There's kind of an ORM, but it's too loose for now. You can check it there: https://github.com/RoYaLBG/ANSR_Framework/tree/master/Core/Data**
You can use the ActiveRecord from `MySQLQueryBuilder` (only MySQL is supported now) to build queries instead of writing them manually.
**Feel free to contribute with other QueryBuilders**

# How does it all work

1. Every request hits one and the same script which acts like a front controller - `index.php`
2. `index.php` is responsible for a very certain work - to parse the HTTP Request and set basic information in order the application kernel to work
3. This basic information is as follows:
* Set up `http.host` variable
* Set up `http.uri` variable
* Instantiate one subtype of `ContainerInterface`, which will be used to store and locate dependencies
* Instantiate the application kernel `\ANSR\Core\Kernel` giving the `ContainerInterface
* Tell the Kernel what to do once the application starts (you can add more things here, now it says the kernel to load some of crucial 
objects needed for the application as dependencies such as annotation parsers, routers, query builders, autoloaders and so on)
* Eventually tell the kernel to add dependencies with higher priority than the annotations using `overrideAnnotationConfiguration()` method
* Of course, boot the kernel

4. The kernel now boots, which means
* Locate the `Application` with all its dependencies using the `ContainerInterface`
* Execute the delegate passed from `index.php` e.g. register applications (e.g. `ForumApp`)
* Pass the control to the `ANSR\Core\Application` instance via `start(WebApplicationProducerInterface)` method

5. The application now prepares to start
6. The application highly relies on configuration through annotations so it invokes the `process` method of `AnnotationProcessorInterface`
7. This procedure scans all class files in the framework including registered apps for annotations in the docblock
8. An annotation in the docblock is a special `@tag` that is a valid class, subtype of `ANSR\Core\Annotation\AnnotationInterface`
9. For this type checking is responsible `ANSR\Core\Annotation\Parser\AnnotationParseInterface` which parses the docblock and gives the control to `AnnotationTokenInterface`
10. The token interface produces `AnnotationBuilderInterface` so additional data can be set to the annotation (e.g. property such as `method` in `Route`; or `AnnotatedFileInfo`)
11. Any annotation is just metadata and does not execute logic by itself. It's either used by an external processor or by a strategy
12. The annotation processor is responsible for executing different execution strategies which already created by `AnnotationExecutionStrategyFactoryInterface`
13. For instance, once it parses a `@Route` annotation, it finds by convention `ANSR\Core\Annotation\Strategy\RouteExecutionStrategy` which is responsible
for parsing the URL for instance (as the URL might be a template e.g. `/users/{id}/books`) so it should parse all path variables and create a map with routing templates
for later usage (the `Router` will use this mape). But that's a costly operation to scan all over the files, so only the first request ever
scans for annotations, then each strategy creates a cache (files cache) in `/cache/` folder e.g. `/cache/routes.php` where is stored the map with
routes in the format:
```
REQUEST_METHOD => {
    'template' => {
          PATH => { 'controller' => '...', 'action' => '...', 'args' => [..], 'name' => '..' }
     },
     'name' => {
          NAME_ROUTE => { 'controller' => '...', 'action' => '...', 'args' => [..], 'template' => '..' }
     }
}
```
14. So either things are in the cache, or all execution strategies are executed, the control is given back to the `Application` class
15. The `Application` now tells the `ContainerInterface` to load all its dependencies from the cache `/cache/components.php`. This file was populated,
because from the above logic - the `@Component` annotation was found, its `ComponentExecutionStrategy` populated the cache with a map of 
```
INTERFACE => {
   PRIORITY => IMPLEMENTATION
}
```
16. The container loads them by `highest priority` in its internal map and gives the control back to `Application`
17. Application uses the producer `WebApplicationProducerInterface` that accepted as an argument in order to produce an object of `WebApplication`
18. Then it passes the control to the `start()` method of `WebApplication`
19. `WebApplication::start()` is responsible for calling the `RouterInterface` to dispatch the web request to a certain function, effectively calling it
and getting its returned `ResponseInterface`
20. The `dispatch()` method in the current `DefaultRouter` implementation is a bit complex
21. First it loads the routes from the cache 
22. Then it scan all the routes to match the request against them and find the most suitable one
23. If the request does not match any route, it loads default route
24. If no route is found at all, it raises an exception
25. If route is found, it now proceeds to scan the metainfo of the function to be execution
26. For instance, is there an authorization metainformation (which was taken from the `@Auth` annotation and put in to the cache)
27. If there is, it first asks the `AuthenticationServiceInterface` if the user `isLogged()`, if it is not, the router produces `RedirectResponse` to the login page
28. If the user is logged in, it checks in the `@Auth` info whether certain roles are needed. If there are, it asks `AuthenticationServiceInterface` whether the user `hasRole(role)`
29. If the user does not have the roles, the procedure is the same - a `RedirectResponse` is returned from the `dispatch()` method
30. If the user is logged in and has the needed roles, or no authentication or roles are needed, the `dispatch()` method proceeds
31. It proceeds to instantiate the controller, using the `ContainerInterface::resolve` method
32. The `resolve(abstraction/implementation` method recursively build up the dependencies as they might need dependencies deeply
33. Once the controller is instantiated, the `dispatch()` method needs to call the method
34. But the method might accept arguments: either path variables (e.g. `{id}`), form binding models or services)
35. There are a few rules here:
* If the argument is primitive - then it's a path variable
* If the argument is complex object, it asks the container
* If the container has this object - resolve it
* Otherwise try to build form binding model
36. Once the function is resolved, the `dispatch()` method checks whether `Interceptors` needs to be executed
37. If needed, it builds `InterceptorChain` and returns `ActionInterceptedResponse`
38. If not, it executes the `Controller::action` with the parameters from `35.` which produces `ResponseInterface` and returns it
39. Action back to `WebApplication` which received the returned response from `dispatch()`
40. `WebApplication` then executes `ResponseInterface::send()` method and the response is sent back to the user. Whoala - magic done!
