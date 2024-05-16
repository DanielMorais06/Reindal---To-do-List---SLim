<?php

$app->get('/', 'HomeController:index');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

$app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignIn');

$app->get('/html/New-Task', 'TaskController:getNewTask')->setName('new.task');
$app->post('/html/New-Task', 'TaskController:postNewTask');

