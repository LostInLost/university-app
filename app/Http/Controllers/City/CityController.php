<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);


        $admin = Admin::find(Auth::user()->id);

        $createCity = $admin->city()->create([
            'name' => $request->name,
        ]);

        if (!$createCity) return redirect()->back()->with('error', 'City Created Failed');

        return redirect()->route('admin.cities.index')->with('success', 'City successfully added.');
    }

    public function destroy(Request $request)
    {
        $city = City::find($request->city_id);

        if (!$city) return redirect()->back()->with('error', 'City not found.');

        $city->delete();

        return redirect()->back()->with('success', 'City successfully deleted.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);


        $city = City::find($id);

        if (!$city) return redirect()->back()->with('error', 'City not found.');

        $city->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.cities.index')->with('success', 'City successfully updated.');
    }
}
