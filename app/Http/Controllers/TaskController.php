<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use App\Models\Task;
use App\Models\TaskIteration;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::query();
        if ($request->has('type')) {
            if ($request->type == 'today') {
                $tasks = $tasks->with(['taskIterations' => function ($query) {
                    $query->where('trigger_date', date('Y-m-d'));
                }])->whereHas('taskIterations', function ($q) {
                    $q->where('trigger_date', date('Y-m-d'));
                });
            }
            if ($request->type == 'tomorrow') {
                $tasks = $tasks->with(['taskIterations' => function ($query) {
                    $query->where('trigger_date', date('Y-m-d', strtotime(' +1 day')));
                }])->whereHas('taskIterations', function ($q) {
                    $q->where('trigger_date', date('Y-m-d', strtotime(' +1 day')));
                });
            }
            if ($request->type == 'next_week') {
                $from = date('Y-m-d', strtotime('next monday'));
                $to = date('Y-m-d', strtotime('next sunday', strtotime($from)));
                $tasks = $tasks->with(['taskIterations' => function ($query) use ($from, $to) {
                    $query->where('trigger_date', '>=', $from)->where('trigger_date', '<=', $to);
                }])->whereHas('taskIterations', function ($q) use ($from, $to) {
                    $q->where('trigger_date', '>=', $from)->where('trigger_date', '<=', $to);
                });
            }
            if ($request->type == 'next_week2') {
                $date = new Carbon;
                $from = $date->modify('second monday')->format('Y-m-d');
                $to = date('Y-m-d', strtotime('next sunday', strtotime($from)));
                $tasks = $tasks->with(['taskIterations' => function ($query) use ($from, $to) {
                    $query->where('trigger_date', '>=', $from)->where('trigger_date', '<=', $to);
                }])->whereHas('taskIterations', function ($q) use ($from, $to) {
                    $q->where('trigger_date', '>=', $from)->where('trigger_date', '<=', $to);
                });
            }
        }
        $tasks = $tasks->paginate(10);
        return view('Admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $occurrences = Occurrence::all();
        return view('Admin.tasks.create', compact('occurrences'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:tasks',
            'occurrence_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        \DB::transaction(function () use ($request) {
            $task = Task::create($request->all());

            $function_name = Occurrence::find($request->occurrence_id)->function_name;

            $dates = $this->$function_name($request->start_date, $request->end_date, $task->id);

            TaskIteration::insert($dates);
        });

        return redirect('/tasks')->with('message', 'Record Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('Admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function everyday($from, $to, $task_id)
    {
        $period = CarbonPeriod::create($from, $to);

        foreach ($period as $key => $value) {
            $dates[] = [
                'task_id' => $task_id,
                'trigger_date' => $value->toDateString(),
                'created_at' => now(),
            ];
        }
        return $dates;
    }

    public function Mondays($from, $to, $task_id)
    {
        $from = new Carbon($from);
        $to = new Carbon($to);

        $date = $from->dayOfWeek == Carbon::MONDAY ? $from : $from->copy()->modify('next Monday');

        while ($date->lte($to)) {
            $dates[] = [
                'task_id' => $task_id,
                'trigger_date' => $date->toDateString(),
                'created_at' => now(),
            ];
            $date->addWeek();
        }
        return $dates;
    }

    public function MondayWednesdayFriday($from, $to, $task_id)
    {
        $from = new Carbon($from);
        $to = new Carbon($to);
        $dates = [];
        $from->diffInDaysFiltered(function ($date) use ($task_id, &$dates) {
            if (in_array($date->dayOfWeek, [1, 3, 5])) {
                array_push($dates, [
                    'task_id' => $task_id,
                    'trigger_date' => $date->toDateString(),
                    'created_at' => now(),
                ]);
            };
        }, $to);
        return $dates;
    }

    public function FifthOfEachMonth($from, $to, $task_id)
    {
        $from = new Carbon($from);
        $to = new Carbon($to);

        $date = $from->format('d') <= 05 ? $from : $from->addMonth()->firstOfMonth()->addDays(4);

        while ($date->lte($to)) {
            $dates[] = [
                'task_id' => $task_id,
                'trigger_date' => $date->toDateString(),
                'created_at' => now(),
            ];
            $date->addMonth();
        }
        return $dates;
    }

    public function FifthMarchEachYear($from, $to, $task_id)
    {
        $from = new Carbon($from);
        $to = new Carbon($to);

        $date = $from->format('m-d') <= 03 - 05 ? $from : new Carbon($from->addYear()->year . '-03-05');

        while ($date->lte($to)) {
            $dates[] = [
                'task_id' => $task_id,
                'trigger_date' => $date->toDateString(),
                'created_at' => now(),
            ];
            $date->addYear();
        }
        return $dates;
    }

    public function changeIterationStatus(){
        TaskIteration::find(request()->iteration_id)->update(['status'=>1]);
        return response()->json([
            'status' => 'success',
        ]);
    }
}
