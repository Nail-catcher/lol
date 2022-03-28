<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RunPythonController extends Controller
{
    public function __invoke(Request $request)
    {
    	$process = new Process(['python','C://otherapp/script.py',$request->time]);
		$process->run();

		// executes after the command finishes
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}

		return ($process->getOutput());
    }
}
