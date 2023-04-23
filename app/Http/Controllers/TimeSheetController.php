<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSheetController extends Controller
{
    //
    public function index(){
        $tasks = Task::where('user_id',Auth::user()->id)->get();
        return view('content.pages.timesheet',compact('tasks'));
    }

    public function events(Request $request){
        $start = $request->get('start');
        $end = $request->get('end');
        $events = Event::where('user_id',Auth::user()->id)
            ->whereBetween('start',[$start,$end])
            ->orWhereBetween('end',[$start,$end])
            ->get();
        $tasks = [];
        foreach ($events as $event){
            $tasks[] = [
                'id' => $event->id,
                'title' => $event->task->title,
                'task_id'=> $event->task_id,
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->color,
                'allDay' => $event->all_day,
            ];
        }
        return response()->json($tasks);
    }
}
