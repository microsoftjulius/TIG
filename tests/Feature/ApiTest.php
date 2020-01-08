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
            'from' => '256702983454',
            'contact_id' => 86,
            'message'    => 'Hey its complete blasd',
            'status'     => 'Recieved',
            'to'    => '256702913454',
            'date_and_time' => '2020-01-06 11:59:25'
        ]);
        $response->assertOk();
    }
}
