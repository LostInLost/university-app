<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
// use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    // WITH APPLICATION COUNTING
    // public function indexApi($id)
    // {
    //     $checkAdmin = Admin::find($id);

    //     if (!$checkAdmin) return $this->responseError('Unauthorized', 401);

    //     // DB::enableQueryLog();

    //     // $cities = City::select('name')->withCount('students as value')->get(['name']);

    //     $arrayCountCity = [];
    //     $students = Student::with('city:id,name')->orderBy('born_date', 'asc')->get(['sex', 'born_date', 'city_id']);
    //     $arrayCity = [];
    //     $arrayYears = [];
    //     $arrayGender = [
    //         'L' => [
    //             'value' => 0,
    //             'name' => 'Man'
    //         ],
    //         'P' => [
    //             'value' => 0,
    //             'name' => 'Woman'
    //         ],
    //     ];

    //     // foreach ($cities as $city) {
    //     //     array_push($arrayCity, [
    //     //         'name' => $city->name,
    //     //         // 'value' => $city->students()->count()
    //     //     ]);
    //     // }

    //     foreach ($students as $student) {
    //         $studentYear = strval(Carbon::parse($student->born_date)->format('Y'));
    //         $arrayGender[$student->sex]['value'] += 1;
    //         array_push($arrayYears, $studentYear);
    //         array_push($arrayCountCity, $student->city->name);
    //     }

    //     $arrayYears = array_count_values($arrayYears);
    //     $arrayCountCity = array_count_values($arrayCountCity);
    //     $arrayCity = array_keys($arrayCountCity);
    //     $arrayFinalCity = [];

    //     foreach ($arrayCity as $city) {
    //         array_push($arrayFinalCity, [
    //             'name' => $city,
    //             'value' => $arrayCountCity[$city]
    //         ]);
    //     }

    //     // dd(DB::getQueryLog());

    //     return $this->responseSuccess([
    //         'studentByCity' => $arrayFinalCity,
    //         'studentByGender' => $arrayGender,
    //         'studentByYear' => [
    //             'category' => array_keys($arrayYears),
    //             'value' => [...$arrayYears]
    //         ],
    //         // 'tes' => $cities
    //     ]);
    // }

    // WITH DATABASE COUNT
    public function indexApi($id)
    {
        $checkAdmin = Admin::find($id);

        if (!$checkAdmin) return $this->responseError('Unauthorized', 401);

        // DB::enableQueryLog();

        $studentByCity = City::select('name')->withCount('students as value')->get(['name']);
        $studentByGender = Student::select('sex', DB::raw('COUNT(id) as total'))->groupBy('sex')->get();
        $studentByYear = Student::select(DB::raw('COUNT(id) as total, YEAR(born_date) as born'))
            ->groupBy(DB::raw('YEAR(born_date)'))
            ->orderBy(DB::raw('YEAR(born_date)'))
            ->get();

        $arrayGender = [];

        $studentByYearFinal = [
            'category' => [],
            'value' => []
        ];

        foreach ($studentByGender as $gender) {
            array_push($arrayGender, [
                'name' => $gender['sex'] === 'L' ? 'Male' : 'Female',
                'value' => $gender['total']
            ]);
        }

        foreach ($studentByYear as $year) {
            array_push($studentByYearFinal['category'], $year['born']);
            array_push($studentByYearFinal['value'], $year['total']);
        }

        // dd(DB::getQueryLog());

        return $this->responseSuccess([
            'studentByCity' => $studentByCity,
            'studentByGender' => $arrayGender,
            'studentByYear' => $studentByYearFinal,
            // 'tes' => []
        ]);
    }

    public function detailStudentApi($id)
    {
        $student = Student::select('id', 'city_id', 'name', 'sex', 'born_date', 'address', 'nim')->find($id);

        if (!$student) return $this->responseError('Data Not Found', 404);

        return $this->responseSuccess([
            'student' => $student->load('city:id,name')
        ]);
    }
}
