<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIColorsPutTest extends TestCase
{

    use DatabaseTransactions;

    public function testAPIColorsPutCanSpecificColorIdAllParameters()
    {
        $this->put('/api/colors/1', ['name' => 'newname', 'hexCode' => '#00bff0'])
            ->seeJsonContains(['name' => 'newname', 'hexCode' => '#00bff0']);
        $this->assertResponseStatus(200);

        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'newname', 'hexCode' => '#00bff0']);
        $this->assertResponseStatus(200);
    }

    public function testAPIColorsPutFailsForNonExistentColor()
    {
        $this->put('/api/colors/432', ['name' => 'new_name', 'hexCode' => '#00bff0'])
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsPutFailsForInvalidName()
    {
        $this->put('/api/colors/1', ['name' => 'new_name', 'hexCode' => '#00bff0'])
            ->seeJsonContains(['message' => 'Niepoprawne dane']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsPutFailsForInvalidHexCode()
    {
        $this->put('/api/colors/1', ['name' => 'newname', 'hexCode' => '#00bf32f0'])
            ->seeJsonContains(['message' => 'Niepoprawne dane']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsPutFailsForInvalidNameAndHexCode()
    {
        $this->put('/api/colors/1', ['name' => 'new_4name', 'hexCode' => '#00bf32f0'])
            ->seeJsonContains(['message' => 'Niepoprawne dane']);
        $this->assertResponseStatus(400);
    }
    public function testAPIColorsPutCanSpecificColorIdOnlyName()
    {
        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'aqua', 'hexCode' => '#00ffff']);
        $this->assertResponseStatus(200);

        $this->put('/api/colors/1', ['name' => 'newname'])
            ->seeJsonContains(['name' => 'newname', 'hexCode' => '#00ffff']);
        $this->assertResponseStatus(200);

        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'newname', 'hexCode' => '#00ffff']);
        $this->assertResponseStatus(200);
    }

    public function testAPIColorsPutCanSpecificColorIdOnlyHexCode()
    {
        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'aqua', 'hexCode' => '#00ffff']);
        $this->assertResponseStatus(200);

        $this->put('/api/colors/1', ['hexCode' => '#00fff3'])
            ->seeJsonContains(['name' => 'aqua', 'hexCode' => '#00fff3']);
        $this->assertResponseStatus(200);

        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'aqua', 'hexCode' => '#00fff3']);
        $this->assertResponseStatus(200);
    }

}
