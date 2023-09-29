<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TasksCategory;
use App\Models\Tasks;

class TasksController extends Controller
{
    public function CreateTask(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required | string',
            'content' => 'required | string',
            'status' => 'required | string',
            'user_id' => 'required | int', 
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        return $this->GuardarTarea($request);
    }

    private function SaveTask(Request $request) {
        try {
            DB::raw('LOCK TABLE users READ');
            DB::raw('LOCK TABLE tasks WRITE');
            DB::raw('LOCK TABLE tasks_category READ');
            DB::raw('LOCK TABLE revision READ');
            DB::beginTransaction();
    
            $newTask = new Tasks();
            $newTask -> title = $request->post('title');
            $newTask -> content = $request->post('content');
            $newTask -> status = $request->post('status');
            $newTask -> user_id = $request->post('user_id');
            $newTask->save();

            $task_id = $newTask['id'];
            $this->SaveCategory($request, $task_id);
    
            return response()->json([$newTask], 201);
            DB::commit();
            DB::raw('UNLOCK TABLES');
        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return $th->getMessage();
        } catch (\PDOException $th) {
            return response("Permiso a la BD denegado",403);
        }
    }

    private function SaveCategory(Request $request, $task_id) {
        try {
            DB::raw('LOCK TABLE users READ');
            DB::raw('LOCK TABLE tasks READ');
            DB::raw('LOCK TABLE tasks_category WRITE');
            DB::raw('LOCK TABLE revision READ');
            DB::beginTransaction();

            $category = new TasksCategory();
            $category -> task_id = $task_id;
            $category -> category = $request->post('category');
            $category->save();
    
            return response()->json([$category], 201);
            DB::commit();
            DB::raw('UNLOCK TABLES');
        } catch (\Illuminate\Database\QueryException $th) {
            DB::rollback();
            return $th->getMessage();
        } catch (\PDOException $th) {
            return response("Permiso a la BD denegado",403);
        }
    }












}
