<?php

$app->get('/', 'HomeController:index');

$app->get('/html/signup', 'TaskController:getSignUp')->setName('html.signup');
$app->post('/html/signup', 'TaskController:postSignUp');

$app->get('/html/signin', 'TaskController:getSignIn')->setName('html.signin');
$app->post('/html/signin', 'TaskController:postSignIn');

$app->get('/html/New-Task', 'TaskController:getNewTask')->setName('new.task');
$app->post('/html/New-Task', 'TaskController:postNewTask');

$app->get('/html/New-Category', 'TaskController:getNewCategory')->setName('new.category');
$app->post('/html/New-Category', 'TaskController:postNewCategory');

