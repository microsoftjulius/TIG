<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestArray extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        //test to remove space from an array
        $my_array = array('arsenal','manchester united','','li');
        for($i=0; $i<=count($my_array); $i++){
                if($my_array[$i] == ''){
                    unset($my_array[$i]);
                }
        }
        print_r($array);
        //$this->assertTrue(true);
    }

}
