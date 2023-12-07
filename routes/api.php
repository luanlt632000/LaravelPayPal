<?php

use App\Http\Controllers\PayPalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Route;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

 Route::post('/git-hook', function(){
    $result = Process::fromShellCommandline('cd .. && dir');

    try {
        $result->mustRun();

        $output = $result->getOutput();
        return "<textarea>".$output."</textarea>";
    } catch (ProcessFailedException $exception) {
        return response()->json(['status' => 'Failed to execute Git pull command'], 500);
    }
});

