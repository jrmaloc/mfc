<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tithe extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'transaction_number',
        'amount',
        'mop',
        'timestamp',
    ];
    public static array $mop = [
        'Bank Transfer',
        'Cash'
    ];
    
    use HasFactory;
}