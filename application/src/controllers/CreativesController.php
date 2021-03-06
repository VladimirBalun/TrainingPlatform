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

    use App\Data\Service\CreativesService;

    class CreativesController extends Controller {

        private $creatives_service;

        public function __construct() {
            parent::__construct();
            $this->creatives_service = new CreativesService();
        }

        public function getDemoCreativesByTitlePatternAndFilters($title_pattern, $filters) {
            $creatives_from_database = $this->creatives_service->getDemoCreativesByTitlePatternAndFilters($title_pattern, $filters);
            return $this->generateDemoCreativesResponse($creatives_from_database);
        }

        public function getProposedDemoCreativesByCreativeId($creative_id, $count) {
            $creatives_from_database = $this->creatives_service->getProposedDemoCreativesByCreativeId($creative_id, $count);
            return $this->generateDemoCreativesResponse($creatives_from_database);
        }

        private function generateDemoCreativesResponse($creatives_from_database) {
            $creatives_for_response = array();
            foreach ($creatives_from_database as $creative_from_database) {
                $creative = new class() {
                    public $id;
                    public $title;
                    public $brief_description;
                    public $image_url;
                    public $advertiser_image_url;
                    public $event_date;
                    public $price;
                    public $online;
                };
                $creative->id = $creative_from_database->getId();
                $creative->title = $creative_from_database->getTitle();
                $creative->brief_description = $creative_from_database->getBriefDescription();
                $creative->image_url = $creative_from_database->getImageUrl();
                $creative->advertiser_image_url = $creative_from_database->getAdvertiser()->getImageUrl();
                $creative->event_date = $creative_from_database->getEventDate();
                $creative->price = $creative_from_database->getPrice();
                $creative->online = $creative_from_database->getOnline();

                array_push($creatives_for_response, $creative);
            }
            return json_encode($creatives_for_response, JSON_UNESCAPED_UNICODE);
        }

        public function getCreativeById($id) {
            $creative_from_database = $this->creatives_service->getCreativeById($id);
            $creative_for_response = new class() {
                public $id;
                public $title;
                public $brief_description;
                public $description;
                public $image_url;
                public $event_date;
                public $price;
                public $email;
                public $phone;
                public $site;
                public $category;
                public $theme;
                public $country;
                public $city;
                public $online;
                public $moderation_status;
                public $advertiser_id;
                public $advertiser_hash;
                public $advertiser_image_url;
            };

            $creative_for_response->id = $creative_from_database->getId();
            $creative_for_response->title = $creative_from_database->getTitle();
            $creative_for_response->brief_description = $creative_from_database->getBriefDescription();
            $creative_for_response->description = $creative_from_database->getDescription();
            $creative_for_response->image_url = $creative_from_database->getImageUrl();
            $creative_for_response->event_date = $creative_from_database->getEventDate();
            $creative_for_response->price = $creative_from_database->getPrice();
            $creative_for_response->email = $creative_from_database->getEmail();
            $creative_for_response->phone = $creative_from_database->getPhone();
            $creative_for_response->site = $creative_from_database->getSite();
            $creative_for_response->online = $creative_from_database->getOnline();
            $creative_for_response->moderation_status = $creative_from_database->getModerationStatus();
            $creative_for_response->advertiser_id = $creative_from_database->getAdvertiser()->getId();
            $creative_for_response->advertiser_hash = $creative_from_database->getAdvertiser()->getHash();
            $creative_for_response->advertiser_image_url = $creative_from_database->getAdvertiser()->getImageUrl();
            $creative_for_response->category = $creative_from_database->getCategory()->getName();
            $creative_for_response->theme = $creative_from_database->getTheme()->getName();
            if ($creative_from_database->getCountry() != null) {
                $creative_for_response->country = $creative_from_database->getCountry()->getName();
            }
            if ($creative_from_database->getCity() != null) {
                $creative_for_response->city = $creative_from_database->getCity()->getName();
            }
            return json_encode($creative_for_response, JSON_UNESCAPED_UNICODE);
        }

        public function addCreative($creative) {
            $response = new class() {
                public $result;
                public $creative_id;
            };

            $result = $this->creatives_service->addCreative($creative);
            $response->result = $result['result'];
            $response->creative_id = $result['creative_id'];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function changeCreative($creative) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->creatives_service->changeCreative($creative);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function removeCreativeById($creative_id) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->creatives_service->removeCreativeById($creative_id);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

    }

}