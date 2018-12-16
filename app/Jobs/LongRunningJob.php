<?php

namespace App\Jobs;

use App\Events\TaskCompleted;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LongRunningJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $taskId;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $task = Task::findOrFail($this->taskId);

        sleep(3);

        $this->completeTask($task);

        return true;
    }

    private function completeTask(Task $task)
    {
        event(new TaskCompleted($task->id));

        $task->complete();

        return $task;
    }
}
