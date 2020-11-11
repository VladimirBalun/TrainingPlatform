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

    use App\Data\Entity\CityEntity;
    use PHPUnit\Framework\TestCase;

    class CityEntityTest extends TestCase {

        public function testInitialCityEntityState() {
            $city = new CityEntity();

            $this->assertEquals(null, $city->getId());
            $this->assertEquals(null, $city->getName());
        }

        public function testCityEntityState() {
            $city = new CityEntity();

            $city->setId(100);
            $this->assertEquals(100, $city->getId());

            $city->setName('Москва');
            $this->assertEquals('Москва', $city->getName());
        }

    }

}