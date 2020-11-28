<?php

namespace App\Data\Entity;

use PHPUnit\Framework\TestCase;

class CreativeEntityTest extends TestCase{
    public function testInitialCreativeEntityState(){
        $creative = new CreativeEntity();

        $this->assertEquals(null, $creative->getId());
        $this->assertEquals(null, $creative->getTitle());
        $this->assertEquals(null, $creative->getBriefDescription());
        $this->assertEquals(null, $creative->getDescription());
        $this->assertEquals(null, $creative->getImageUrl());
        $this->assertEquals(null, $creative->getPrice());
        $this->assertEquals(null, $creative->getEventDate());
        $this->assertEquals(null, $creative->getCountry());
        $this->assertEquals(null, $creative->getCity());
        $this->assertEquals(null, $creative->getCategory());
        $this->assertEquals(null, $creative->getTheme());
        $this->assertEquals(null, $creative->getOnline());
        $this->assertEquals(null, $creative->getEmail());
        $this->assertEquals(null, $creative->getSite());
        $this->assertEquals(null, $creative->getPhone());
    }
        public
        function testCreativeEntityState()
        {
            $creative = new CreativeEntity();

            $creative->setId(100);
            $this->assertEquals(100, $creative->getId());

            $creative->setTitle('Иванов');
            $this->assertEquals('Иванов', $creative->getTitle());

            $creative->setBriefDescription('IDontNow');
            $this->assertEquals('IDontNow', $creative->getBriefDescription());

            $creative->setDescription('IDontNow');
            $this->assertEquals('IDontNow', $creative->getDescription());

            $creative->setImageUrl('TrainingPlatform\site\sources\assets\images');
            $this->assertEquals('TrainingPlatform\site\sources\assets\images', $creative->getImageUrl());

            $creative->setPrice('16000');
            $this->assertEquals('16000', $creative->getPrice());

            $creative->setEventDate('24.09.1997');
            $this->assertEquals('24.09.1997', $creative->getEventDate());

            $country = new CountryEntity();
            $country->setName('Россия');
            $creative->setCountry($country);
            $this->assertEquals('Россия', $creative->getCountry()->getName());

            $city = new CityEntity();
            $city->setName('Москва');
            $creative->setCity($city);
            $this->assertEquals('Москва', $creative->getCity()->getName());

            $category = new EventCategoryEntity();
            $category->setName('Семинар');
            $creative->setCategory($category);
            $this->assertEquals('Семинар', $creative->getCategory()->getName());

            $theme = new EventThemeEntity();
            $theme->setName('Психология');
            $creative->setTheme($theme);
            $this->assertEquals('Психология', $creative->getTheme()->getName());

            $creative->setOnline('true');
            $this->assertEquals('true', $creative->getOnline());

            $creative->setEmail('kirill.grev97@mail.ru');
            $this->assertEquals('kirill.grev97@mail.ru', $creative->getEmail());

            $creative->setSite('https://www.youtube.com/');
            $this->assertEquals('https://www.youtube.com/', $creative->getSite());

            $creative->setPhone('89622555878');
            $this->assertEquals('89622555878', $creative->getPhone());


        }
}
