<?php

namespace App\Queue;

use Illuminate\Queue\Connectors\SqsConnector as BaseSqsConnector;
use Aws\Sqs\SqsClient;
use Illuminate\Support\Arr;

class SqsConnector extends BaseSqsConnector
{
    public function connect(array $config)
    {
        $config = $this->getDefaultConfiguration($config);

        if ($config['key'] && $config['secret']) {
            $config['credentials'] = Arr::only($config, ['key', 'secret']);
        }

        return new SqsQueue(
            new SqsClient($config), $config['queue'], $config['prefix'] ?? ''
        );
    }
}