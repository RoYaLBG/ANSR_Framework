<?php /** @var \ANSR\View\ViewInterface $view */ ?>

<h1>Register</h1>

<?php foreach ($view->getFlash('error') as $error): ?>
    <div style="color: red">
        Error: <b><?=$error;?></b>
    </div>
<?php endforeach; ?>

<form action="<?=$view->url("register_user_process");?>" method="post">
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
<p><a href="<?=$view->url("login");?>">Login</a></p>