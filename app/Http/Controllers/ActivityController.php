<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, Project $project)
    {
        $this->authorize('viewAny', [Activity::class]);

        $specificObjective = $project->directCauses()->with('specificObjective')->get()->pluck('specificObjective')->flatten()->filter();

        return Inertia::render('Calls/Projects/Activities/Index', [
            'call'          => $call,
            'project'       => $project,
            'filters'       => request()->all('search'),
            'activities'    => Activity::whereIn('specific_objective_id',
                            $specificObjective->map(function ($specificObjective) {
                                return $specificObjective->id;
                            }))->filterActivity(request()->only('search'))->orderBy('start_date', 'ASC')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, Project $project)
    {
        $this->authorize('create', [Activity::class]);

        return Inertia::render('Calls/Projects/Activities/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request, Call $call, Project $project)
    {
        $this->authorize('create', [Activity::class]);

        $activity = new Activity();
        $activity->fieldName = $request->fieldName;
        $activity->fieldName = $request->fieldName;
        $activity->fieldName = $request->fieldName;

        $activity->save();

        return redirect()->route('projects.activities.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show( Call $call, Project $project, Activity $activity)
    {
        $this->authorize('view', [Activity::class, $activity]);

        return Inertia::render('Calls/Projects/Activities/Show', [
            'activity' => $activity
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit( Call $call, Project $project, Activity $activity)
    {
        $this->authorize('update', [Activity::class, $activity]);

        return Inertia::render('Calls/Projects/Activities/Edit', [
            'activity' => $activity
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request,  Call $call, Project $project, Activity $activity)
    {
        $this->authorize('update', [Activity::class, $activity]);

        $activity->fieldName = $request->fieldName;
        $activity->fieldName = $request->fieldName;
        $activity->fieldName = $request->fieldName;

        $activity->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy( Call $call, Project $project, Activity $activity)
    {
        $this->authorize('delete', [Activity::class, $activity]);

        $activity->delete();

        return redirect()->route('projects.activities.index')->with('success', 'The resource has been deleted successfully.');
    }
}
