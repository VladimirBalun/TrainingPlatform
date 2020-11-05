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

    use App\Data\Service\CitiesService;
    use RedBeanPHP\R;
    use App\Common\Database;
    use App\Data\Service\CountriesService;
    use App\Data\Service\EventThemesService;
    use App\Data\Service\EventCategoriesService;

    class MetaInformationController {

        private $cities_service;
        private $countries_service;
        private $event_themes_service;
        private $event_categories_service;

        public function __construct() {
            $this->cities_service = new CitiesService();
            $this->countries_service = new CountriesService();
            $this->event_themes_service = new EventThemesService();
            $this->event_categories_service = new EventCategoriesService();
            R::setup(Database::$access['dsn'], Database::$access['user'], Database::$access['pass']);
            R::freeze(true);
        }

        public function getAllMetaInformation() {
            $countries_from_database = $this->countries_service->getAllCountries();
            $event_themes_from_database = $this->event_themes_service->getAllThemes();
            $event_categories_from_database = $this->event_categories_service->getAllCategories();

            $response = new class($countries_from_database, $event_themes_from_database, $event_categories_from_database) {
                public $countries = array();
                public $themes = array();
                public $categories = array();

                public function __construct($countries_from_database, $event_themes_from_database, $event_categories_from_database) {
                    foreach ($countries_from_database as $country) {
                        array_push($this->countries, $country->getName());
                    }
                    foreach ($event_themes_from_database as $theme) {
                        array_push($this->themes, $theme->getName());
                    }
                    foreach ($event_categories_from_database as $category) {
                        array_push($this->categories, $category->getName());
                    }
                }

                public function toJson() {
                    return json_encode($this, JSON_UNESCAPED_UNICODE);
                }
            };

            return $response->toJson();
        }

        public function getCitiesByCountryName($country_name) {
            $cities_from_database = $this->cities_service->getCitiesByCountryName($country_name);
            $cities_response = array();
            foreach ($cities_from_database as $city) {
                array_push($cities_response, $city->getName());
            }
            return json_encode($cities_response, JSON_UNESCAPED_UNICODE);
        }

    }

}