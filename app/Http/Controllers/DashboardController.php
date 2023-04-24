<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $totalEvent = Event::where('user_id',auth()->id())->count();
        $totalTask = Task::where('user_id',auth()->id())->count();
        $totalClient = Client::where('user_id',auth()->id())->count();
        return view('content.pages.dashboard',compact('totalEvent','totalTask','totalClient'));
    }
}
