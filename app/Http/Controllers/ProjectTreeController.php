<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::render('Calls/Projects/ProjectTree/ProblemTree', [
            'call'      => $call,
            'project'   => $project
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
}
