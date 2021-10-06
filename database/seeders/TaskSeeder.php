<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'author_id' => rand(0,15),
            'executor_id' => rand(0,15),
            'priority_id' => rand(0,4),
            'date_end' => Carbon::now(),
            'date_start' => Carbon::now(),
            'status_id' => rand(0,3),
            'room_id' => 5
        ]);
    }
}
