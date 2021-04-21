<?php

namespace App\Http\Controllers;

use App\Models\Call;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\DirectEffect;
use App\Models\IndirectEffect;
use App\Models\DirectCause;
use App\Models\IndirectCause;

class ProjectTreeController extends Controller
{
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
                if($project->directEffects()->count()<4){
                    for ($i=0; $i < (4-$project->directEffects()->count()); $i++) {
                        $result = $project->directEffects()->create([
                            ['description' => null],
                        ]);
                    }
                }
                if($project->directCauses()->count()<4){
                    for ($i=0; $i < (5-$project->directCauses()->count()); $i++) {
                        $result = $project->directCauses()->create([
                            ['description' => null],
                        ]);
                    }
                }
                $directEffects = $project->directEffects()->with('indirectEffects')->get();
                $directCauses = $project->directCauses()->with('indirectCauses')->get();
                $rdi = $project->rdi()->first();
                break;
            case 'value':
                # code...
                break;
            case 'value':
                # code...
                break;
            default:
                # code...
                break;
        }
        return Inertia::render('Calls/Projects/ProjectTree/ProblemTree', [
            'call'      => $call,
            'project'   => $rdi,
            'directEffects' => $directEffects,
            'directCauses'  => $directCauses
        ]);
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
                $project = $project->rdi()->first();
                break;
            case 'value':
                # code...
                break;
            case 'value':
                # code...
                break;
            default:
                # code...
                break;
        }
        return Inertia::render('Calls/Projects/ProjectTree/ObjectivesTree', [
            'call'      => $call,
            'project'   => $project
        ]);
    }

    public function updateProblem(Project $project, Request $request)
    {
        $validated = $request->validate([
            'research_problem' => 'required|string|max:1200',
        ]);
        $rdi = $project->rdi;
        $rdi->research_problem = $request->research_problem;

        $rdi->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    public function updateDirectEffect(Project $project, DirectEffect $direct_effect, Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1200',
        ]);
        $direct_effect->description = $request->description;

        $direct_effect->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    public function createOrUpdateIndirectEffect(Project $project, DirectEffect $direct_effect, Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1200',
        ]);
        if(empty($request->id) && $direct_effect->indirectEffects()->count() < 3){
            $indEffect = new IndirectEffect();
            $indEffect->fill($request->all());
            $indEffect->save();

            return redirect()->back()->with('success', 'The resource has been saved successfully.');

        }elseif(!empty($request->id)){
            $indEffect = IndirectEffect::find($request->id);
            $indEffect->description = $request->description;
            $indEffect->save();

            return redirect()->back()->with('success', 'The resource has been saved successfully.');

        }

        return redirect()->back()->with('errors', 'Cannot add more indirect effects.');
    }

    public function updateDirectCause(Project $project, DirectCause $direct_cause, Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1200',
        ]);
        $direct_cause->description = $request->description;

        $direct_cause->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    public function createOrUpdateIndirectCause(Project $project, DirectCause $direct_cause, Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1200',
        ]);
        if(empty($request->id) && $direct_cause->indirectCauses()->count() < 3){
            $indCause = new IndirectCause();
            $indCause->fill($request->all());
            $indCause->save();

            return redirect()->back()->with('success', 'The resource has been saved successfully.');

        }elseif(!empty($request->id)){
            $indCause = IndirectCause::find($request->id);
            $indCause->description = $request->description;
            $indCause->save();

            return redirect()->back()->with('success', 'The resource has been saved successfully.');

        }

        return redirect()->back()->with('errors', 'Cannot add more indirect causes.');
    }
}
