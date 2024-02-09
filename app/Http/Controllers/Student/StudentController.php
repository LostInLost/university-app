<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nim' => ['required', 'numeric', 'unique:students,nim'],
            'name' => ['required', 'string'],
            'born_date' => ['required', 'date'],
            'city_id' => ['required'],
            'sex' => ['in:P,L'],
            'address' => ['required', 'string']
        ]);

        $admin = Admin::find(Auth::user()->id);


        $createStudent = $admin->students()->create($request->all());

        if (!$createStudent) return redirect()->back()->with('error', 'Student create failed.');

        return redirect()->route('admin.students.index')->with('success', 'Student successfully added.');
    }

    public function destroy(Request $request)
    {
        $student = Student::find($request->student_id ?? '');

        if (!$student) return redirect()->back()->with('error', 'Student not found.');
        
        $student->delete();
        return redirect()->back()->with('success', 'Student successfully deleted.');
    }
}
