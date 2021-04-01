<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\AcademicCentreController;
use App\Http\Controllers\AcademicProgramController;
use App\Http\Controllers\ProgrammaticLineController;
use App\Http\Controllers\KnowledgeAreaController;
use App\Http\Controllers\KnowledgeSubareaController;
use App\Http\Controllers\KnowledgeSubareaDisciplineController;
use App\Http\Controllers\KnowledgeNetworkController;
use App\Http\Controllers\StrategicThematicController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProductiveSectorController;
use App\Http\Controllers\TechnicalCommitteeController;
use App\Http\Controllers\PrioritizedTopicController;
use App\Http\Controllers\ResearchGroupController;
use App\Http\Controllers\ResearchLineController;
use App\Http\Controllers\ResearchTeamController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\RDIController;
use App\Http\Controllers\ProjectTreeController;
use App\Http\Controllers\RDIOutputController;
use App\Http\Controllers\DirectCauseController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DirectEffectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\IndirectCauseController;
use App\Http\Controllers\CallSennovaRoleController;
use App\Http\Controllers\SennovaRoleController;
use App\Http\Controllers\ProjectSennovaRoleController;
use App\Http\Controllers\FirstBudgetInfoController;
use App\Http\Controllers\SecondBudgetInfoController;
use App\Http\Controllers\ThirdBudgetInfoController;
use App\Http\Controllers\SennovaBudgetController;
use App\Http\Controllers\BudgetProgrammaticLineController;
use App\Http\Controllers\CallBudgetController;
use App\Http\Controllers\ProjectSennovaBudgetController;
use App\Http\Controllers\RiskAnalysisController;
use App\Http\Controllers\PartnerOrganizationController;
use App\Http\Controllers\AnnexeController;
use App\Http\Controllers\CIIUCodeController;

use App\Models\ResearchLine;
use App\Models\ProjectType;
use App\Models\KnowledgeNetwork;
use App\Models\KnowledgeSubareaDiscipline;
use App\Models\CIIUCode;
use App\Models\StrategicThematic;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'    => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Muestra las líneas programáticas para empezar la formulación de proyectos
    Route::get('calls/{call}/dashboard', [CallController::class, 'dashboard'])->name('calls.dashboard');
    // Muestra el árbol de problemas
    Route::get('calls/{call}/projects/{project}/problem-tree', [ProjectTreeController::class, 'showProblemTree'])->name('calls.projects.problem-tree');
    // Muestra el árbol de objetivos
    Route::get('calls/{call}/projects/{project}/objectives-tree', [ProjectTreeController::class, 'showObjectivesTree'])->name('calls.projects.objectives-tree');
    // Muestra los participantes
    Route::get('calls/{call}/projects/{project}/participants', [ProjectController::class, 'participants'])->name('calls.projects.participants');

    // Trae las líneas de investigación
    Route::get('web-api/research-lines', function() {
        return response(ResearchLine::selectRaw('research_lines.id as value, concat(research_lines.name ||chr(10)|| research_groups.name ||chr(10)|| academic_centres.name ||chr(10)|| regional.name) as label')->join('research_groups', 'research_lines.research_group_id', 'research_groups.id')->join('academic_centres', 'research_groups.academic_centre_id','academic_centres.id')->join('regional', 'academic_centres.regional_id', 'regional.id')->get());
    })->name('web-api.research-lines');
    // Trae los tipos de proyectos
    Route::get('web-api/project-types', function() {
        return response(ProjectType::selectRaw('project_types.id as value, concat(project_types.name ||chr(10)|| programmatic_lines.name) as label')->join('programmatic_lines', 'project_types.programmatic_line_id', 'programmatic_lines.id')->get());
    })->name('web-api.project-types');
    // Trae las redes de conocimiento sectorial
    Route::get('web-api/knowledge-networks', function() {
        return response(KnowledgeNetwork::select('knowledge_networks.id as value', 'knowledge_networks.name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.knowledge-networks');
    // Trae las disciplinas de subáreas de conocimiento
    Route::get('web-api/knowledge-subarea-disciplines', function() {
        return response(KnowledgeSubareaDiscipline::select('knowledge_subarea_disciplines.id as value', 'knowledge_subarea_disciplines.name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.knowledge-subarea-disciplines');
    // Trae los códigos CIIU
    Route::get('web-api/ciiu-codes', function() {
        return response(CIIUCode::select('ciiu_codes.id as value', 'ciiu_codes.name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.ciiu-codes');
    // Trae las temáticas estrategicas SENA
    Route::get('web-api/strategic-thematics', function() {
        return response(StrategicThematic::select('strategic_thematics.id as value', 'strategic_thematics.name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.strategic-thematics');

    // Resources
    Route::resources(
        [
            'ciiu-codes' => CIIUCodeController::class,
            'regional' => RegionalController::class,
            'users' => UserController::class,
            'academic-centres' => AcademicCentreController::class,
            'academic-programs' => AcademicProgramController::class,
            'programmatic-lines' => ProgrammaticLineController::class,
            'knowledge-areas' => KnowledgeAreaController::class,
            'knowledge-subareas' => KnowledgeSubareaController::class,
            'knowledge-subarea-disciplines' => KnowledgeSubareaDisciplineController::class,
            'knowledge-networks' => KnowledgeNetworkController::class,
            'strategic-thematics' => StrategicThematicController::class,
            'project-types' => ProjectTypeController::class,
            'productive-sectors' => ProductiveSectorController::class,
            'technical-committees' => TechnicalCommitteeController::class,
            'prioritized-topics' => PrioritizedTopicController::class,
            'research-groups' => ResearchGroupController::class,
            'research-lines' => ResearchLineController::class,
            'research-teams' => ResearchTeamController::class,
            'roles' => RoleController::class,
            'calls' => CallController::class,
            'calls.rdi' => RDIController::class,
            'calls.rdi.rdi-outputs' => RDIOutputController::class,
            'calls.projects.activities' => ActivityController::class,
            'calls.projects.project-sennova-budgets' => ProjectSennovaBudgetController::class,
            'calls.projects.project-sennova-roles' => ProjectSennovaRoleController::class,
            'calls.projects.risk-analysis' => RiskAnalysisController::class,
            'calls.rdi.partner-organizations' => PartnerOrganizationController::class,
            'calls.projects.annexes' => AnnexeController::class,
            'sennova-roles' => SennovaRoleController::class,
            'projects.direct-causes' => DirectCauseController::class,
            'projects.direct-effects' => DirectEffectController::class,
            'direct-causes.indirect-causes' => IndirectCauseController::class,
            'call-sennova-roles' => CallSennovaRoleController::class,
            'first-budget-info' => FirstBudgetInfoController::class,
            'second-budget-info' => SecondBudgetInfoController::class,
            'third-budget-info' => ThirdBudgetInfoController::class,
            'sennova-budgets' => SennovaBudgetController::class,
            'budgets-programmatic-lines' => BudgetProgrammaticLineController::class,
            'call-budgets' => CallBudgetController::class,
        ]
    );
});

require __DIR__.'/auth.php';
