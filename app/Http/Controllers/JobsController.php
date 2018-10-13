<?php

namespace App\Http\Controllers;

use App\Jobs\LongRunningJob;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;

class JobsController extends Controller
{

    /**
     * JobsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function startJob()
    {
        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => 'LongRunningJob',
            'created_at' => new \DateTime()
        ]);

        dispatch(new LongRunningJob($task->id));

        return $task;
    }

    public function getTasks()
    {
        return Task::where('user_id', Auth::user()->id)
            ->whereNull('completed_at')
            ->get();
    }
}
