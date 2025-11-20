<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('id')) {
            $task = Task::find($request->id);

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 404,
                    'errorCode' => 'PROJECT_NOT_FOUND',
                    'message' => 'Project not found',
                    'project' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'project' => $task
            ]);
        }

        $tasks = Task::with('project')->get();

        return response()->json([
            'success' => true,
            'projects' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $task = Project::find(1);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'PROJECT_NOT_FOUND',
                'message' => 'Please create a project first',
                'task' => null
            ], 404);
        }

        $task = Task::create([
            'project_id' => 1,
            'title' => 'Task 1',
            'description' => 'Description 1',
            'due_date' => now()->addDays(7)->toDateTimeString(),
            'priority' => 'MEDIUM',
            'position' => 1,
            'is_completed' => false
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Task Created',
            'task' => ([
                'id' => $task->id,
                'project_id' => $task->project_id,
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => now()->addDays(7)->toDateTimeString(),
                'priority' => $task->priority,
                'position' => $task->position,
                'is_completed' => $task->is_completed,
            ]),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'TASK_NOT_FOUND',
                'message' => 'Task not found',
                'task' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'project' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'TASK_NOT_FOUND',
                'message' => 'Task not found',
                'project' => null
            ], 404);
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'position' => $request->position,
            'is_completed' => $request->is_completed
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'project' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'TASK_NOT_FOUND',
                'message' => 'Task not found',
                'project' => null
            ], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted',
        ]);
    }
}
