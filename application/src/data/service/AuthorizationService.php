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
    use App\Common\Utils;
    use App\Data\DAO\AdvertisersDAO;

    class AuthorizationService  {

        private $advertisers_dao;

        public function __construct() {
            $this->advertisers_dao = new AdvertisersDAO();
        }

        public function identifyAdvertiser($id, $hash) {
            return $this->advertisers_dao->findAdvertiserByIdAndByHash($id, $hash);
        }

        public function loginAdvertiser($advertiser) {
            if (($advertiser->getEmail() == '') || (strlen($advertiser->getEmail()) > Limits::$EMAIL_MAX_SIZE)) {
                return array("status" => Protocol::$LOGIN_ERROR_INCORRECT_EMAIL);
            } else if (($advertiser->getPassword() == '') || (strlen($advertiser->getPassword()) != Limits::$DOUBLE_MD5_HASH_SIZE)) {
                return array("status" => Protocol::$LOGIN_ERROR_INCORRECT_PASSWORD);
            }

            $advertiser_from_database = $this->advertisers_dao->getAdvertiserByEmailAndByPassword($advertiser->getEmail(), md5($advertiser->getPassword()));
            if ($advertiser_from_database->getId() != null) {
                $hash = Utils::generateMD5();
                $result_hash_changing = $this->advertisers_dao->changeAdvertiserHashById($hash, $advertiser_from_database->getId());
                if ($result_hash_changing) {
                    return array("status" => Protocol::$LOGIN_SUCCESS, "id" => $advertiser_from_database->getId(), "hash" => $hash);
                } else {
                    return array("status" => Protocol::$LOGIN_ERROR_UNKNOWN, "id" => $advertiser_from_database->getId());
                }
            } else {
                return array("status" => Protocol::$LOGIN_ERROR_INCORRECT_EMAIL_OR_PASSWORD, "id" => $advertiser_from_database->getId());
            }
        }

        public function signupAdvertiser($advertiser) {
            if (($advertiser->getUsername() == '') || (strlen($advertiser->getUsername()) > Limits::$USERNAME_MAX_SIZE)) {
                return array("status" => Protocol::$SIGNUP_ERROR_INCORRECT_USERNAME);
            } else if (($advertiser->getEmail() == '') || (strlen($advertiser->getEmail()) > Limits::$EMAIL_MAX_SIZE)) {
                return array("status" => Protocol::$SIGNUP_ERROR_INCORRECT_EMAIL);
            } else if (($advertiser->getPassword() == '') || (strlen($advertiser->getPassword()) != Limits::$DOUBLE_MD5_HASH_SIZE)) {
                return array("status" => Protocol::$SIGNUP_ERROR_INCORRECT_PASSWORD);
            }

            $is_exists_username = $this->advertisers_dao->findAdvertiserByUsername($advertiser->getUsername());
            if ($is_exists_username) {
                return array("status" => Protocol::$SIGNUP_ERROR_USERNAME_EXISTS);
            }

            $is_exists_email = $this->advertisers_dao->findAdvertiserByEmail($advertiser->getEmail());
            if ($is_exists_email) {
                return array("status" => Protocol::$SIGNUP_ERROR_EMAIL_EXISTS);
            }

            $advertiser->setPassword(md5($advertiser->getPassword()));
            $was_added_advertiser = $this->advertisers_dao->addAdvertiser($advertiser);
            if ($was_added_advertiser) {
                $advertiser_from_database = $this->advertisers_dao->getAdvertiserByUsername($advertiser->getUsername());
                if ($advertiser_from_database->getId() != null) {
                    $hash = Utils::generateMD5();
                    $result_hash_changing = $this->advertisers_dao->changeAdvertiserHashById($hash, $advertiser_from_database->getId());
                    if ($result_hash_changing) {
                        return array("status" => Protocol::$SIGNUP_SUCCESS, "id" => $advertiser_from_database->getId(), "hash" => $hash);
                    } else {
                        return array("status" => Protocol::$SIGNUP_NEED_LOGIN, "id" => $advertiser_from_database->getId());
                    }
                } else {
                    return array("status" => Protocol::$SIGNUP_ERROR_UNKNOWN);
                }
            } else {
                return array("status" => Protocol::$SIGNUP_ERROR_UNKNOWN);
            }
        }
    }

}


