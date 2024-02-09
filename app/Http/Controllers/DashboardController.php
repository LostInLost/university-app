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
        $studentByCity = new StudentChart;
        $cities = City::has('students')->get();
        $arrayCity = [];
        $studentCount = [];

        foreach($cities as $city) {
            array_push($arrayCity, $city->name);
            array_push($studentCount, $city->students()->count());
        }
        
        $studentByCity->labels($arrayCity);
        $studentByCity->dataset('Student By City', 'pie', $studentCount);
        $studentByCity->minimalist(true);
        $studentByCity->tooltip(true);
        $studentByCity->displayLegend(true);
        $studentByCity->type('line');

        
        return view('admin.dashboard', [
            'studentByCityChart' => $studentByCity
        ]);
    }

    public function studentsIndex()
    {
        $students = Student::all();

        return view('admin.students.index', [
            'students' => $students
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
