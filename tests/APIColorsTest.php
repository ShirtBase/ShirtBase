<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIColorsTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Check if /colors endpoint responds with 200 HTTP status code
     *
     * @return void
     */
    public function testAPIColorsRespondsSuccessfully()
    {
        $this->visit('/api/colors')
            ->assertResponseOk();
    }

    /**
     * Check if /colors endpoint contains valid JSON data
     *
     * @return void
     */
    public function testAPIColorsContainsJSON()
    {
        $response = $this->visit('/api/colors')->getActualOutput();
        json_decode($response);
        $errorCode = json_last_error();
        $this->assertTrue($errorCode === JSON_ERROR_NONE);
    }

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

    public function testAPIColorsFailsOnDuplicateColor()
    {
        $this->post('/api/colors', ['name' => 'white', 'hexCode' => '#FFFFFF'])
            ->seeJsonContains(['message' => 'Dane niepoprawne.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsCanSuccessfullyAddColor()
    {
        $this->post('/api/colors', ['name' => 'random', 'hexCode' => '#ffe4b4'])
            ->seeJsonContains(['message' => 'Dodano kolor.']);
        $this->assertResponseStatus(200);
    }

    public function testAPIColorsFailsOnGetInvalidColorId()
    {
        $this->get('/api/colors/937')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsCanGetSpecificColorId()
    {
        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'aqua']);
        $this->assertResponseStatus(200);
    }

    public function testAPIColorsCanDeleteSpecificColorId()
    {
        $this->delete('/api/colors/1')
            ->seeJsonContains(['message' => 'Usunięto kolor.']);
        $this->assertResponseStatus(200);

        $this->get('/api/colors/1')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsFailOnDeleteInvalidColorId()
    {
        $this->get('/api/colors/4234')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);

        $this->delete('/api/colors/4234')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }
    //Test delete on nonexistent id

    public function testAPIColorsCanUpdateSpecificColorIdAllParameters()
    {
        $this->put('/api/colors/1', ['name' => 'newname', 'hexCode' => '#00bff0'])
            ->seeJsonContains(['name' => 'newname', 'hexCode' => '#00bff0']);
        $this->assertResponseStatus(200);

        $this->get('/api/colors/1')
            ->seeJsonContains(['name' => 'newname', 'hexCode' => '#00bff0']);
        $this->assertResponseStatus(200);
    }

    public function testAPIColorsFailsOnUpdateForNonExistentColor()
    {
        $this->put('/api/colors/432', ['name' => 'new_name', 'hexCode' => '#00bff0'])
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsFailsOnUpdateForInvalidName()
    {
        $this->put('/api/colors/1', ['name' => 'new_name', 'hexCode' => '#00bff0'])
            ->seeJsonContains(['message' => 'Niepoprawne dane']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsFailsOnUpdateForInvalidHexCode()
    {
        $this->put('/api/colors/1', ['name' => 'newname', 'hexCode' => '#00bf32f0'])
            ->seeJsonContains(['message' => 'Niepoprawne dane']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsFailsOnUpdateForInvalidNameAdnHexCode()
    {
        $this->put('/api/colors/1', ['name' => 'new_4name', 'hexCode' => '#00bf32f0'])
            ->seeJsonContains(['message' => 'Niepoprawne dane']);
        $this->assertResponseStatus(400);
    }
    public function testAPIColorsCanUpdateSpecificColorIdOnlyName()
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

    public function testAPIColorsCanUpdateSpecificColorIdOnlyHexCode()
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
