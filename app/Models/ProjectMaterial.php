<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class ProjectMaterial extends Model
{
    use HasFactory, SoftDeletes, Uuids;
    public $incrementing = false;
}
