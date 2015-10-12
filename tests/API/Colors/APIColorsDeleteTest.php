<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIColorsDeleteTest extends TestCase
{

    use DatabaseTransactions;

    public function testAPIColorsDeleteCanSpecificColorId()
    {
        $this->delete('/api/colors/1')
            ->seeJsonContains(['message' => 'Usunięto kolor.']);
        $this->assertResponseStatus(200);

        $this->get('/api/colors/1')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }

    public function testAPIColorsDeleteFailOnInvalidColorId()
    {
        $this->get('/api/colors/4234')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);

        $this->delete('/api/colors/4234')
            ->seeJsonContains(['message' => 'Nie ma koloru o podanym ID.']);
        $this->assertResponseStatus(400);
    }

}
