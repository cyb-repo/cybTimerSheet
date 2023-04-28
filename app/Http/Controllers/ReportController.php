<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    //
    public function index(){
        return view('content.pages.report');
    }

    public function download($duration){
        if($duration == 'weekly'){
         $task = Event::where('start','>=',date('Y-m-d',strtotime('monday this week')))->where('end','<=',date('Y-m-d',strtotime('monday this week +7 days')))->get();
        }
        if($duration == 'monthly'){
            $task = Event::where('start','>=' ,date('Y-m-d',strtotime('first day of this month')))->where('end','<=',date('Y-m-d',strtotime('first day of next month')))->get();
        }
        if($duration == 'yearly'){
            $task = Event::where('start','>=',date('Y-m-d',strtotime('first day of january this year')))->where('end','<=',date('Y-m-d',strtotime('last day of december this year')))->get();
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
                'created_at' => $t->created_at,
                'task' => $t->task->title,
                'date_started' => Carbon::parse($t->start)->format('Y-m-d'),
                'date_ended' => Carbon::parse($t->end)->format('Y-m-d'),
                'time_started' => Carbon::parse($t->start)->format('H:i:s') . ' ' . /*AM OR PM */ Carbon::parse($t->start)->format('A'),
                'time_ended' => Carbon::parse($t->end)->format('H:i:s') . ' ' . /*AM OR PM */ Carbon::parse($t->end)->format('A'),
                'time_duration' => $t->duration,
                'billable' => $t->task->is_billable,
                'cost_center' => $t->task->cost_center,
                'client' => $t->task->client->name,
                'remark' => $t->task->remark,
            ];
        }

       // dd($data);
        $filename = "report" . date('Y-m-d') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('created_at','task', 'date_started','date_ended', 'time_started','time_ended','time_duration','billable','cost_center','client','remark'));

        foreach($data as $row) {
            fputcsv($handle, array($row['created_at'], $row['task'], $row['date_started'], $row['date_ended'], $row['time_started'], $row['time_ended'], $row['time_duration'], $row['billable'], $row['cost_center'], $row['client'], $row['remark']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, $filename, $headers);
    }
}
