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

    use App\Common\Status;
    use App\Data\Service\AdvertisersService;

    class AdvertisersController extends Controller {

        private $advertisers_service;

        public function __construct() {
            parent::__construct();
            $this->advertisers_service = new AdvertisersService();
        }

        public function loginAdvertiser($advertiser) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->advertisers_service->loginAdvertiser($advertiser);
            if ($response->result == Status::$LOGIN_SUCCESS) {
                $one_month_tls = time() + 60 * 60 * 24 * 30;
                setcookie('username', $advertiser->getUsername(), $one_month_tls, '/', null, null, true); // httponly !!!
                setcookie('hash', $advertiser->getHash(), $one_month_tls, '/', null, null, true); // httponly !!!
            }

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