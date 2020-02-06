<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Groups;

class saveContactTest extends TestCase
{
    /** @test */
    public function createContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact-to-group/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => 256702913450
        ]);
        $response->assertSeeText("Contact created");
    }

        /** @test */
        public function contactNumberExists(){
            $this->withoutExceptionHandling();
            $id = Groups::first()->id;
            $response = $this->post('/check-if-number-exists/'.$id,[
                'church_id' => 1,
                'group_id' => 88,
                'u_name' => 'Julius Ssemakula',
                'created_by' => 1,
                'update_by' => 1,
                'contact' => 256702913450
            ]);
            $response->assertSeeText("Supplied number already exists or it is registered under another group");
        }

    /** @test */
    public function emptyContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => ''
        ]);
        $response->assertSeeText("Contact information cannot be null");
    }
    /** @test */
    public function alphaNumericContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => '2567029i345E'
        ]);
        $response->assertSeeText("Please Enter a valid phone number");
    }
    /** @test */
    public function specialCharactersContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => '2567029)345@'
        ]);
        $response->assertSeeText("Please Enter a valid phone number");
    }

    /** @test */
    public function shortContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => '2567029)345@'
        ]);
        $response->assertOk();
    }

        /** @test */
    public function longContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => '2567029)345@'
        ]);
        $response->assertOk();
    }

        /** @test */
    public function formatOfContactNumber(){
        $this->withoutExceptionHandling();
        $id = Groups::first()->id;
        $response = $this->post('/create-contact/'.$id,[
            'church_id' => 1,
            'group_id' => $id,
            'u_name' => 'Julius Ssemakula',
            'created_by' => 1,
            'update_by' => 1,
            'contact' => '256706913451'
        ]);
        $response->assertOk();
    }
    /** @test */
    public function endMesageURL(){
        $this->withoutExceptionHandling();
        for($i=0; $i<1; $i++){
            $response = $this->post('http://church.pahappa.com/api/messages',[
                "from" => "256702913454",
                "message" => "This Message is sent the " . $i . "Time",
                "to" => "256702919454",
                "date_and_time" => "2020-02-01 11:59:25"
            ]);
        }
        $response->assertOk();
    }
}
