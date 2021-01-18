<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Employee;
use App\Attendances;
use Illuminate\Support\Facades\Auth;
use Validator;

class EmployeController extends BaseController {
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function salary(Request $request) {
//        return $this->sendError('Validation Error.', ['$month' => '6:30' < '6:29']);
        $holidays = array();
        $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July ', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        if ($request->month && $request->year) {
            $query_date = $request->year . '-' . $request->month . '-01';
            $start_date = date('Y-m-01', strtotime($query_date));
            $end_date = date('Y-m-t', strtotime($query_date));
        } else {
            $start_date = date('Y-m-d', strtotime('first day of last month'));
            $end_date = date('Y-m-d', strtotime('last day of last month'));
        }
        $working_day = $this->getWorkingDays($start_date, $end_date, $holidays);
        $employee = Employee::select(['id', 'salary', 'name', 'designation'])->get();
        foreach ($employee as &$emp) {
            $attendances = Attendances::where(['employee_id' => $emp->id, 'is_holiday' => 0, 'month' => $request->month, 'year' => $request->year])->get();
            $late_start_day = 0;
            $early_start_day = 0;
            foreach ($attendances as $attend) {
                if (strtotime($attend->in_time) < strtotime($request->base_in_time)) {
                    $early_start_day++;
                }
                if (strtotime($attend->in_time) > strtotime($request->base_in_time)) {
                    $late_start_day++;
                }
            }
            $per_day_salary = $emp->salary / $working_day;
            $present_day = $attendances->count();
            $salary_on_hand = ceil($per_day_salary * $present_day);
            //leat day count
            $salary_on_hand = $salary_on_hand - ($per_day_salary * floor($late_start_day / 2));
            //early day count
            $salary_on_hand = $salary_on_hand + ($per_day_salary * floor($early_start_day / 10));
            $emp->present_day = $present_day;
            $emp->late_start_day = $late_start_day;
            $emp->early_start_day = $early_start_day;
            $emp->working_day = $working_day;
            $emp->salary_on_hand = number_format(ceil($salary_on_hand), 2);
        }
        return $this->sendResponse([$employee], 'Salary get successfully.');
    }

}
