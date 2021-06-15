<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'first_name' => "Budi ashari",
            'last_name' => "Budi ashari",
            'email' => 'budi@gmail.com',
            'phone_number' => '0812989123',
            'department_name' => 'IT',
            'start_date' => Carbon::parse('2020-01-01'),
            'end_date' => null,
        ]);
        DB::table('employees')->insert([
            'first_name' => "Andi ",
            'last_name' => "Sumirno",
            'email' => 'Sumirno@gmail.com',
            'phone_number' => '08012831',
            'department_name' => 'IT2',
            'start_date' => Carbon::parse('2020-05-01'),
            'end_date' => null,
        ]);
    }
}
