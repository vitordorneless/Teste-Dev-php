<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'doc_number',
        'phone',
        'address',
        'district',
        'city',
        'state',
        'zip_code',        
    ];
}
