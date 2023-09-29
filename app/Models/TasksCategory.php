<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksCategory extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "tasks_category";
    protected $primaryKey = 'id';

    public function task() {
        return $this->belongsTo(Tasks::class, "task_id");
    }
}
