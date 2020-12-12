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

    use App\Common\Protocol;
    use App\Data\Service\AuthorizationService;

    class AuthorizationController extends Controller {

        private $authorization_service;

        public function __construct() {
            parent::__construct();
            $this->authorization_service = new AuthorizationService();
        }

        public function loginAdvertiser($advertiser) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->authorization_service->loginAdvertiser($advertiser);
            if ($response->result == Protocol::$LOGIN_SUCCESS) {
                $one_month_tts = time() + 60 * 60 * 24 * 30;
                setcookie('username', $advertiser->getUsername(), $one_month_tts, '/', null, null, true); // httponly !!!
                setcookie('hash', $advertiser->getHash(), $one_month_tts, '/', null, null, true); // httponly !!!
            }

            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function signupAdvertiser($advertiser) {
            $response = new class() {
                public $result;
            };

            $response->result = $this->authorization_service->signupAdvertiser($advertiser);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

    }

}
