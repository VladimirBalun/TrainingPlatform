<?php

namespace App\Data\Entity {

    use PHPUnit\Framework\TestCase;

    class AdvertiserEntityTest extends TestCase {

        public function testInitialAdvertiserEntityState() {
            $advertiser = new AdvertiserEntity();

            $this->assertEquals(null, $advertiser->getId());
            $this->assertEquals(null, $advertiser->getUsername());
            $this->assertEquals(null, $advertiser->getEmail());
            $this->assertEquals(null, $advertiser->getPassword());
            $this->assertEquals(null, $advertiser->getHash());
        }

        public function testAdvertiserEntityState() {
            $Advertiser = new AdvertiserEntity();

            $Advertiser->setId(100);
            $this->assertEquals(100, $Advertiser->getId());

            $Advertiser->setUsername('Иванов');
            $this->assertEquals('Иванов', $Advertiser->getUsername());

            $Advertiser->setEmail('kirill.grev97@mail.ru');
            $this->assertEquals('kirill.grev97@mail.ru', $Advertiser->getEmail());

            $Advertiser->setPassword('qwerty12345');
            $this->assertEquals('qwerty12345', $Advertiser->getPassword());

            $Advertiser->setHash('IDontNow');
            $this->assertEquals('IDontNow', $Advertiser->getHash());
        }
    }

}