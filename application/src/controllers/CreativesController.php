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

    use RedBeanPHP\R;
    use App\Common\Database;
    use App\Data\Service\CreativesService;

    class CreativesController {

        private $creatives_service;

        public function __construct() {
            $this->creatives_service = new CreativesService();
            R::setup(Database::$access['dsn'], Database::$access['user'], Database::$access['pass']);
            R::freeze(true);
        }

        public function getDemoCreatives() {
            $creatives_from_database = $this->creatives_service->getDemoCreatives();
            $creatives_for_response = array();
            foreach ($creatives_from_database as $creative_from_database) {
                $creative = new class() {
                    public $id;
                    public $title;
                    public $brief_description;
                    public $image_url;
                    public $event_date;
                    public $price;
                };
                $creative->id = $creative_from_database->getId();
                $creative->title = $creative_from_database->getTitle();
                $creative->brief_description = $creative_from_database->getBriefDescription();
                $creative->image_url = $creative_from_database->getImageUrl();
                $creative->event_date = $creative_from_database->getEventDate();
                $creative->price = $creative_from_database->getPrice();
                array_push($creatives_for_response, $creative);
            }
            return json_encode($creatives_for_response, JSON_UNESCAPED_UNICODE);
        }

        public function getCreativeById($id) {
            $creative_from_database = $this->creatives_service->getCreativeBydId($id);
            return json_encode($creative_from_database, JSON_UNESCAPED_UNICODE);
        }

    }

}