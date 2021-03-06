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

namespace Tests\data\entity {

    use App\Data\Entity\CountryEntity;
    use PHPUnit\Framework\TestCase;

    class CountryEntityTest extends TestCase {

        public function testInitialCountryEntityState() {
            $country = new CountryEntity();

            $this->assertEquals(null, $country->getId());
            $this->assertEquals(null, $country->getName());
        }

        public function testCityEntityState() {
            $country = new CountryEntity();

            $country->setId(100);
            $this->assertEquals(100, $country->getId());

            $country->setName('Россия');
            $this->assertEquals('Россия', $country->getName());
        }

    }

}
