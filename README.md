A simple MVC Framework written in PHP 5.5 created by Ivan Yonkov (RoYaL) ivanynkv <at> gmail <dot> com

The framework has default router which routes actions in the pattern:

	/hostname/controller/action/
	
It also supports custom routes via the default router's `addRoute()` method. You specify the pattern which
matches the URI. The controller to be loaded. And the method to be invoked. Optionally you can specify the
request method upon which it should execute. The default is **GET|POST**. This way you can specify one and the
same pattern, but different request methods in order to use proper REST.

The **.htaccess** file content this rewrite rules. Your webserver has to be configured to rewrite urls.
(mod_rewrite for Apache)

To create a page, you need the following things:

- A controller in the Controllers folder which follows the namespace and extends Controller (i.e. `MyPage`)
- A non-static public method in it (i.e. `myFirstAction()`)
- A folder in Views directory which is named after the controller (`mypage`)
- An `index.php` file which contains the index action (i.e. if no params after `/hostname/mypage/`)
- A php page named after your action (`myfirstaction.php`)

Now **/hostname/mypage/myfirstaction/** will refer to this.

If you want to pass content from controller to view, use: `$this->getView()->variable_name = 'smth'`
In the view templates, use it like `<?= $this->variable_name; ?>`

You can add `<?php /* @var $this \ANSR\View */ ?>` at the top of each template, to recieve auto-completion
from your IDE. This will bring you an auto-completion of the public methods in the View object.

To use a Model:

- Create a model in **Models folder** which extends the **Model** abstract class (i.e. `ProductsModel`);
- Go to `App.php` in the base directory and add `@property \ANSR\Models\ProductsModel $ProductsModel` in
the class comments, to recieve auto-completion from the controller
- Add a non-static, public method which has business logic (`$this->getDb()` refers to the default db adapter)
- Go to the controller where you need the model and write `$this->getApp()->ProductsModel`
the IDE will show you the public methods in it.
- You might want to filter the return value then send it to the view.

You can switch the Framework to a **WEB SERVICE** mode. (Actually be default it is switched) By turning the Registry `WEB_SERVICE` to `true` in `index.php`. This way no views are rendered. The controllers' actions which can be accessed from outside should return arrays. The framework automatically turns this into json.

Thus, if you have a `MyController` with `myAction()` method in **WEB SERVICE** mode, which has `return ["username" => "me"];` When called from outside `mycontroller/myaction`, the output will be the string `["username":"me"]`

Feel free to change configurations of Database, Autoloading, Routing, etc (better add new classes)

