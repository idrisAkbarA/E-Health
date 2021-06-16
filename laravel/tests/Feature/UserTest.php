<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function createDokterTest()
    {
        $response = $this->post('/api/user', [
            'name' => 'Dr.Aripin',
            'email' => 'aripin'
        ]);

        $response->assertStatus(200);
    }
}
