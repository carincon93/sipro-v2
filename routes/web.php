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

// use App\Http\Controllers\API\AnnexeController as AnnexeAPIController;
// use App\Http\Controllers\API\PartnerOrganizationController as PartnerOrganizationAPIController;
// use App\Http\Controllers\API\RiskAnalysisController as RiskAnalysisAPIController;
// use App\Http\Controllers\API\ProjectSennovaBudgetController as ProjectSennovaBudgetAPIController;
// use App\Http\Controllers\API\CallBudgetController as CallBudgetAPIController;
// use App\Http\Controllers\API\BudgetProgrammaticLineController as BudgetProgrammaticLineAPIController;
// use App\Http\Controllers\API\SennovaBudgetController as SennovaBudgetAPIController;
// use App\Http\Controllers\API\ThirdBudgetInfoController as ThirdBudgetInfoAPIController;
// use App\Http\Controllers\API\SecondBudgetInfoController as SecondBudgetInfoAPIController;
// use App\Http\Controllers\API\FirstBudgetInfoController as FirstBudgetInfoAPIController;
// use App\Http\Controllers\API\ProjectSennovaRoleController as ProjectSennovaRoleAPIController;
// use App\Http\Controllers\API\SennovaRoleController as SennovaRoleAPIController;
// use App\Http\Controllers\API\CallSennovaRoleController as CallSennovaRoleAPIController;
// use App\Http\Controllers\API\IndirectCauseController as IndirectCauseAPIController;
// use App\Http\Controllers\API\ActivityController as ActivityAPIController;
// use App\Http\Controllers\API\DirectEffectController as DirectEffectAPIController;
// use App\Http\Controllers\API\DirectCauseController as DirectCauseAPIController;
// use App\Http\Controllers\API\RDIController as RDIAPIController;
// use App\Http\Controllers\API\CallController as CallAPIController;
// use App\Http\Controllers\API\RoleController as RoleAPIController;
// use App\Http\Controllers\API\ResearchTeamController as ResearchTeamAPIController;
// use App\Http\Controllers\API\ResearchLineController as ResearchLineAPIController;
// use App\Http\Controllers\API\ResearchGroupController as ResearchGroupAPIController;
// use App\Http\Controllers\API\PrioritizedTopicController as PrioritizedTopicAPIController;
// use App\Http\Controllers\API\TechnicalCommitteeController as TechnicalCommitteeAPIController;
// use App\Http\Controllers\API\ProductiveSectorController as ProductiveSectorAPIController;
// use App\Http\Controllers\API\ProjectTypeController as ProjectTypeAPIController;
// use App\Http\Controllers\API\StrategicThematicController as StrategicThematicAPIController;
// use App\Http\Controllers\API\KnowledgeNetworkController as KnowledgeNetworkAPIController;
// use App\Http\Controllers\API\KnowledgeSubareaDisciplineController as KnowledgeSubareaDisciplineAPIController;
// use App\Http\Controllers\API\KnowledgeSubareaController as KnowledgeSubareaAPIController;
// use App\Http\Controllers\API\KnowledgeAreaController as KnowledgeAreaAPIController;
// use App\Http\Controllers\API\ProgrammaticLineController as ProgrammaticLineAPIController;
// use App\Http\Controllers\API\AcademicProgramController as AcademicProgramAPIController;
// use App\Http\Controllers\API\RegionalController as RegionalAPIController;
// use App\Http\Controllers\API\UserController as UserAPIController;
// use App\Http\Controllers\API\AcademicCentreController as AcademicCentreAPIController;

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

    Route::get('calls/{call}/projects/{project}/participants', [ProjectController::class, 'participants'])->name('calls.projects.participants');

    // Resources
    Route::resource('regional', RegionalController::class);
    Route::resource('users', UserController::class);
    Route::resource('academic-centres', AcademicCentreController::class);
    Route::resource('academic-programs', AcademicProgramController::class);
    Route::resource('programmatic-lines', ProgrammaticLineController::class);
    Route::resource('knowledge-areas', KnowledgeAreaController::class);
    Route::resource('knowledge-subareas', KnowledgeSubareaController::class);
    Route::resource('knowledge-subarea-disciplines', KnowledgeSubareaDisciplineController::class);
    Route::resource('knowledge-networks', KnowledgeNetworkController::class);
    Route::resource('strategic-thematics', StrategicThematicController::class);
    Route::resource('project-types', ProjectTypeController::class);
    Route::resource('productive-sectors', ProductiveSectorController::class);
    Route::resource('technical-committees', TechnicalCommitteeController::class);
    Route::resource('prioritized-topics', PrioritizedTopicController::class);
    Route::resource('research-groups', ResearchGroupController::class);
    Route::resource('research-lines', ResearchLineController::class);
    Route::resource('research-teams', ResearchTeamController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('calls', CallController::class);
    Route::resource('calls.rdi', RDIController::class);
    Route::resource('calls.rdi.rdi-outputs', RDIOutputController::class);
    Route::resource('calls.projects.activities', ActivityController::class);
    Route::resource('calls.projects.project-sennova-budgets', ProjectSennovaBudgetController::class);
    Route::resource('calls.projects.project-sennova-roles', ProjectSennovaRoleController::class);
    Route::resource('calls.projects.risk-analysis', RiskAnalysisController::class);
    Route::resource('calls.rdi.partner-organizations', PartnerOrganizationController::class);
    Route::resource('calls.projects.annexes', AnnexeController::class);
    Route::resource('sennova-roles', SennovaRoleController::class);
    Route::resource('projects.direct-causes', DirectCauseController::class);
    Route::resource('projects.direct-effects', DirectEffectController::class);
    Route::resource('direct-causes.indirect-causes', IndirectCauseController::class);
    Route::resource('call-sennova-roles', CallSennovaRoleController::class);
    Route::resource('first-budget-info', FirstBudgetInfoController::class);
    Route::resource('second-budget-info', SecondBudgetInfoController::class);
    Route::resource('third-budget-info', ThirdBudgetInfoController::class);
    Route::resource('sennova-budgets', SennovaBudgetController::class);
    Route::resource('budgets-programmatic-lines', BudgetProgrammaticLineController::class);
    Route::resource('call-budgets', CallBudgetController::class);

    // API Resources
    // Route::apiResources(['api/annexes' => AnnexeAPIController::class]);
    // Route::apiResources(['api/partner-organizations' => PartnerOrganizationAPIController::class]);
    // Route::apiResources(['api/risk-analysis' => RiskAnalysisAPIController::class]);
    // Route::apiResources(['api/project-sennova-budgets' => ProjectSennovaBudgetAPIController::class]);
    // Route::apiResources(['api/call-budgets' => CallBudgetAPIController::class]);
    // Route::apiResources(['api/budgets-programmatic-lines' => BudgetProgrammaticLineAPIController::class]);
    // Route::apiResources(['api/sennova-budgets' => SennovaBudgetAPIController::class]);
    // Route::apiResources(['api/third-budget-info' => ThirdBudgetInfoAPIController::class]);
    // Route::apiResources(['api/second-budget-info' => SecondBudgetInfoAPIController::class]);
    // Route::apiResources(['api/first-budget-info' => FirstBudgetInfoAPIController::class]);
    // Route::apiResources(['api/calls/{call}/projects/{project}/project-sennova-roles' => ProjectSennovaRoleAPIController::class]);
    // Route::apiResources(['api/sennova-roles' => SennovaRoleAPIController::class]);
    // Route::apiResources(['api/call-sennova-roles' => CallSennovaRoleAPIController::class]);
    // Route::apiResources(['api/direct-causes/{direct_cause}/indirect-causes' => IndirectCauseAPIController::class]);
    // Route::apiResources(['api/specific-objectives/{specific_objective}&activities' => ActivityAPIController::class]);
    // Route::apiResources(['api/projects/{project}/direct-effects' => DirectEffectAPIController::class]);
    // Route::apiResources(['api/projects/{project}direct-causes' => DirectCauseAPIController::class)];
    // Route::apiResources(['api/rdi-outputs' => RDIOutputAPIController::class]);
    // Route::apiResources(['api/rdi' => RDIAPIController::class]);
    // Route::apiResources(['api/calls' => CallAPIController::class]);
    // Route::apiResources(['api/roles' => RoleAPIController::class]);
    // Route::apiResources(['api/research-teams' => ResearchTeamAPIController::class]);
    // Route::apiResources(['api/research-lines' => ResearchLineAPIController::class]);
    // Route::apiResources(['api/research-groups' => ResearchGroupAPIController::class]);
    // Route::apiResources(['api/prioritized-topics' => PrioritizedTopicAPIController::class]);
    // Route::apiResources(['api/technical-committees' => TechnicalCommitteeAPIController::class]);
    // Route::apiResources(['api/productive-sectors' => ProductiveSectorAPIController::class]);
    // Route::apiResources(['api/project-types' => ProjectTypeAPIController::class]);
    // Route::apiResources(['api/strategic-thematics' => StrategicThematicAPIController::class]);
    // Route::apiResources(['api/knowledge-networks' => KnowledgeNetworkAPIController::class]);
    // Route::apiResources(['api/knowledge-subarea-disciplines' => KnowledgeSubareaDisciplineAPIController::class]);
    // Route::apiResources(['api/knowledge-subareas' => KnowledgeSubareaAPIController::class]);
    // Route::apiResources(['api/knowledge-areas' => KnowledgeAreaAPIController::class]);
    // Route::apiResources(['api/programmatic-lines' => ProgrammaticLineAPIController::class]);
    // Route::apiResources(['api/academic-programs' => AcademicProgramAPIController::class]);
    // Route::apiResources(['api/academic-centres' => AcademicCentreAPIController::class]);
    // Route::apiResources(['api/users' => UserAPIController::class]);
    // Route::apiResources(['api/regional' => RegionalAPIController::class]);
});

require __DIR__.'/auth.php';
