<?php

namespace App\Http\Controllers;

use App\Task;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->user->tasks()->get([
            'id',
            'title',
            'details',
            'created_by'
        ])->toArray();

        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Task $task)
    {
        $this->validate($request, [
            'title' => 'required',
            'details' => 'required'
        ]);

        $task->title = $request->title;
        $task->details = $request->details;

        if (!$this->user->tasks()->save($task)) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, The Task cound not be Saved'
            ], 500);
        } 

        return response()->json([
            'status' => true,
            'task' => $task
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'title' => 'required',
            'details' => 'required'
        ]);

        $task->title = $request->title;
        $task->details = $request->details;

        if (!$this->user->tasks()->save($task)) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, The Task cound not be Updated'
            ], 500);
        } 

        return response()->json([
            'status' => true,
            'task' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if (!$task->delete()) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, The Task cound not be Deleted'
            ]);
        }

        return response()->json([
            'status' => true,
            'delete' => 'Task was Deleted'
        ]);
    }
}
