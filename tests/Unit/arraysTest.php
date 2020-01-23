<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

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
        /** @test */
        public function testStringPositionInArray(){
            $keywords=array('one','two','three');
            $string = "Heloo members, I am Julius lkdf daf one";
            $targets = explode(' ', $string);
            foreach ( $targets as $newstring ) 
            {
                foreach ( $keywords as $keyword ) 
                {
                    if ( strpos( $newstring, $keyword ) !== FALSE )
                    {
                        echo "The word appeared !!";
                    }
                }
            }
        }
        /** @test */
        public function testCarboTimeSubtraction(){
            $mytime = Carbon::now();
            $mytime->setTimezone('Africa/Kampala');
            echo $mytime->subMinutes(7); 
        }
        /** @test */
        public function gradingStudents() {
            $grades= [50,55,60];
            for($i=0; $i<=100; $i++){
                foreach($grades as $grade){
                    if($grade[$i] < 40){
                        continue;
                    }elseif($grade[i+1]-$grade[i] < 3)
                        if((($grade[i+1]-$grade[i]) % 5)< 3){
                            echo 3;
                        }else{
                            echo 3;
                        }
                    }
                }
            }
            
}
