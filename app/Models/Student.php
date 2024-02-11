<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id'];

    // protected $appends = ['born'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    // protected function Born(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => Carbon::parse($this->born_date)->format('Y')
    //     );
    // }

    // protected function CityName(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => $this->city()->first(['name'])->name
    //     );
    // }
}
