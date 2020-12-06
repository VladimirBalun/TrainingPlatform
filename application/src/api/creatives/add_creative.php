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

use App\Controllers\CreativesController;
use App\Data\Entity\AdvertiserEntity;
use App\Data\Entity\CreativeEntity;

require_once '../../../vendor/autoload.php';

header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creative = new CreativeEntity();
    $creative->setId((int)$_POST['id']);
    $creative->setTitle($_POST['title']);
    $creative->setBriefDescription($_POST['briefDescription']);
    $creative->setDescription($_POST['description']);
    $creative->setCategory($_POST['category']);
    $creative->setTheme($_POST['theme']);
    $creative->setCountry($_POST['country']);
    $creative->setCity($_POST['city']);
    $creative->setEventDate((!empty($_POST['eventDate']) ? ($_POST['eventDate']) : (null)));
    $creative->setImageUrl($_POST['image']);
    $creative->setEmail($_POST['email']);
    $creative->setSite($_POST['site']);
    $creative->setPhone($_POST['number']);
    $creative->setPrice((int)$_POST['price']);
    $creative->setOnline((bool)$_POST['online']);

    $advertiser = new AdvertiserEntity();
    $advertiser->setId((int)$_POST['advertiser_id']);
    $creative->setAdvertiser($advertiser);

    $controller = new CreativesController();
    echo $controller->addCreative($creative);
}