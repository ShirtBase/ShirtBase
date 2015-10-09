<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIShirtsTest extends TestCase
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

    //TODO:post tests to /colors

    public function testAPIShirtsFailsOnGetInvalidShirtId()
    {
        $this->get('/api/shirts/937')
            ->seeJsonContains(['message' => 'Nie ma koszulki o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIShirtsCanGetSpecificShirtId()
    {
        $this->get('/api/shirts/1')
            ->seeJsonContains(['id' => 1]);
        $this->assertResponseStatus(200);
    }

    public function testAPIShirtsCanDeleteSpecificShirtId()
    {
        $this->delete('/api/shirts/1')
            ->seeJsonContains(['message' => 'Usunięto koszulkę.']);
        $this->assertResponseStatus(200);

        $this->get('/api/shirts/1')
            ->seeJsonContains(['message' => 'Nie ma koszulki o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIShirtsFailOnDeleteInvalidShirtId()
    {
        $this->get('/api/shirts/4234')
            ->seeJsonContains(['message' => 'Nie ma koszulki o podanym ID.']);
        $this->assertResponseStatus(400);

        $this->delete('/api/shirts/4234')
            ->seeJsonContains(['message' => 'Nie ma koszulki o podanym ID.']);
        $this->assertResponseStatus(400);
    }
}
