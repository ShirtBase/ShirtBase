<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIShirtsDeleteTest extends TestCase
{

    use DatabaseTransactions;


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

    public function testAPIShirtsFailsOnGetInvalidShirtId()
    {
        $this->get('/api/shirts/937')
            ->seeJsonContains(['message' => 'Nie ma koszulki o podanym ID.']);
        $this->assertResponseStatus(400);
    }
}
