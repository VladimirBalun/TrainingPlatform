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
    use App\Data\Service\AdvertisersService;
    use App\Data\Service\CreativesService;

    class AdvertisersController extends Controller {

        private $creatives_service;
        private $advertisers_service;

        public function __construct() {
            parent::__construct();
            $this->creatives_service = new CreativesService();
            $this->advertisers_service = new AdvertisersService();
        }

        public function getAdvertiserDemoCreativesByAdvertiserId($advertiser_id) {
            $creatives_from_database = $this->creatives_service->getAdvertiserDemoCreativesByAdvertiserId($advertiser_id);
            $creatives_for_response = array();
            foreach ($creatives_from_database as $creative_from_database) {
                $creative = new class() {
                    public $id;
                    public $title;
                    public $brief_description;
                    public $image_url;
                    public $event_date;
                    public $moderation_status;
                    public $moderation_text;
                };
                $creative->id = $creative_from_database->getId();
                $creative->title = $creative_from_database->getTitle();
                $creative->brief_description = $creative_from_database->getBriefDescription();
                $creative->image_url = $creative_from_database->getImageUrl();
                $creative->event_date = $creative_from_database->getEventDate();
                $creative->moderation_status = $creative_from_database->getModerationStatus();
                $creative->moderation_text = $creative_from_database->getModerationText();
                array_push($creatives_for_response, $creative);
            }

            $advertiser_from_database = $this->advertisers_service->getAdvertiserById($advertiser_id);

            $response = new class() {
                public $creatives;
                public $advertiser_image_url;
            };

            $response->creatives = $creatives_for_response;
            $response->advertiser_image_url = $advertiser_from_database->getImageUrl();
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function changeAdvertiserImageUrlById($id, $new_advertiser_image_url) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->advertisers_service->changeAdvertiserImageUrlById($id, $new_advertiser_image_url);
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }


        public function loginAdvertiser($advertiser) {
            $response = new class() {
                public $result;
            };
            $response->result = $this->advertisers_service->loginAdvertiser($advertiser);
            if ($response->result == Protocol::$LOGIN_SUCCESS) {
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