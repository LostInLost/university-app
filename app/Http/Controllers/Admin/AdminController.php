<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['string', 'required', 'unique:admins,username'],
            'name' => ['string', 'required'],
            'email' => ['required', 'email:dns', 'unique:admins,email'],
            'password' => ['required', 'min:8', 'max:15']
        ]);

        if ($validator->fails()) return $this->responseError($validator->errors());

        $validatedData = $validator->valid();
        $hashedPassword = Hash::make($validatedData['password']);
        $createAdmin = Admin::create([
            'username' => $validatedData['username'],
            'password' => $hashedPassword,
            'email' => $validatedData['email'],
            'name' => $validatedData['name']
        ]);

        if (!$createAdmin) return $this->responseError('Create Admin Failed.');

        return $this->responseSuccess('Admin successfully created.');
    }

    public function indexApi($id)
    {
        $checkAdmin = Admin::find($id);

        if (!$checkAdmin) return $this->responseError('Unauthorized', 401);

        $cities = City::has('students')->get();
        
        $students = Student::all(['sex', 'born_date']);
        $studentsByGroup = Student::get()->groupBy('born_date');
        
        $arrayCity = [];
        $arrayYears = [];
        $arrayGender = [
            'L' => [
                'value' => 0,
                'name' => 'Man'
            ],
            'P' => [
                'value' => 0,
                'name' => 'Woman'
            ],
        ];

        foreach($cities as $city) {
            array_push($arrayCity, [
                'name' => $city->name,
                'value' => $city->students()->count()
            ]);
        }

        foreach($students as $student)
        {
            $studentYear = strval(Carbon::parse($student->born_date)->format('Y'));
            $arrayGender[$student->sex]['value'] += 1;
            if (!array_key_exists($studentYear, $arrayYears)) {
               array_push($arrayYears, $studentYear);
            }

        }
        
        return $this->responseSuccess([
            'studentByCity' => $arrayCity,
            'studentByGender' => $arrayGender,
            'studentByYear' => $students,
        ]);
        
        
    } 
}
