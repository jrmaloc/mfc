<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Member;
use Faker\Provider\en_PH\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Household Gathering',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);

        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        // $member = Member::find([1, 2, 3]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Household Gathering',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);

        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Covenant Recollection',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Vineyard Recollection',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Christian Life Seminar',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Love Discovery Overnight',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Household Servants Training',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6])),
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Fishers of Men',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Real Men Brotherhood',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Wonder Series',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Gear Up Training',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Ones to Ones',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Liturgical Bible Study',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Congress',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'General Assembly',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Love Forum',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => '2024-02-14 19:00:00',
            'end_date' => '2024-02-14 22:00:00',
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'MFC Anniversary',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeThisMonth('December')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Christmas Party',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);

        $start = fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d H:i');
        $activity = Activity::create([
            'title' => 'Empowered Servants Assembly',
            'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum, quae voluptate nesciunt repudiandae ex modi dolores alias iure minus minima.',
            'location' => fake()->address,
            'reg_fee' => fake()->randomFloat(2, 100, 1000),
            'start_date' => $start,
            'end_date' => fake()->dateTimeInInterval($start, '+3 hours')->format('Y-m-d H:i'),
            'role_ids' => json_encode(array_values([1, 2, 3, 4, 5, 6, 7])),
            'user_ids' => json_encode(array_values([]))
        ]);
        Attendance::create([
            'activity_id' => $activity->id,
        ]);
    }
}
