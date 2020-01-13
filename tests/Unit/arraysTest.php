<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class arraysTest extends TestCase
{

    /** @test */

    public function convertToarray()
    {
            /**
     * Function checks for special characters in a string
     */
        $string = 'foo:';

        if (preg_match('/[\'^£$%&*.()}!";:{@#~?><>,|=_+¬-]/', $string))
        {
            echo 2;
        }
    }
    /** @test */
    public function getSubstring(){
    /**
     * Function returns a substring in the array
     */
        $contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
        if(!in_array(substr("256702913454",0,5),$contacts_format)){
            echo "Not Exists";
        }else{
            echo "Exists";
        }
    }
}
