<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIShirtsGetTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test if /api/shirts/ endpoint returns HTTP status codes indicating success.
     *
     * @return void
     */
    public function testAPIShirtsRespondsSuccessfully()
    {
        $this->visit('/api/shirts')
            ->assertResponseOk();
    }

    public function testAPIShirtsContainsJSON()
    {
        $response = $this->visit('/api/shirts')->getActualOutput();
        json_decode($response);
        $errorCode = json_last_error();
        $this->assertTrue($errorCode === JSON_ERROR_NONE);
    }

    public function testAPIShirtsCanGetSpecificShirtId()
    {
        $this->get('/api/shirts/1')
            ->seeJsonContains(['id' => 1]);
        $this->assertResponseStatus(200);
    }
}
