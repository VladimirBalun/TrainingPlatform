<?php

namespace App\Data\Entity;

use PHPUnit\Framework\TestCase;

class EventThemeEntityTest extends TestCase{
    public function testInitialEventThemeEntityState() {
        $theme = new EventThemeEntity();

        $this->assertEquals(null, $theme->getId());
        $this->assertEquals(null, $theme->getName());
    }
    public function testEventThemeEntityState() {
        $theme = new EventThemeEntity();

        $theme->setId(100);
        $this->assertEquals(100, $theme->getId());

        $theme->setName('Психология');
        $this->assertEquals('Психология', $theme->getName());
    }
}
