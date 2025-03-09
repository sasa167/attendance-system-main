<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';
    protected $fillable = ['name', 'address', 'phone'];

    public $timestamps = false; // إذا لم تكن هناك أعمدة `created_at` و `updated_at`

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'phone' => 'string',
    ];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
