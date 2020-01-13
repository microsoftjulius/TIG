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
            $response = $this->post('/check-if-number-exists/{id}',[
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
        $response->assertSeeText("Phone number cannot contain Alphabetical letters");
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
        $response->assertOk();
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
            'contact' => '2567302913451'
        ]);
        $response->assertOk();
    }
}
