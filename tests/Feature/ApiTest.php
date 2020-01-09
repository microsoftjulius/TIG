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
            'from' => '256777913458',
            'contact_id' => 86,
            'message'    => 'XXXXXXX',
            'status'     => 'Recieved',
            'to'    => '256702913454',
            'date_and_time' => '2020-01-06 11:59:25'
        ]);
        if($response){
            $response->assertOk();
        }else{
            $response->assertSeeText("All the supplied parameters are required");
        }
    }

    /** @test */
    public function checkReturn404Error(){
        $this->withoutExceptionHandling();
        $response = $this->get('/api/messages/');
        $response->assertStatus(404);
    }
}
