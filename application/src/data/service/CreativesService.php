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

    use App\Data\DAO\CreativesDAO;

    class CreativesService {

        private $creatives_dao;

        function __construct() {
            $this->creatives_dao = new CreativesDAO();
        }

        public function getDemoCreativesByTitlePatternAndFilters($title_pattern, $filters) {
            return $this->creatives_dao->getDemoCreativesByTitlePatternAndFilters($title_pattern, $filters);
        }

        public function getAdvertiserDemoCreativesByAdvertiserId($advertiser_id) {
            return $this->creatives_dao->getAdvertiserDemoCreativesByAdvertiserId($advertiser_id);
        }

        public function getProposedDemoCreativesByCreativeId($creative_id, $count) {
            return $this->creatives_dao->getProposedDemoCreativesByCreativeId($creative_id, $count);
        }

        public function getCreativeById($id) {
            return $this->creatives_dao->getCreativeById($id);
        }

        public function addCreative($creative) {
            return $this->creatives_dao->addCreative($creative);
        }

        public function changeCreative($creative) {
            return $this->creatives_dao->changeCreative($creative);
        }

        public function removeCreativeById($creative_id) {
            return $this->creatives_dao->removeCreativeById($creative_id);
        }

    }

}