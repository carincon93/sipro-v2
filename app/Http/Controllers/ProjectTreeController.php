<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\ResearchResultRequest;
use App\Http\Requests\ActivityRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\DirectEffect;
use App\Models\IndirectEffect;
use App\Models\DirectCause;
use App\Models\IndirectCause;
use App\Models\ResearchResult;
use App\Models\Impact;
use App\Models\SpecificObjective;
use App\Models\Activity;

class ProjectTreeController extends Controller
{

    private function generateTree(Project $project)
    {
        if($project->directEffects()->count()<4){
            for ($i=0; $i < (4-$project->directEffects()->count()); $i++) {
                $result = $project->directEffects()->create([
                    ['description' => null],
                ]);

                $result2 = $result->researchResult()->create([
                    ['description' => null],
                ]);
            }
        }
        if($project->directCauses()->count()<4){
            for ($i=0; $i < (5-$project->directCauses()->count()); $i++) {
                $result = $project->directCauses()->create([
                    ['description' => null],
                ]);

                $result2 = $result->SpecificObjective()->create([
                    ['description' => null],
                ]);
            }
        }

        foreach($project->directEffects()->get() as $directEffect){
            if(empty($directEffect->researchResult)){
                $result = $directEffect->researchResult()->create([
                    ['description' => null],
                ]);
            }
            foreach($directEffect->indirectEffects as $indEffect){
                if(empty($indEffect->impact)){
                    $rest = $indEffect->impact()->create([
                        ['description' => null],
                    ]);
                }
            }
        }

        foreach($project->directCauses()->get() as $directCause){
            if(empty($directCause->SpecificObjective)){
                $result = $directCause->SpecificObjective()->create([
                    ['description' => null],
                ]);
            }
            
            foreach($directCause->indirectCauses as $indCause){
                if(empty($indCause->activity)){
                    $rest = $indCause->activity()->create([
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

        }elseif(!empty($request->id)){
            $indEffect = IndirectEffect::find($request->id);
            $indEffect->description = $request->description;
            $indEffect->save();

        }else{
            return redirect()->back()->with('errors', 'Cannot add more indirect effects.');
        }

        if(empty($indEffect->impact)){
            $rest = $indEffect->impact()->create([
                ['description' => null],
            ]);
        }

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
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

        }elseif(!empty($request->id)){
            $indCause = IndirectCause::find($request->id);
            $indCause->description = $request->description;
            $indCause->save();

        }else{
            return redirect()->back()->with('errors', 'Cannot add more indirect causes.');
        }

        if(empty($indCause->activity)){
            $rest = $indCause->activity()->create([
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
                $directEffects = $project->directEffects()->with(['indirectEffects.impact', 'researchResult'])->get();
                $directCauses = $project->directCauses()->with('indirectCauses.activity', 'SpecificObjective')->get();
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
        
        return Inertia::render('Calls/Projects/ProjectTree/ObjectivesTree', [
            'call'      => $call,
            'project'   => $rdi,
            'directEffects' => $directEffects,
            'directCauses'  => $directCauses
        ]);
    }

    public function updateObjective(Project $project, Request $request)
    {
        $validated = $request->validate([
            'primary_objective' => 'required|string|max:1200',
        ]);
        $rdi = $project->rdi;
        $rdi->primary_objective = $request->primary_objective;

        $rdi->save();

        return redirect()->back()->with('success', 'The resource has been saved successfully.');
    }

    public function updateImpact(Project $project, Impact $impact, Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1200',
        ]);

        $impact->description=$request->description;
        
        if($impact->save()){
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }
        return redirect()->back()->with('errors', 'Error updating impact.');
    }

    public function updateResearchResult(Project $project, ResearchResult $research_result, ResearchResultRequest $request)
    {
        $research_result->fill($request->all());
        
        if($research_result->save()){
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }
        return redirect()->back()->with('errors', 'Error updating result.');
    }

    public function updateSpecificObjective(Project $project, SpecificObjective $specific_objective, Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1200',
            'number' => 'required|integer',
        ]);

        $specific_objective->description=$request->description;
        $specific_objective->number=$request->number;
        
        if($specific_objective->save()){
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }
        return redirect()->back()->with('errors', 'Error updating specific objective.');
    }

    public function updateActivity(Call $call, Project $project, Activity $activity, ActivityRequest $request)
    {
        $activity->fill($request->all());
        
        if($activity->save()){
            return redirect()->back()->with('success', 'The resource has been saved successfully.');
        }
        return redirect()->back()->with('errors', 'Error updating activity.');
    }

    
}
