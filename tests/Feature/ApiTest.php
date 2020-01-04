<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    //use RefreshDatabase;
    /** @test */
    public function createMessage(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/messages/',[
            'contact_number' => '256702913454',
            'contact_id' => 86,
            'message'    => 'Hey its complete blasd',
            'status'     => 'Recieved'
        ]);
        $response->assertOk();
    }
}
