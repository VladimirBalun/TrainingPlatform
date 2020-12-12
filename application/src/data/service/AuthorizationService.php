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

namespace App\Data\Service {

    use App\Common\Limits;
    use App\Common\Protocol;
    use App\Data\DAO\AdvertisersDAO;

    class AuthorizationService  {

        private $advertisers_dao;

        public function __construct() {
            $this->advertisers_dao = new AdvertisersDAO();
        }

        public function loginAdvertiser($advertiser) {
            return true;
        }

        public function signupAdvertiser($advertiser) {
            if (($advertiser->getUsername() == '') || (strlen($advertiser->getUsername()) > Limits::$USERNAME_MAX_SIZE)) {
                return Protocol::$SIGNUP_ERROR_INCORRECT_USERNAME;
            } else if (($advertiser->getEmail() == '') || (strlen($advertiser->getEmail()) > Limits::$EMAIL_MAX_SIZE)) {
                return Protocol::$SIGNUP_ERROR_INCORRECT_EMAIL;
            } else if (($advertiser->getPassword() == '') || (strlen($advertiser->getPassword()) != Limits::$DOUBLE_MD5_HASH_SIZE)) {
                return Protocol::$SIGNUP_ERROR_INCORRECT_PASSWORD;
            }

            $is_exists_username = $this->advertisers_dao->findAdvertiserByUsername($advertiser->getUsername());
            if ($is_exists_username) {
                return Protocol::$SIGNUP_ERROR_USERNAME_EXISTS;
            }

            $is_exists_email = $this->advertisers_dao->findAdvertiserByEmail($advertiser->getEmail());
            if ($is_exists_email) {
                return Protocol::$SIGNUP_ERROR_EMAIL_EXISTS;
            }

            $was_added_advertiser = $this->advertisers_dao->addAdvertiser($advertiser);
            if ($was_added_advertiser) {
                return Protocol::$SIGNUP_SUCCESS;
            } else {
                return Protocol::$SIGNUP_ERROR_UNKNOWN;
            }
        }
    }

}


