<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index(){
        return view('content.pages.report');
    }

    public function download($duration){
        if($duration == 'weekly'){
            $task = Event::where('created_at','>=',date('Y-m-d',strtotime('monday this week')))->where('created_at','<=',date('Y-m-d',strtotime('sunday this week')))->get();
        }
        if($duration == 'monthly'){
            $task = Event::where('created_at','>=',date('Y-m-d',strtotime('first day of this month')))->where('created_at','<=',date('Y-m-d',strtotime('last day of this month')))->get();
        }
        if($duration == 'yearly'){
             $task = Event::where('created_at','>=',date('Y-m-d',strtotime('first day of january this year')))->where('created_at','<=',date('Y-m-d',strtotime('last day of december this year')))->get();
        }

        //download as csv 
        //date,task,time started,time ended,time duration,billable,cost center,client,remark
        $data = [];
        foreach($task as $t){
            //duration is the event start and end date time difference
            $date_start = $t->start;
            $date_end = $t->end;
            $date_diff = strtotime($date_end) - strtotime($date_start);
            //hours
            $hours = floor($date_diff / (60 * 60));
            //minutes
            $minutes = floor(($date_diff - ($hours * 60 * 60)) / 60);
            //seconds
            $seconds = $date_diff - ($hours * 60 * 60) - ($minutes * 60);
            $t->duration = $hours . ':' . $minutes . ':' . $seconds;
            $data[] = [
                'date' => $t->created_at,
                'task' => $t->task->title,
                'time_started' => $t->start,
                'time_ended' => $t->end,
                'time_duration' => $t->duration,
                'billable' => $t->task->is_billable,
                'cost_center' => $t->task->cost_center,
                'client' => $t->task->user->name,
                'remark' => $t->task->remark,
            ];
        }

       // dd($data);
        $filename = "report" . date('Y-m-d') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('date','task','time_started','time_ended','time_duration','billable','cost_center','client','remark'));

        foreach($data as $row) {
            fputcsv($handle, array($row['date'], $row['task'], $row['time_started'], $row['time_ended'], $row['time_duration'], $row['billable'], $row['cost_center'], $row['client'], $row['remark']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, $filename, $headers);
    }
}
