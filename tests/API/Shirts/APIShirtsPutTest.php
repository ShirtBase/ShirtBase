<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIShirtsPutTest extends TestCase
{

    use DatabaseTransactions;

    public function testAPIShirtsPutCanSuccessfullyShirt()
    {
        $data = [
            'name' => 'testShirt',
            'user_id' => '1',
            'size' => 'M',
            'photo' => 'sample/TShirt1.jpg',
            'color_id' => '5',
            'comfortability' => '8',
            'wear' => '4',
            'sleeve_length' => '120',
            'notes' => 'Nice Shirt',
        ];
        $this->put('/api/shirts/1', $data)
            ->seeJsonContains(['message' => 'Zaktualizowano koszulkę.'])
            ->seeJsonContains($data);
        $this->assertResponseStatus(200);
    }

}
