<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->color,
                'allDay' => $event->all_day ? true : false,
                "extendedProps" => [
                    "task_id" =>  $event->task_id,
                ]
            ];
        }
        return response()->json($tasks);
    }

    public function store(Request $request){
       try{
        Event::create([
            'task_id' => $request->event['task_id'],
            'start' => $request->event['start'],
            'end' => $request->event['end'],
            'color' => $request->event['color'],
            'all_day' => $request->event['allDay'] == 'true' ? 1 : 0,
            'user_id' => Auth::user()->id
        ]);
        return response()->json(['status' => 'success'],200);
       }
       catch (\Exception $exception){
           return response()->json(['status' => 'error','error' => $exception->getMessage()]);
       }
    }

    public function update(Request $request){
      
        try{
            $event = Event::find($request->event['id']);
            $start = $request->event['start'];
            $end =  $request->event['end'];
            $start = Carbon::parse($start)->format('Y-m-d H:i:s');
            $end = Carbon::parse($end)->format('Y-m-d H:i:s');
            $event->update([
                'task_id' => $request->event['task_id'],
                'start' => $start,
                'end' => $end,
                'color' => $request->event['color'],
                'all_day' => $request->event['allDay'] == 'true' ? 1 : 0,
            ]);
            return response()->json(['status' => 'success'],200);
        }
        catch (\Exception $exception){
            return response()->json(['status' => 'error','error' => $exception->getMessage()]);
        }
    }

    public function destroy(Request $request){
        try{
            $event = Event::find($request->event['id']);
            $event->delete();
            return response()->json(['status' => 'success'],200);
        }
        catch (\Exception $exception){
            return response()->json(['status' => 'error','error' => $exception->getMessage()]);
        }
    }
    public function copy(Request $request){
        //copy last week events to this week
      
         $events = Event::where('user_id',Auth::user()->id)
            ->whereBetween('start',[Carbon::now()->subWeek(), Carbon::now()])
            ->orWhereBetween('end',[Carbon::now()->subWeek(), Carbon::now()])
            ->get();

        foreach ($events as $event){
            $start = Carbon::parse($event->start)->addWeek();
            $end = Carbon::parse($event->end)->addWeek();
            Event::create([
                'task_id' => $event->task_id,
                'start' => $start,
                'end' => $end,
                'color' => $event->color,
                'all_day' => $event->all_day,
                'user_id' => Auth::user()->id
            ]);
        }

        return response()->json(['status' => 'success'],200);

    }
}
