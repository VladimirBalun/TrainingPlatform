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
    use App\Data\Entity\CreativeEntity;

    class CreativesDAO {

        public function getDemoCreatives() {
            $database_creatives = R::getAll(
                'SELECT id, title, brief_description, image_url, event_date, price FROM creatives'
            );

            $creatives = array();
            foreach ($database_creatives as $database_creative) {
                $creative = new CreativeEntity();
                $creative->setId($database_creative['id']);
                $creative->setTitle($database_creative['title']);
                $creative->setBriefDescription($database_creative['brief_description']);
                $creative->setImageUrl($database_creative['image_url']);
                $creative->setEventDate($database_creative['event_date']);
                $creative->setPrice($database_creative['price']);
                array_push($creatives, $creative);
            }

            return $creatives;
        }

        public function getCreativeById($id) {
            $database_creative = R::getRow(
                'SELECT cr.title, cr.description, cr.image_url, cr.event_date, cr.price, 
                    cr.advertiser_site, cr.advertiser_email, cr.advertiser_phone, coun.name,
                    cit.name, cat.name, th.name
                FROM creatives cr
                LEFT JOIN countries coun ON cr.id_country = coun.id
                LEFT JOIN cities cit ON cr.id_city = cit.id
                LEFT JOIN categories cat ON cr.id_category = cat.id
                LEFT JOIN themes th ON cr.id_theme = th.id
                WHERE cr.id = ?
                LIMIT 1', [$id]
            );

            $creative = new CreativeEntity();
            $creative->setId($database_creative['id']);
            $creative->setTitle($database_creative['title']);
            $creative->setDescription($database_creative['description']);
            $creative->setImageUrl($database_creative['image_url']);
            $creative->setEventDate($database_creative['event_date']);
            $creative->setPrice($database_creative['price']);
            $creative->setEmail($database_creative['advertiser_site']);
            $creative->setSite($database_creative['advertiser_email']);
            $creative->setPhone($database_creative['advertiser_phone']);
            return $creative;
        }

    }

}
