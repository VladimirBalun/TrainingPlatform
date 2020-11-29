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

namespace App\Data\DAO {

    use RedBeanPHP\R;
    use App\Data\Entity\AdvertiserEntity;

    class AdvertisersDAO {

        public function addAdvertiser($advertiser) {
            return R::exec(
                'INSERT INTO avertisers(username, email, password) 
                VALUES(:username, :email, :password)',
                [
                    'username' => $advertiser->getUsername(),
                    'email' => $advertiser->getEmail(),
                    'password' => $advertiser->getPassword()
                ]
            );
        }

        public function getAdvertiserById($id) {
            $database_advertiser = R::getRow(
                'SELECT image_url FROM advertisers WHERE id = ? LIMIT 1', [$id]);

            $advertiser = new AdvertiserEntity();
            $advertiser->setImageUrl($database_advertiser['image_url']);
            return $advertiser;
        }

        public function findAdvertiserByEmailAndByPassword($email, $password) {
            $advertisers = R::getAll(
                'SELECT id FROM advertisers 
                WHERE email = :email AND password = :password',
                ['email' => $email, 'password' => $password]);
            return !empty($advertisers);
        }

        public function findAdvertiserByUsername($username) {
            $advertisers = R::getAll('SELECT id FROM advertisers WHERE username = ?', [$username]);
            return !empty($advertisers);
        }

        public function findAdvertiserByEmail($email) {
            $advertisers = R::getAll('SELECT id FROM advertisers WHERE email = ?', [$email]);
            return !empty($advertisers);
        }

    }

}
