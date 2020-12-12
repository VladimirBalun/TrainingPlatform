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
                'INSERT INTO advertisers(username, email, password) 
                VALUES(:username, :email, :password)',
                [
                    'username' => $advertiser->getUsername(),
                    'email' => $advertiser->getEmail(),
                    'password' => $advertiser->getPassword()
                ]
            );
        }

        public function changeAdvertiserHashById($new_hash, $id) {
            return R::exec(
                'UPDATE advertisers SET hash = :new_hash WHERE id = :id_advertiser',
                ['id_advertiser' => $id, 'new_hash' => $new_hash]
            );
        }

        public function changeAdvertiserImageUrlById($id, $new_advertiser_image_url) {
            return R::exec(
                'UPDATE advertisers SET image_url = :image_url WHERE id = :id_advertiser',
                ['id_advertiser' => $id, 'image_url' => $new_advertiser_image_url]
            );
        }

        public function getAdvertiserByUsername($username) {
            $database_advertiser = R::getRow(
                'SELECT id FROM advertisers WHERE username = ? LIMIT 1', [$username]);

            $advertiser = new AdvertiserEntity();
            $advertiser->setId($database_advertiser['id']);
            return $advertiser;
        }

        public function getAdvertiserById($id) {
            $database_advertiser = R::getRow(
                'SELECT image_url FROM advertisers WHERE id = ? LIMIT 1', [$id]);

            $advertiser = new AdvertiserEntity();
            $advertiser->setImageUrl($database_advertiser['image_url']);
            return $advertiser;
        }

        public function getAdvertiserByEmailAndByPassword($email, $password) {
            $database_advertiser = R::getRow(
                'SELECT id FROM advertisers 
                WHERE email = :email AND password = :password LIMIT 1',
                ['email' => $email, 'password' => $password]);

            $advertiser = new AdvertiserEntity();
            if (!empty($database_advertiser)) {
                $advertiser->setId($database_advertiser['id']);
            }
            return $advertiser;
        }

        public function findAdvertiserByIdAndByHash($id, $hash) {
            $database_advertiser = R::getRow('SELECT id FROM advertisers 
                WHERE id = :id_advertiser AND hash = :hash LIMIT 1',
                ['id_advertiser' => $id, 'hash' => $hash]);
            return !empty($database_advertiser);
        }

        public function findAdvertiserByUsername($username) {
            $database_advertiser = R::getRow('SELECT id FROM advertisers WHERE username = ? LIMIT 1', [$username]);
            return !empty($database_advertiser);
        }

        public function findAdvertiserByEmail($email) {
            $database_advertiser = R::getRow('SELECT id FROM advertisers WHERE email = ? LIMIT 1', [$email]);
            return !empty($database_advertiser);
        }

    }

}
