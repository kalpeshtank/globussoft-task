<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Attendances;

class CreateUsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = [
            [
                'name' => 'emp 1',
                'email' => 'emp1@gmail.com',
                'mobile' => '8905578128',
                'designation' => 'dev',
                'salary' => '11000',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'emp 2',
                'email' => 'emp2@gmail.com',
                'mobile' => '8905578127',
                'designation' => 'jr dev',
                'salary' => '25000',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'emp 3',
                'email' => 'emp3@gmail.com',
                'mobile' => '8905578126',
                'designation' => 'sr dev',
                'salary' => '65000',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'emp 4',
                'email' => 'emp4@gmail.com',
                'mobile' => '8905578125',
                'designation' => 'tech lead',
                'salary' => '900000',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'emp 5',
                'email' => 'emp5@gmail.com',
                'mobile' => '8905578124',
                'designation' => 'project manager',
                'salary' => '110000',
                'password' => bcrypt('123456'),
            ],
        ];
        $attendances = [
        ];
        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date = date('Y-m-d', strtotime('last day of last month'));
        $dates = $this->date_range($start_date, $end_date, []);
        foreach ($dates as $d) {
            $attendances[] = [
                'employee_id' => '',
                'month' => date("m", strtotime($d)),
                'year' => date("Y", strtotime($d)),
                'in_time' => (date("w", strtotime($d)) == 0 || date("w", strtotime($d)) == 6) ? '00:00' : '9:30',
                'out_time' => (date("w", strtotime($d)) == 0 || date("w", strtotime($d)) == 6) ? '00:00' : '6:30',
                'is_late' => '0',
                'is_early' => '0',
                'is_holiday' => (date("w", strtotime($d)) == 0 || date("w", strtotime($d)) == 6),
            ];
        }
        foreach ($user as $key => $value) {
            $employee = Employee::create($value);
            foreach ($attendances as $attendance) {
                $attendance['employee_id'] = $employee->id;
                Attendances::create($attendance);
            }
        }
    }

    function date_range($first, $last, $old_array, $step = '+1 day', $output_format = 'Y-m-d') {
        $dates = $old_array;
        $current = strtotime($first);
        $last = strtotime($last);
        while ($current <= $last) {
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

}
