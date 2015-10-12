<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIColorsPostTest extends TestCase
{

    use DatabaseTransactions;

    public function testAPIColorsPostFailsOnInvalidName()
    {
        $this->post('/api/colors', ['name' => '12321dfasda', 'hexCode' => '#FFFFFF'])
            ->seeJsonContains(['message' => 'Dane niepoprawne.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsPostFailsOnInvalidHexCode()
    {
        $this->post('/api/colors', ['name' => 'rendom', 'hexCode' => '#FFFFFFFX'])
            ->seeJsonContains(['message' => 'Dane niepoprawne.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsPostFailsOnDuplicateColor()
    {
        $this->post('/api/colors', ['name' => 'white', 'hexCode' => '#FFFFFF'])
            ->seeJsonContains(['message' => 'Dane niepoprawne.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsPostCanSuccessfullyAddColor()
    {
        $this->post('/api/colors', ['name' => 'random', 'hexCode' => '#ffe4b4'])
            ->seeJsonContains(['message' => 'Dodano kolor.']);
        $this->assertResponseStatus(200);
    }
}
