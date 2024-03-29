<?php

namespace App\Http\Controllers;

use App\Charts\StudentChart;
use App\Models\City;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        return view('admin.dashboard');
    }

    public function studentsIndex()
    {
        $students = Student::all();

        return view('admin.students.index', [
            'students' => $students->load('city:id,name')
        ]);
    }

    public function studentsAddINdex()
    {
        $cities = City::get(['id', 'name']);

        return view('admin.students.add', [
            'cities' => $cities
        ]);
    }

    public function studentsEditIndex($id)
    {
        $student = Student::find($id);
        $cities = City::get(['id', 'name']);

        return view('admin.students.edit', [
            'student' => $student->load('city'),
            'cities' => $cities
        ]);
    }

    public function citiesIndex()
    {
        $cities = City::all();

        return view('admin.cities.index', [
            'cities' => $cities
        ]);
    }

    public function cityAddIndex()
    {
        return view('admin.cities.add');
    }

    public function cityEditIndex($id)
    {
        $city = City::find($id);

        if (!$city) return abort(404);

        return view('admin.cities.edit', [
            'city' => $city
        ]);
    }
}
