<?php

namespace App\Queue;

use Illuminate\Queue\Jobs\SqsJob;
use Illuminate\Queue\SqsQueue as BaseSqsQueue;

class SqsQueue extends BaseSqsQueue
{
    public function pop($queue = null)
    {
        $response = $this->sqs->receiveMessage([
            'QueueUrl' => $queue = $this->getQueue($queue),
            'AttributeNames' => ['ApproximateReceiveCount'],
            'WaitTimeSeconds' => 20, // enable long-polling param
        ]);

        if (! is_null($response['Messages']) && count($response['Messages']) > 0) {
            return new SqsJob(
                $this->container, $this->sqs, $response['Messages'][0],
                $this->connectionName, $queue
            );
        }
    }
}