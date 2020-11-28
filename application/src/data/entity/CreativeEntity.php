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

namespace App\Data\Entity {

    class CreativeEntity {

        private $id;
        private $title;
        private $brief_description;
        private $description;
        private $image_url;
        private $price;
        private $event_date;
        private $country;
        private $city;
        private $category;
        private $theme;
        private $online;
        private $email;
        private $site;
        private $phone;
        private $moderation_status;
        private $moderation_text;
        private $advertiser;

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getTitle() {
            return $this->title;
        }

        public function setTitle($title) {
            $this->title = $title;
        }

        public function getBriefDescription() {
            return $this->brief_description;
        }

        public function setBriefDescription($brief_description) {
            $this->brief_description = $brief_description;
        }

        public function getDescription() {
            return $this->description;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public function getImageUrl() {
            return $this->image_url;
        }

        public function setImageUrl($image_url) {
            $this->image_url = $image_url;
        }

        public function getPrice() {
            return $this->price;
        }

        public function setPrice($price) {
            $this->price = $price;
        }

        public function getEventDate() {
            return $this->event_date;
        }

        public function setEventDate($event_date) {
            $this->event_date = $event_date;
        }

        public function getCountry() {
            return $this->country;
        }

        public function setCountry($country) {
            $this->country = $country;
        }

        public function getCity() {
            return $this->city;
        }

        public function setCity($city) {
            $this->city = $city;
        }

        public function getCategory() {
            return $this->category;
        }

        public function setCategory($category) {
            $this->category = $category;
        }

        public function getTheme() {
            return $this->theme;
        }

        public function setTheme($theme) {
            $this->theme = $theme;
        }

        public function getOnline() {
            return $this->online;
        }

        public function setOnline($online) {
            $this->online = $online;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getSite() {
            return $this->site;
        }

        public function setSite($site) {
            $this->site = $site;
        }

        public function getPhone() {
            return $this->phone;
        }

        public function setPhone($phone) {
            $this->phone = $phone;
        }

        public function getModerationStatus() {
            return $this->moderation_status;
        }

        public function setModerationStatus($moderation_status) {
            $this->moderation_status = $moderation_status;
        }

        public function getModerationText() {
            return $this->moderation_text;
        }

        public function setModerationText($moderation_text) {
            $this->moderation_text = $moderation_text;
        }

        public function getAdvertiser() {
            return $this->advertiser;
        }

        public function setAdvertiser($advertiser) {
            $this->advertiser = $advertiser;
        }

    }

}