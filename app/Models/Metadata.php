<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Metadata extends Model
{
    use HasFactory;

    protected $fillable = ['server_name', 'environment', 'location'];
}
