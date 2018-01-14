<?php

require_once 'Application.php';

$app = new Application;

$app->url = 'https://www.eliftech.com/school-task';

$data = $app->get();

$result = $app->calc($data->expressions);

var_dump($data->expressions);

var_dump($result);

var_dump($app->post(['id' => $data->id, 'results' => $result]));