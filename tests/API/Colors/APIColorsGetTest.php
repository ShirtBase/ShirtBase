<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIColorsGetTest extends TestCase
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

    public function testAPIColorsGetFailsOnGetInvalidColorId()
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


}
