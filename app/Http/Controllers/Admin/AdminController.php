<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
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
}
