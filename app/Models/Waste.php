<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    protected $fillable = [
        'on',
        'iid',
        'quantity'
    ];

    use HasFactory;
}
