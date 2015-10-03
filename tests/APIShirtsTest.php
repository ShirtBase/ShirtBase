<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APIShirtsTest extends TestCase
{
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
}
