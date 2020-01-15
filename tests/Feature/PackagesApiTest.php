<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackagesApiTest extends TestCase
{
    /** @test */
    public function payForAPackage(){
        $response = $this->post('/https://app.beautifuluganda.com/api/payment/donate',[
            'name' => 'julius',
            'amount' => '2000',
            'number' => '256702913454',
            'chanel' => 'TIG',
            'referral' => '256776913451'
        ]);
        $response->assertOk();
    }
}
