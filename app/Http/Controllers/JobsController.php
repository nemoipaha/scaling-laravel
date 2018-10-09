<?php

namespace App\Http\Controllers;

use App\Jobs\LongRunningJob;

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
        dispatch(new LongRunningJob());

        return [
            'status' => 'success'
        ];
    }
}
