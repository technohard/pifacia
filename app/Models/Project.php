<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Project extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'vendor',
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function materials()
    {
        return $this->hasMany(ProjectMaterial::class, 'project_id', 'id');
    }

    public function workers()
    {
        return $this->hasMany(ProjectWorker::class, 'project_id', 'id');
    }

}
