<?php

namespace Database\Seeders;

use App\Models\AreaServant;
use App\Models\ChapterServant;
use App\Models\HouseholdServant;
use App\Models\Member;
use App\Models\UnitServant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Javed Ur Rehman',
            'email' => 'jhonrobertaloc8@gmail.com',
            'username' => 'superadmin',
            'contact_number' => '091231239',
            'area' => 'North',
            'chapter' => 'Chapter 1',
            'gender' => 'Brother',
            'email_verified_at' => '2024-01-15 09:00:56',
            'password' => Hash::make('javed1234'),
            'role_id' => 1
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'ahsan@allphptricks.com',
            'username' => 'admin',
            'password' => Hash::make('ahsan1234'),
            'contact_number' => '094423456789',
            'role_id' => 2
        ]);
        $admin->assignRole('Admin');

        // Creating Member User
        $member = User::create([
            'name' => 'Jhon Robert Aloc',
            'email' => 'jrmaloc@allphptricks.com',
            'username' => 'member',
            'password' => Hash::make('jrmaloc1234'),
            'contact_number' => '09123456789',
            'role_id' => 7
        ]);
        Member::create([
            'user_id' => $member->id
        ]);
        $member->assignRole('Member');

        $member = User::create([
            'name' => 'Jhon Aloc',
            'email' => 'jmaloc@allphptricks.com',
            'username' => 'member2',
            'password' => Hash::make('jrmaloc1234'),
            'contact_number' => '09123456332789',
            'role_id' => 7
        ]);
        Member::create([
            'user_id' => $member->id
        ]);
        $member->assignRole('Member');

        // Creating Household Servant User
        $household = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'ahrqsdwdan@allphptricks.com',
            'username' => 'household',
            'password' => Hash::make('password'),
            'email_verified_at' => '2024-01-15 09:00:56',
            'contact_number' => '09823456789',
            'role_id' => 6
        ]);
        HouseholdServant::create([
            'user_id' => $household->id
        ]);
        $household->assignRole('Household Servant');

        // Creating Unit Servant User
        $household = User::create([
            'name' => 'Unit Servant',
            'email' => 'ahdfsdrqsan@allphptricks.com',
            'username' => 'unit',
            'password' => Hash::make('password'),
            'contact_number' => '098223456789',
            'role_id' => 5
        ]);
        UnitServant::create([
            'user_id' => $household->id
        ]);
        $household->assignRole('Unit Servant');

        // Creating Chapter Servant User
        $household = User::create([
            'name' => 'Chapter Servant',
            'email' => 'ahrqshtthtan@allphptricks.com',
            'username' => 'chapter',
            'password' => Hash::make('password'),
            'contact_number' => '09495676789',
            'role_id' => 4
        ]);
        ChapterServant::create([
            'user_id' => $household->id
        ]);
        $household->assignRole('Chapter Servant');

        // Creating Area Servant User
        $areaservant = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'ahsawwdan@allphptricks.com',
            'username' => 'area',
            'password' => Hash::make('password'),
            'contact_number' => '09323456789',
            'role_id' => 3
        ]);
        AreaServant::create([
            'user_id' => $areaservant->id,
        ]);
        $areaservant->assignRole('Area Servant');
    }
}
