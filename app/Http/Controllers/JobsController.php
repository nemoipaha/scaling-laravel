<?php

namespace App\Http\Controllers;

use App\Jobs\LongRunningJob;
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
        return [
            'job' => Queue::push(new LongRunningJob())
        ];
    }
}
