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

$app->get('/html/profilo', 'TaskController:getProfilo')->setName('html.profilo');
$app->post('/html/profilo', 'TaskController:postProfilo');

$app->get('/html/task', 'TaskController:getTask')->setName('html.task');
$app->post('/html/task', 'TaskController:postTask');

$app->get('/html/complettask', 'TaskController:getCompletTask')->setName('html.complettask');
$app->post('/html/complettask', 'TaskController:postCompletTask');

$app->get('/html/delettask', 'TaskController:getDeletTask')->setName('html.delettask');
$app->post('/html/delettask', 'TaskController:postDeletTask');

$app->get('/html/logout', 'TaskController:getLogout')->setName('html.logout');
$app->post('/html/logout', 'TaskController:postLogout');

$app->get('/html/deletecategory', 'TaskController:getDeleteCategory')->setName('html.deletecategory');
$app->post('/html/deletecategory', 'TaskController:postDeleteCategory');

$app->get('/html/category', 'TaskController:getCategory')->setName('html.category');
$app->post('/html/category', 'TaskController:postCategory');


