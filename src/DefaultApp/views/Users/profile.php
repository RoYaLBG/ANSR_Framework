<?php /** @var \ANSR\View\ViewInterface $view */ ?>
<?php /** @var \DefaultApp\Model\View\UserProfileViewModel $model */ ?>

<h1>Profile</h1>

<h2>Welcome <?= $model->getUsername(); ?></h2>

<p><a href="<?=$view->url("logout");?>">Logout</a></p>