<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "tasks";
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id'
    ];

    public function category() {
        return $this->hasMany(TasksCategory::class, 'task_id');
    }
}
