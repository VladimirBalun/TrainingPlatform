<?php

namespace App\Data\Entity;

use PHPUnit\Framework\TestCase;

class EventCategoryEntityTest extends TestCase{
    public function testInitialEventCategoryState(){
        $event = new EventCategoryEntity();

        $this->assertEquals(null, $event->getId());
        $this->assertEquals(null, $event->getName());
    }
    public function testEventCategoryState() {
        $event = new EventCategoryEntity();

        $event->setId(100);
        $this->assertEquals(100, $event->getId());

        $event->setName('Треннинг');
        $this->assertEquals('Треннинг', $event->getName());
    }
}
