<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Activity;
use App\Models\AreaServant;
use App\Models\HouseholdServant;
use App\Models\Member;
use App\Models\Tithe;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,
            SectionSeeder::class,
            ActivitySeeder::class,
        ]);

        // User::factory(300)->create();
        // Member::factory(100)->create();
        // HouseholdServant::factory(25)->create();
        // AreaServant::factory(5)->create();
        // Tithe::factory(10)->create();

        // $user = User::all()->shuffle();

        // for ($i = 0; $i < 5; $i++) {
        //     AreaServant::factory()->create([
        //         'user_id' => $user->pop()->id
        //     ]);
        // }

        // $areaServants = AreaServant::all();

        // for ($i = 0; $i < 20; $i++) {
        //     $randomAreaServant = $areaServants->random(); // Get a random household servant from the collection
        //     $areaServantId = $randomAreaServant->id; // Get the id of the random household servant
        //     $areaServantName = $randomAreaServant->area_name; // Get the name of the random household servant

        //     // Create a new member with the random household servant id
        //     HouseholdServant::factory()->create([
        //         'user_id' => $user->pop()->id,
        //         'area_servant_id' => $areaServantId,
        //         'area_servant_name' => $areaServantName,
        //     ]);
        // }

        // $householdServants = HouseholdServant::all();

        // for ($i = 0; $i < 100; $i++) {
        //     $randomHouseholdServant = $householdServants->random(); // Get a random household servant from the collection
        //     $householdServantId = $randomHouseholdServant->id; // Get the id of the random household servant
        //     $householdServantName = $randomHouseholdServant->household_name; // Get the name of the random household servant

        //     // Create a new member with the random household servant id
        //     Member::factory()->create([
        //         'household_servant_id' => $householdServantId,
        //         'household_servant_name' => $householdServantName,
        //     ]);
        // }






        // $randomHouseholdServant = $householdservants->random(); // Get a random household servant from the collection
        // $householdServantId = $randomHouseholdServant->id; // Get the id of the random household servant
        // $householdServantName = $randomHouseholdServant->name; // Get the name of the random household servant

        // Now you can use $householdServantId and $householdServantName in your database operation

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}