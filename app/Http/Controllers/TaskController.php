<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    
    public function task_list(Request $request)
    {
        try {
            // Start with a Task query builder
            $tasks = Task::query();

            // Apply the 'completed' filter if provided
            if ($request->has('completed')) {
                $tasks->where('completed', $request->completed);
            }

            // Fetch the tasks (consider pagination for large datasets)
            $tasks = $tasks->get();

            // Return the list of tasks in a JSON response
            return response()->json([
                'message' => 'Task list retrieved successfully.',
                'tasks' => $tasks
            ], 200);

        } catch (\Exception $e) {
            // Return a structured error response
            return response()->json([
                'message' => 'An error occurred while retrieving tasks.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Create a new task using mass assignment
            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'completed' => false, // Boolean false for completed status
            ]);

            // Return a JSON response with the newly created task and status 201
            return response()->json([
                'message' => 'Task created successfully.',
                'task' => $task,
            ], 201);

        } catch (ValidationException $e) {
            // Return a 422 response with validation error messages
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            // Attempt to find the task by ID or fail with an exception
            $task = Task::findOrFail($id);

            // Return a successful JSON response with the task data
            return response()->json([
                'message' => 'Task retrieved successfully.',
                'task' => $task,
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return a 404 error if the task is not found
            return response()->json([
                'message' => 'Task not found.',
            ], 404);
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function delete_task($id)
    {
        try {
            // Attempt to find the task by ID or fail with an exception
            $task = Task::findOrFail($id);

            // Delete the task
            $task->delete();

            // Return a 204 response to indicate the task was successfully deleted
            return response()->json([
                'message' => 'Task deleted successfully.'
            ], 204);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return a 404 error if the task is not found
            return response()->json([
                'message' => 'Task not found.',
            ], 404);
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request ,$id){

        try {
            // Validate the request data
            $validator =$request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $task = Task::findOrFail($id);
            $task->update($request->only(['title', 'description','completed']));
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
