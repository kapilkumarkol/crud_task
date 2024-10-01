<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function task_list(Request $request){
        try{

            $tasks = Task::get();

            if ($request->has('completed')) {
                $tasks->where('completed', $request->completed);
            }

            // return view('task_list',get_defined_vars());

            return response()->json($tasks);

        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->completed = "0";
        $task->save();
        $tasks = Task::all();
        return response()->json($tasks, 201);
    }

    public function show($id){
        $task = Task::find($id);
        return response()->json($task);
    }

    public function delete_task($id){
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json('success', 204);
    }

    public function update(Request $request ,$id){

        try {
            // Validate the request data
            $validator =$request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $task = Task::findOrFail($id);
            $task->update($request->only(['title', 'description']));
            return response()->json([
                'message' => 'Task updated successfully',
                'task' => $task,
            ], 200); // OK
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
            ], 404); // Not Found
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }
}
