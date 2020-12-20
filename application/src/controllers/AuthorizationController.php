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

    use App\Data\Service\AdvertisersService;
    use App\Data\Service\AuthorizationService;

    class AuthorizationController extends Controller {

        private $advertisers_service;
        private $authorization_service;

        public function __construct() {
            parent::__construct();
            $this->advertisers_service = new AdvertisersService();
            $this->authorization_service = new AuthorizationService();
        }

        public function identifyAdvertiser() {
            $response = new class() {
                public $result;
            };

            if (isset($_COOKIE['trainter_id']) and isset($_COOKIE['trainter_hash'])) {
                $response->result = $this->authorization_service->identifyAdvertiser($_COOKIE['trainter_id'], $_COOKIE['trainter_hash']);
            } else {
                $response->result = false;
            }

            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function loginAdvertiser($advertiser) {
            $response = new class() {
                public $status;
                public $advertiser_id;
            };

            $login_result = $this->authorization_service->loginAdvertiser($advertiser);
            if (isset($login_result['id']) and isset($login_result['hash'])) {
                $one_month_ttl = time() + 60 * 60 * 24 * 30;
                setcookie('trainter_id', $login_result['id'], $one_month_ttl, "/");
                setcookie('trainter_hash', $login_result['hash'], $one_month_ttl, "/");
            }

            $response->status = $login_result['status'];
            $response->advertiser_id = $login_result['id'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function logoutAdvertiser() {
            $one_month_tts = time() + 60 * 60 * 24 * 30;
            setcookie("trainter_id", "", time() - $one_month_tts, "/");
            setcookie("trainter_hash", "", time() - $one_month_tts, "/");

            $response = new class() {
                public $result;
            };
            $response->result = true;
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function signupAdvertiser($advertiser) {
            $response = new class() {
                public $status;
                public $advertiser_id;
            };

            $signup_result = $this->authorization_service->signupAdvertiser($advertiser);
            if (isset($signup_result['id']) and isset($signup_result['hash'])) {
                $one_month_ttl = time() + 60 * 60 * 24 * 30;
                setcookie('trainter_id', $signup_result['id'], $one_month_ttl, "/");
                setcookie('trainter_hash', $signup_result['hash'], $one_month_ttl, "/");
            }

            $response->status = $signup_result['status'];
            $response->advertiser_id = $signup_result['id'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

    }

}
