<?php

use Illuminate\Database\Seeder;
use App\permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ["Can view dashboards","Can view groups","Can add groups","Can view group users","Can view all church users",
                                "Can add users to church","Can view all contacts groups","Can add contacts groups","Can view contacts in a group",
                            "Can send messages to a group","Can send messages to a category","Can view sent messages",
                            "Can view scheduled messages","Can view message categories","Can add message categories",
                        "Can view search terms of a category","Can add search terms to a message category",
                        "Can view sent messages","Can view uncategorized messages","Can delete uncategorized messages",
                    "Can view payment packages","Can map a package to a category","Can add a new package","Can view logs","Can create user permissions"];

                    for($i=0; $i < count($permissions); $i++){
                        $permission = new permission();
                        if(permission::where("id",$i)->exists()){
                            $permission->id = $i+1;
                        }
                        else{
                            $permission->id = $i;
                        } 
                        $permission->permission_description=$permissions[$i];
                        $permission->save();
                    }
    }
}
