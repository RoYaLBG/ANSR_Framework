<?php /** @var \ANSR\View\ViewInterface $view */ ?>

<h1>Login</h1>

<?php foreach ($view->getFlash('error') as $error): ?>
    <div style="color: red">
        Error: <b><?=$error;?></b>
    </div>
<?php endforeach; ?>

<form action="<?=$view->url("login_process");?>" method="post">
    <div>
        Username:
        <input type="text" name="username"/>
    </div>
    <div>
        Password:
        <input type="password" name="password"/>
    </div>
    <div>
        <input type="submit" value="Login!"/>
    </div>
</form>
<p><a href="<?=$view->url("register_user");?>">Register</a></p>