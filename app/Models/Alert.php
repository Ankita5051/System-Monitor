<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Alert extends Model
{
    use HasFactory;

    protected $fillable = ['metric', 'value', 'threshold','status'];
}
