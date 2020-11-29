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

    use App\Data\Entity\AdvertiserEntity;
    use App\Data\Entity\CityEntity;
    use App\Data\Entity\CountryEntity;
    use App\Data\Entity\EventCategoryEntity;
    use App\Data\Entity\EventThemeEntity;
    use RedBeanPHP\R;
    use App\Data\Entity\CreativeEntity;

    class CreativesDAO {

        public function getDemoCreatives() {
            $database_creatives = R::getAll(
                'SELECT cr.id, cr.title, cr.brief_description, cr.image_url, cr.event_date, 
                        cr.price, cr.is_online, ad.image_url as advertiser_image_url
                    FROM creatives cr
                    LEFT JOIN advertisers ad ON cr.id_advertiser = ad.id                    
                    WHERE moderation_status != 0'
            );

            return $this->fillDemoCreativesFromDatabase($database_creatives);
        }

        public function getDemoCreativesByTitlePattern($title_pattern) {
            $database_creatives = R::getAll(
                'SELECT cr.id, cr.title, cr.brief_description, cr.image_url, cr.event_date, 
                    cr.price, cr.is_online, ad.image_url as advertiser_image_url
                FROM creatives cr
                LEFT JOIN advertisers ad ON cr.id_advertiser = ad.id
                WHERE title LIKE ? AND moderation_status != 0',
                ['%' . $title_pattern . '%']
            );

            return $this->fillDemoCreativesFromDatabase($database_creatives);
        }

        /*
         * In the future need to use categories and themes
         * of the creatives for valid offers
         */

        public function getProposedDemoCreativesByCreativeId($creative_id, $count) {
            $database_creatives = R::getAll(
                'SELECT cr.id, cr.title, cr.brief_description, cr.image_url, cr.event_date, 
                    cr.price, cr.is_online, ad.image_url as advertiser_image_url
                FROM creatives cr
                LEFT JOIN advertisers ad ON cr.id_advertiser = ad.id
                WHERE cr.id != :id_creative AND moderation_status != 0
                LIMIT :count_creatives',
                ['id_creative' => $creative_id, 'count_creatives' => $count]
            );

            return $this->fillDemoCreativesFromDatabase($database_creatives);
        }

        private function fillDemoCreativesFromDatabase($database_creatives) {
            $creatives = array();
            foreach ($database_creatives as $database_creative) {
                $creative = new CreativeEntity();
                $creative->setId((int)$database_creative['id']);
                $creative->setTitle($database_creative['title']);
                $creative->setBriefDescription($database_creative['brief_description']);
                $creative->setImageUrl($database_creative['image_url']);
                $creative->setEventDate($database_creative['event_date']);
                $creative->setPrice((int)$database_creative['price']);
                $creative->setOnline((int)$database_creative['is_online']);

                $advertiser = new AdvertiserEntity();
                $advertiser->setImageUrl($database_creative['advertiser_image_url']);
                $creative->setAdvertiser($advertiser);

                array_push($creatives, $creative);
            }

            return $creatives;
        }

        public function getAdvertiserDemoCreativesByAdvertiserId($advertiser_id) {
            $database_creatives = R::getAll(
                'SELECT id, title, brief_description, image_url, event_date, moderation_status, moderation_text 
                FROM creatives
                WHERE id_advertiser = ?',
                [$advertiser_id]
            );

            $creatives = array();
            foreach ($database_creatives as $database_creative) {
                $creative = new CreativeEntity();
                $creative->setId($database_creative['id']);
                $creative->setTitle($database_creative['title']);
                $creative->setBriefDescription($database_creative['brief_description']);
                $creative->setImageUrl($database_creative['image_url']);
                $creative->setEventDate($database_creative['event_date']);
                $creative->setModerationStatus((int)$database_creative['moderation_status']);
                $creative->setModerationText($database_creative['moderation_text']);
                array_push($creatives, $creative);
            }

            return $creatives;
        }

        public function getCreativeById($id) {
            $database_creative = R::getRow(
                'SELECT cr.title, cr.brief_description, cr.description, cr.image_url, cr.event_date, cr.price, 
                    cr.advertiser_site, cr.advertiser_email, cr.advertiser_phone, coun.name as country_name,
                    cit.name as city_name, cat.name as category_name, th.name as theme_name, is_online,
                    moderation_status
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
            $creative->setBriefDescription($database_creative['brief_description']);
            $creative->setDescription($database_creative['description']);
            $creative->setImageUrl($database_creative['image_url']);
            $creative->setEventDate($database_creative['event_date']);
            $creative->setPrice($database_creative['price']);
            $creative->setEmail($database_creative['advertiser_email']);
            $creative->setSite($database_creative['advertiser_site']);
            $creative->setPhone($database_creative['advertiser_phone']);
            $creative->setOnline($database_creative['is_online']);
            $creative->setModerationStatus((int)$database_creative['moderation_status']);

            $category = new EventCategoryEntity();
            $category->setName($database_creative['category_name']);
            $creative->setCategory($category);

            $theme = new EventThemeEntity();
            $theme->setName($database_creative['theme_name']);
            $creative->setTheme($theme);

            if ($database_creative['city_name'] != null) {
                $city = new CityEntity();
                $city->setName($database_creative['city_name']);
                $creative->setCity($city);
            }

            if ($database_creative['country_name'] != null) {
                $country = new CountryEntity();
                $country->setName($database_creative['country_name']);
                $creative->setCountry($country);
            }

            return $creative;
        }

        public function addCreative($creative) {
            return R::exec(
                'INSERT INTO creatives(title, brief_description, description, image_url, 
	                price, event_date, is_online, advertiser_site, advertiser_email, advertiser_phone, id_advertiser,
                    id_country, id_city, id_category, id_theme) 
                VALUES (:title, :briefDescription, :description, :image,
	                :price, :eventDate, :online, :site, :email, :phone, 1,
                    (SELECT id FROM countries WHERE name = :country),
	                (SELECT id FROM cities WHERE name = :city),
	                (SELECT id FROM categories WHERE name = :category),
	                (SELECT id FROM themes WHERE name = :theme));  ',
                [
                    'title' => $creative->getTitle(),
                    'briefDescription' => $creative->getBriefDescription(),
                    'description' => $creative->getDescription(),
                    'category' => $creative->getCategory(),
                    'theme' => $creative->getTheme(),
                    'country' => $creative->getCountry(),
                    'city' => $creative->getCity(),
                    'eventDate' => $creative->getEventDate(),
                    'image' => $creative->getImageUrl(),
                    'email' => $creative->getEmail(),
                    'site' => $creative->getSite(),
                    'phone' => $creative->getPhone(),
                    'price' => $creative->getPrice(),
                    'online' => $creative->getOnline()
                ]
            );
        }

        public function removeCreativeById($creative_id) {
            return true;
        }

    }

}
