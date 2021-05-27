<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ParticipantRequest;
use App\Http\Requests\ParticipantRegisterRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\User;
use App\Models\AcademicProgram;
use App\Models\ResearchTeam;

class ProjectController extends Controller
{
    /**
     * participants
     *
     * @return void
     */
    public function participants(Call $call, Project $project, Request $request)
    {
        // $this->authorize('viewAny', [Project::class]);

        $project->projectType->programmaticLine;
        $project->makeHidden(
            'rdi', 
            'projectSennovaBudgets', 
            'updated_at',
        );
        $project->load('participants.academicCentre.regional');
        $project->load('academicPrograms.academicCentre.regional');
        $project->load('researchTeams.researchLine.researchGroup');
        
        return Inertia::render('Calls/Projects/Finder/Participants', [
            'call'      => $call,
            'project'   => $project,
            'documentTypes'         => json_decode(Storage::get('json/document-types.json'), true),
            'participationTypes'    => json_decode(Storage::get('json/participation-types.json'), true),
        ]);
    }

    public function filterParticipants (Call $call, Project $project, Request $request)
    {
        if(!empty($request->search_participants)){
            $query = User::orderBy('name', 'ASC')
                ->filterUser(['search'=>$request->search_participants])
                ->with('academicCentre.regional');

                if($project->participants->count()>0){
                    $query->whereNotIn('id', explode(',', $project->participants->implode('id', ',')));
                }

            $users = $query->get();

            return $users->makeHidden('can', 'roles', 'user_name', 'permissions')->toJson();
        }

        return null;
    }

    public function linkParticipant(Call $call, Project $project, ParticipantRequest $request)
    {
        $data = $request->only('is_author', 'qty_hours', 'qty_months');

        try {
            if($project->participants()->where('id', $request->user_id)->exists()){
                return redirect()->back()->with('success', 'The resource is already linked.');
            }
            $project->participants()->attach($request->user_id, $data);
            return redirect()->back()->with('success', 'The resource has been link up successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }

        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }

    public function unlinkParticipant(Call $call, Project $project, Request $request)
    {
        $request->validate(['user_id'=>'required']);

        try {
            if($project->participants()->where('id', $request->user_id)->exists()){
                $project->participants()->detach($request->user_id);
                return redirect()->back()->with('success', 'The resource has been unlink up successfully.');
            }
            return redirect()->back()->with('success', 'The resource is already unlinked.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }
        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }

    public function updateParticipant(Call $call, Project $project, ParticipantRequest $request)
    {
        $data = $request->only('is_author', 'qty_hours', 'qty_months');

        try {
            if($project->participants()->where('id', $request->user_id)->exists()){
                $project->participants()->updateExistingPivot($request->user_id, $data);
                return redirect()->back()->with('success', 'The resource has been link up successfully.');
            }
            return redirect()->back()->with('error', 'The resource is already unlinked.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }

        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }

    public function registerParticipant(Call $call, Project $project, ParticipantRegisterRequest $request)
    {
        $this->authorize('create', [User::class]);

        $user = new User();

        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->password             = $user::makePassword($request->document_number);
        $user->document_type        = $request->document_type;
        $user->document_number      = $request->document_number;
        $user->cellphone_number     = $request->cellphone_number;
        $user->is_enabled           = 0;
        $user->participation_type   = $request->participation_type;
        $user->academicCentre()->associate($request->academic_centre_id);

        $user->save();

        $data = $request->only('is_author', 'qty_hours', 'qty_months');
        $data['user_id'] = $user->id; 

        return $this->linkParticipant($call, $project, new ParticipantRequest($data));
    }

    public function filterAcademicPrograms (Call $call, Project $project, Request $request)
    {
        if(!empty($request->search_programs)){
            $query = AcademicProgram::orderBy('name', 'ASC')
                ->filterAcademicProgram(['search'=>$request->search_programs])
                ->with('academicCentre.regional');

                if($project->academicPrograms->count()>0){
                    $query->whereNotIn('id', explode(',', $project->academicPrograms->implode('id', ',')));
                }

            $programs = $query->get();
            
            return $programs->makeHidden('created_at', 'updated_at')->toJson();
        }

        return null;
    }
    
    public function linkProgram(Call $call, Project $project, Request $request)
    {
        $request->validate(['program_academic_id'=>'required']);

        try {
            if($project->academicPrograms()->where('id', $request->program_academic_id)->exists()){
                return redirect()->back()->with('success', 'The resource is already linked.');
            }
            $project->academicPrograms()->attach($request->program_academic_id);
            return redirect()->back()->with('success', 'The resource has been link up successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }

        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }

    public function unlinkProgram(Call $call, Project $project, Request $request)
    {
        $request->validate(['program_academic_id'=>'required']);

        try {
            if($project->academicPrograms()->where('id', $request->program_academic_id)->exists()){
                $project->academicPrograms()->detach($request->program_academic_id);
                return redirect()->back()->with('success', 'The resource has been unlink up successfully.');
            }
            return redirect()->back()->with('success', 'The resource is already unlinked.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }
        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }
    

    public function filterResearchTeams (Call $call, Project $project, Request $request)
    {
        if(!empty($request->search_teams)){
            $query = ResearchTeam::orderBy('name', 'ASC')
                ->filterResearchTeam(['search'=>$request->search_teams])
                ->with('researchLine.researchGroup');

                if($project->researchTeams->count()>0){
                    $query->whereNotIn('id', explode(',', $project->researchTeams->implode('id', ',')));
                }

            $programs = $query->get();
            
            return $programs->makeHidden('created_at', 'updated_at')->toJson();
        }

        return null;
    }
    
    public function linkResearchTeam(Call $call, Project $project, Request $request)
    {
        $request->validate(['research_team_id'=>'required']);

        try {
            if($project->researchTeams()->where('id', $request->research_team_id)->exists()){
                return redirect()->back()->with('success', 'The resource is already linked.');
            }
            $project->researchTeams()->attach($request->research_team_id);
            return redirect()->back()->with('success', 'The resource has been link up successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }

        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }

    public function unlinkResearchTeam(Call $call, Project $project, Request $request)
    {
        $request->validate(['research_team_id'=>'required']);

        try {
            if($project->researchTeams()->where('id', $request->research_team_id)->exists()){
                $project->researchTeams()->detach($request->research_team_id);
                return redirect()->back()->with('success', 'The resource has been unlink up successfully.');
            }
            return redirect()->back()->with('success', 'The resource is already unlinked.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Whoops! Something went wrong.');
        }
        return redirect()->back()->with('error', 'Whoops! Something went wrong.');
    }
}
