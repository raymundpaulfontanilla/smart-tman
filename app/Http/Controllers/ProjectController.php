<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('id')) {
            $project = Project::find($request->id);

            if (!$project) {
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
                'project' => $project
            ]);
        }

        $projects = Project::all();
        return response()->json([
            'success' => true,
            'projects' => $projects
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
    public function store(Request $request)
    {
        $project = Project::create([
            'user_id' => 1,
            'name' => 'My Project 2',
            'color' => '#000000',
            'position' => 2
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Project Created',
            'project' => ([
                'id' => $project->id,
                'user_id' => $project->user_id,
                'name' => $project->name,
                'color' => $project->color,
                'position' => $project->position,
            ]),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
