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

use App\Controllers\AdvertisersController;

require_once '../../../vendor/autoload.php';

header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
header("Access-Control-Allow-Methods: GET, PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'),$put_vars);
    $advertisers_controller = new AdvertisersController();
    echo $advertisers_controller->changeAdvertiserImageUrlById($put_vars['advertiser_id'], $put_vars['new_image_url']);
}