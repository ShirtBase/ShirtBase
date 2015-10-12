<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIShirtsPostTest extends TestCase
{

    use DatabaseTransactions;

    public function testAPIShirtsPostCanSuccessfullyAddShirt()
    {
//        $dataJson = '{"name":"testShirt","user_id":"1","size":"M","photo":"sample/TShirt1.jpg","color_id":"5","comfortability":"8","wear":"4","sleeve_length":"120","notes":"NiceShirt"}';
        $data = [
            'name' => 'testShirt',
            'user_id' => '1',
            'size' => 'M',
            'photo' => 'sample/TShirt1.jpg',
            'color_id' => '5',
            'comfortability' => '8',
            'wear' => '4',
            'sleeve_length' => '120',
            'notes' => 'NiceShirt'
        ];

        $this->post('/api/shirts', $data)
            ->seeJsonContains(['message' => 'Dodano koszulkę.'])
            ->seeJsonContains($data);
        $this->assertResponseStatus(200);
    }

}
