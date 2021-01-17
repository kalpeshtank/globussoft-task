<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $employees = Employee::paginate(10);
        return view('employees/list', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('employees/form', ['title' => 'Create Employees', 'button' => 'save', 'employees' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'email' => $request->id ? 'required|unique:employees,email,' . $request->id : 'required|unique:employees,email',
                    'mobile' => 'required|numeric',
                    'designation' => 'required|regex:/^[\pL\s\-]+$/u',
                    'salary' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }
        $employees_data = array(
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'password' => Hash::make('password'),
            'salary' => $request->salary
        );
        Employee::updateOrCreate(['id' => $request->id], $employees_data);
        return response()->json(['message' => $request->id ? 'Employees Updated successfully.' : 'Employees Added successfully.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $employees = Employee::findOrFail($id);
        return view('employees/form', ['employees' => $employees, 'title' => 'Update Employees', 'button' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $data = Employee::destroy($id);
        return response()->json(['message' => 'Employee deleted successfully.'], 200);
    }

    //export 
    public function export(Request $request) {
        $employee = Employee::all();
        $fileName = 'employee' . '_' . date('d_m_y') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array(
            'name',
            'email',
            'mobile',
            'designation',
            'salary',
        );
        $callback = function() use($employee, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($employee as $employ) {
                fputcsv($file,
                        array(
                            $employ->name,
                            $employ->email,
                            $employ->mobile,
                            $employ->designation,
                            $employ->salary,
                        )
                );
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

}
