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
    use App\Data\Entity\CountryEntity;

    class CitiesDAO {

        public function getCitiesByCountryName($country_name) {
            $database_countries = R::getAll(
                'SELECT cit.id, cit.name 
                FROM cities cit
                LEFT JOIN countries con ON cit.id_country = con.id
                WHERE con.name = :country_name',
                ['country_name' => $country_name]
            );

            $countries = array();
            foreach ($database_countries as $database_country) {
                $country = new CountryEntity();
                $country->setId($database_country['id']);
                $country->setName($database_country['name']);
                array_push($countries, $country);
            }

            return $countries;
        }

    }

}
