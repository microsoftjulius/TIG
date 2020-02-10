<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\messages;
use Auth;

class datesTest extends TestCase
{
    /** @test */
    public function datesTest(){
        $response = messages::where('message','Testing Scheduled')->where('church_id',1)
            ->update(array('status'=>'Failed'));
            $this->assertOK();
    }
}
