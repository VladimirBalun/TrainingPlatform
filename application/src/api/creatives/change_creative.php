<?php

/*
 * Copyright 2018 Vladimir Balun
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use App\Common\Utils;
use App\Controllers\CreativesController;
use App\Data\Entity\CreativeEntity;

require_once '../../../vendor/autoload.php';

if (Utils::isTestEnvironment()) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
    header("Access-Control-Allow-Methods: GET, PUT, POST, OPTIONS");
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'),$put_vars);
    $creative = new CreativeEntity();
    $creative->setId((int)$put_vars['id']);
    $creative->setTitle($put_vars['title']);
    $creative->setBriefDescription($put_vars['briefDescription']);
    $creative->setDescription($put_vars['description']);
    $creative->setCategory($put_vars['category']);
    $creative->setTheme($put_vars['theme']);
    $creative->setCountry($put_vars['country']);
    $creative->setCity($put_vars['city']);
    $creative->setEventDate($put_vars['eventDate']);
    $creative->setImageUrl($put_vars['image']);
    $creative->setEmail($put_vars['email']);
    $creative->setSite($put_vars['site']);
    $creative->setPhone($put_vars['number']);
    $creative->setPrice((int)$put_vars['price']);
    $creative->setOnline((bool)$put_vars['online']);

    $controller = new CreativesController();
    echo $controller->changeCreative($creative);
}