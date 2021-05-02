<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectResultRequest;
use App\Http\Requests\ActivityRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\DirectEffect;
use App\Models\IndirectEffect;
use App\Models\DirectCause;
use App\Models\IndirectCause;
use App\Models\projectResult;
use App\Models\Impact;
use App\Models\SpecificObjective;
use App\Models\Activity;

class ProjectTreeController extends Controller
{
    /**
     * generateTree
     *
     * @param  mixed $project
     * @return void
     */
    private function generateTree(Project $project)
    {
        $specificObjectives = [];
        if ($project->directCauses()->count() < 4) {
            for ($i=0; $i < 4; $i++) {
                $directCause = $project->directCauses()->create([
                    ['description' => null],
                ]);

                $specificObjective = $directCause->specificObjective()->create([
                    'description'   => null,
                    'number'        => $i + 1,
                ]);

                array_push($specificObjectives, $specificObjective);
            }
        }

        if ($project->directEffects()->count() < 4) {
            for ($i=0; $i < 4; $i++) {
                $directEffect = $project->directEffects()->create([
                    ['description' => null],
                ]);

                $projectResult = $directEffect->projectResult()->create([
                    'description'           => null,
                    'specific_objective_id' => $specificObjectives[$i]->id
                ]);
            }
        }

        foreach ($project->directEffects()->get() as $key => $directEffect) {
            foreach ($directEffect->indirectEffects as $indirectEffect) {
                if (empty($indirectEffect->impact)) {
                    $impact = $indirectEffect->impact()->create([
                        ['description' => null],
                    ]);
                }
            }
        }

        foreach ($project->directCauses()->get() as $directCause) {
            foreach ($directCause->indirectCauses as $indirectCause) {
                if (empty($indirectCause->activity)) {
                    $activity = $indirectCause->activity()->create([
                        ['description' => null],
                    ]);
                }
            }
        }
    }

    /**
     * showProblemTree
     *
     * @param  mixed $call
     * @param  mixed $project
     * @return void
     */
    public function showProblemTree(Call $call, Project $project)
    {
        switch ($project) {
            case $project->rdi()->exists():
                $this->generateTree($project);
                $directEffects  = $project->directEffects()->with('indirectEffects:id,direct_effect_id,description')->get();
                $directCauses   = $project->directCauses()->with('indirectCauses')->get();
                $rdi            = $project->rdi()->first();
                break;
            default:
                break;
        }
        return Inertia::render('Calls/Projects/ProjectTree/ProblemTree', [
            'call'          => $call,
            'project'       => $rdi,
            'directEffects' => $directEffects,
            'directCauses'  => $directCauses
        ]);
    }

    /**
     * updateProblem
     *
     * @param  mixed $request
     * @param  mixed $project
     * @return void
     */
    public function updateProblem(Request $request, Project $project)
    {
        $request->validate([
            'problem_statement' => 'required|string|max:1200',
        ]);

        $rdi = $project->rdi;
        $rdi->problem_statement     = $request->problem_statement;
        $rdi->problem_justification = $request->problem_justification;

        $rdi->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    /**
     * updateDirectEffect
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $directEffect
     * @return void
     */
    public function updateDirectEffect(Request $request, Project $project, DirectEffect $directEffect)
    {
        $request->validate([
            'description' => 'required|string|max:1200',
        ]);

        $directEffect->description = $request->description;

        $directEffect->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    /**
     * createOrUpdateIndirectEffect
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $directEffect
     * @return void
     */
    public function createOrUpdateIndirectEffect(Request $request, Project $project, DirectEffect $directEffect)
    {
        $request->validate([
            'description' => 'required|string|max:1200',
        ]);

        if (empty($request->id) && $directEffect->indirectEffects()->count() < 3) {
            $indirectEffect = new IndirectEffect();
            $indirectEffect->fill($request->all());
            $indirectEffect->save();

        } elseif (!empty($request->id)) {
            $indirectEffect = IndirectEffect::find($request->id);
            $indirectEffect->description = $request->description;
            $indirectEffect->save();

        } else {
            return redirect()->back()->with('error', 'Cannot add more indirect effects.');
        }

        if (empty($indirectEffect->impact)) {
            $indirectEffect->impact()->create([
                ['description' => null],
            ]);
        }

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    /**
     * updateDirectCause
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $directCause
     * @return void
     */
    public function updateDirectCause(Request $request, Project $project, DirectCause $directCause)
    {
        $request->validate([
            'description' => 'required|string|max:1200',
        ]);

        $directCause->description = $request->description;

        $directCause->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    /**
     * createOrUpdateIndirectCause
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $directCause
     * @return void
     */
    public function createOrUpdateIndirectCause(Request $request, Project $project, DirectCause $directCause)
    {
        $request->validate([
            'description' => 'required|string|max:1200',
        ]);

        if (empty($request->id) && $directCause->indirectCauses()->count() < 3) {
            $indirectCause = new IndirectCause();
            $indirectCause->fill($request->all());
            $indirectCause->save();
        } elseif (!empty($request->id)) {
            $indirectCause = IndirectCause::find($request->id);
            $indirectCause->description = $request->description;
            $indirectCause->save();
        } else {
            return redirect()->back()->with('error', 'Cannot add more indirect causes.');
        }

        if (empty($indirectCause->activity)) {
            $indirectCause->activity()->create([
                ['description' => null],
            ]);
        }

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    /**
     * showObjectivesTree
     *
     * @param  mixed $call
     * @param  mixed $project
     * @return void
     */
    public function showObjectivesTree(Call $call, Project $project)
    {
        switch ($project) {
            case $project->rdi()->exists():
                $this->generateTree($project);

                $directEffects  = $project->directEffects()->with('indirectEffects.impact', 'projectResult')->get();
                $directCauses   = $project->directCauses()->with('indirectCauses.activity', 'specificObjective')->get();
                $project        = $project->rdi()->first();
                break;
            default:
                break;
        }

        return Inertia::render('Calls/Projects/ProjectTree/ObjectivesTree', [
            'call'          => $call->only('id'),
            'project'       => $project,
            'directEffects' => $directEffects,
            'directCauses'  => $directCauses
        ]);
    }

    /**
     * updateObjective
     *
     * @param  mixed $request
     * @param  mixed $project
     * @return void
     */
    public function updateObjective(Request $request, Project $project)
    {
        $request->validate([
            'primary_objective' => 'required|string|max:1200',
        ]);

        $rdi                    = $project->rdi;
        $rdi->primary_objective = $request->primary_objective;

        $rdi->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    /**
     * updateImpact
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $impact
     * @return void
     */
    public function updateImpact(Request $request, Project $project, Impact $impact)
    {
        $request->validate([
            'description' => 'required|string|max:1200',
        ]);

        $impact->description    = $request->description;
        $impact->type           = $request->type;

        if ($impact->save()) {
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }

        return redirect()->back()->with('error', 'Error updating impact.');
    }

    /**
     * updateProjectResult
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $projectResult
     * @return void
     */
    public function updateProjectResult(ProjectResultRequest $request, Project $project, ProjectResult $projectResult)
    {
        $projectResult->fill($request->all());

        if ($projectResult->save()) {
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }

        return redirect()->back()->with('error', 'Error updating result.');
    }

    /**
     * updateSpecificObjective
     *
     * @param  mixed $request
     * @param  mixed $project
     * @param  mixed $specificObjective
     * @return void
     */
    public function updateSpecificObjective(Request $request, Project $project, SpecificObjective $specificObjective)
    {
        $request->validate([
            'description'   => 'required|string|max:1200',
            'number'        => 'required|integer',
        ]);

        $specificObjective->description = $request->description;
        $specificObjective->number      = $request->number;

        if ($specificObjective->save()) {
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }

        return redirect()->back()->with('error', 'Error updating specific objective.');
    }

    /**
     * updateActivity
     *
     * @param  mixed $request
     * @param  mixed $call
     * @param  mixed $project
     * @param  mixed $activity
     * @return void
     */
    public function updateActivity(ActivityRequest $request, Call $call, Project $project, Activity $activity)
    {
        $activity->fill($request->all());

        if ($activity->save()) {
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }

        return redirect()->back()->with('error', 'Error updating activity.');
    }
}
