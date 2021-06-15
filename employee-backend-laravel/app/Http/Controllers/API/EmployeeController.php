<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $employees = Employee::all();
        $employees = EmployeeResource::collection($employees);
        return $this->sendSuccessResponse($employees, "Employees retrieved successfully.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'department_name' => 'required',
            'phone_number' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'date',

        ]);

        if($validator->fails()){
            return $this->sendErrorValidationResponse('Validation Error.', $validator->errors());
        }

        $product = Employee::create($input);

        return $this->sendSuccessResponse(new EmployeeResource($product), 'Employee saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if (empty($employee)) {
            return $this->sendErrorResponse("Employee not found");
        }

        return $this->sendSuccessResponse(new EmployeeResource($employee), "Employee retrieved successfully.");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (empty($employee)) {
            return $this->sendErrorResponse("Employee not found");
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'department_name' => 'required',
            'phone_number' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'date',
        ]);

        if($validator->fails()){
            return $this->sendErrorValidationResponse('Validation Error.', $validator->errors() );
        }

        $employee->first_name = $input['first_name'];
        $employee->last_name = $input['last_name'];
        $employee->email = $input['email'];
        $employee->phone_number = $input['phone_number'];
        $employee->department_name = $input['department_name'];
        $employee->start_date = $input['start_date'];
        $employee->end_date = $input['end_date'];
        $employee->save();

        return $this->sendSuccessResponse(new EmployeeResource($employee), 'Employee updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (empty($employee)) {
            return $this->sendErrorResponse('Employee not found');
        }
        $employee->delete();
        return $this->sendSuccessResponse([], 'Employee deleted successfully.');
    }
}
