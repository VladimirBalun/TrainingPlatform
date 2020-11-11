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

namespace App\Controllers {

    use RedBeanPHP\R;
    use App\Common\Database;
    use App\Data\Service\AdvertisersService;

    class AdvertisersController {

        private $advertisers_service;

        public function __construct() {
            $this->advertisers_service = new AdvertisersService();
            R::setup(Database::$access['dsn'], Database::$access['user'], Database::$access['pass']);
            R::freeze(true);
        }

        public function loginAdvertiser($advertiser) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->advertisers_service->loginAdvertiser($advertiser);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function signupAdvertiser($advertiser) {
            $response = new class() {
                public $result;
            };

            $response->result = $this->advertisers_service->signupAdvertiser($advertiser);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

    }

}