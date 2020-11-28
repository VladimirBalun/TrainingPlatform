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

namespace App {

    use App\Controllers\AdvertisersController;
    use App\Data\Entity\AdvertiserEntity;
    use Bramus\Router\Router;
    use App\Controllers\CreativesController;
    use App\Controllers\MetaInformationController;

    require_once '../vendor/autoload.php';

    function validateCORSPolicy() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
        }
    }

    $router = new Router();

    $router->get('/meta', function() {
        validateCORSPolicy();
        $controller = new MetaInformationController();
        echo $controller->getAllMetaInformation();
    });

    $router->get('/cities', function() {
        validateCORSPolicy();
        $controller = new MetaInformationController();
        echo $controller->getCitiesByCountryName($_GET['country_name']);
    });

    $router->get('/demo_creatives', function() {
        validateCORSPolicy();
        $controller = new CreativesController();
        echo $controller->getDemoCreatives();
    });

    $router->get('/search_demo_creatives', function() {
        validateCORSPolicy();
        $controller = new CreativesController();
        echo $controller->getDemoCreativesByTitlePattern(urldecode($_GET['title_pattern']));
    });

    $router->get('/proposed_demo_creatives', function () {
        validateCORSPolicy();
        $controller = new CreativesController();
        echo $controller->getProposedDemoCreativesByCreativeId($_GET['creative_id'], $_GET['count']);
    });

    $router->get('/advertiser_demo_creative', function () {
        validateCORSPolicy();
        $controller = new CreativesController();
        echo $controller->getAdvertiserDemoCreativesByAdvertiserId($_GET['advertiser_id']);
    });

    $router->get('/creative', function() {
        validateCORSPolicy();
        $controller = new CreativesController();
        echo $controller->getCreativeById($_GET['creative_id']);
    });

    $router->get("/advertisers_check", function () {
        validateCORSPolicy();
        echo '{ "result" : true }';
    });

    $router->post("/advertisers_login", function () {
        validateCORSPolicy();
        $advertiser = new AdvertiserEntity();
        $advertiser->setEmail($_POST['email']);
        $advertiser->setPassword($_POST['password']);
        $controller = new AdvertisersController();
        echo $controller->loginAdvertiser($advertiser);
    });

    $router->post("/advertisers_signup", function () {
        validateCORSPolicy();
        $advertiser = new AdvertiserEntity();
        $advertiser->setUsername($_POST['username']);
        $advertiser->setEmail($_POST['email']);
        $advertiser->setPassword($_POST['password']);
        $controller = new AdvertisersController();
        echo $controller->signupAdvertiser($advertiser);
    });

    $router->run();
}