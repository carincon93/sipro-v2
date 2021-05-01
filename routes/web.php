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
use App\Http\Controllers\OutputController;
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
use App\Http\Controllers\CallBudgetController;
use App\Http\Controllers\ProjectSennovaBudgetController;
use App\Http\Controllers\RiskAnalysisController;
use App\Http\Controllers\PartnerOrganizationController;
use App\Http\Controllers\AnnexeController;
use App\Http\Controllers\CIIUCodeController;
use App\Http\Controllers\MincienciasTypologyController;
use App\Http\Controllers\MincienciasSubtypologyController;
use App\Http\Controllers\ProjectAnnexeController;
use App\Http\Controllers\BudgetUsageController;
use App\Http\Controllers\ProjectBudgetBatchController;
use App\Http\Controllers\MarketResearchController;
use App\Http\Controllers\PartnerOrganizationMemberController;
use App\Http\Controllers\TechnoAcademyController;
use App\Http\Controllers\TechnologicalLineController;
use App\Http\Controllers\SectorBasedCommitteeController;

use App\Models\ResearchLine;
use App\Models\ProjectType;
use App\Models\KnowledgeNetwork;
use App\Models\KnowledgeSubareaDiscipline;
use App\Models\CIIUCode;
use App\Models\StrategicThematic;
use App\Models\AcademicCentre;
use App\Models\Regional;
use App\Models\ResearchGroup;
use App\Models\MincienciasSubtypology;
use App\Models\ProgrammaticLine;
use App\Models\CallSennovaRole;
use App\Models\SecondBudgetInfo;
use App\Models\ThirdBudgetInfo;
use App\Models\SennovaBudget;
use App\Models\TechnoAcademy;
use App\Models\TechnologicalLine;

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
    // Actualiza el problema general del proyecto en el arbol de problemas
    Route::post('projects/{project}/research-problem', [ProjectTreeController::class, 'updateProblem'])->name('projects.research_problem');
    // Actualiza efecto directo en el arbol de problemas
    Route::post('projects/{project}/direct-effect/{direct_effect}', [ProjectTreeController::class, 'updateDirectEffect'])->name('projects.direct_effect');
    // Crea o Actualiza efecto indirecto en el arbol de problemas
    Route::post('projects/{project}/indirect-effect/{direct_effect}', [ProjectTreeController::class, 'createOrUpdateIndirectEffect'])->name('projects.indirect_effect');
    // Actualiza causa directa en el arbol de problemas
    Route::post('projects/{project}/direct-cause/{direct_cause}', [ProjectTreeController::class, 'updateDirectCause'])->name('projects.direct_cause');
    // Crea o Actualiza causa indirecta en el arbol de problemas
    Route::post('projects/{project}/indirect-cause/{direct_cause}', [ProjectTreeController::class, 'createOrUpdateIndirectCause'])->name('projects.indirect_cause');

    // Muestra el árbol de objetivos
    Route::get('calls/{call}/projects/{project}/objectives-tree', [ProjectTreeController::class, 'showObjectivesTree'])->name('calls.projects.objectives-tree');
    // Actualiza el impacto en el arbol de objetivos
    Route::post('projects/{project}/impact/{impact}', [ProjectTreeController::class, 'updateImpact'])->name('projects.impact');
    // Actualiza el impacto en el arbol de objetivos
    Route::post('projects/{project}/research_result/{research_result}', [ProjectTreeController::class, 'updateResearchResult'])->name('projects.research_result');
    // Actualiza el problema general del proyecto en el arbol de problemas
    Route::post('projects/{project}/primary-objective', [ProjectTreeController::class, 'updateObjective'])->name('projects.primary_objective');
    // Actualiza el objetivo especifico en el arbol de objetivos
    Route::post('projects/{project}/specific_objective/{specific_objective}', [ProjectTreeController::class, 'updateSpecificObjective'])->name('projects.specific_objective');
    // Actualiza la actividad en el arbol de objetivos
    Route::post('calls/{call}/projects/{project}/activity/{activity}', [ProjectTreeController::class, 'updateActivity'])->name('projects.activity');

    // Muestra los participantes
    Route::get('calls/{call}/projects/{project}/participants', [ProjectController::class, 'participants'])->name('calls.projects.participants');

    Route::get('calls/{call}/projects/{project}/project-annexes/{project_annexe}/download', [ProjectAnnexeController::class, 'download'])->name('calls.projects.project-annexes.download');
    Route::get('calls/{call}/projects/{project}/project-sennova-budgets/{project_sennova_budget}/project-budget-batches/{project_budget_batch}/download', [ProjectBudgetBatchController::class, 'download'])->name('calls.projects.project-sennova-budgets.project-budget-batches.download');
    Route::get('calls/{call}/projects/{project}/project-sennova-budgets/{project_sennova_budget}/project-budget-batches/{project_budget_batch}/market-research/{market_research}/download', [MarketResearchController::class, 'download'])->name('calls.projects.project-sennova-budgets.project-budget-batches.download-price-qoute-file');

    // Trae las Tecnoacademias
    Route::get('web-api/techno-academies', function() {
        return response(TechnoAcademy::select('techno_academies.id as value', 'techno_academies.name as label')->get());
    })->name('web-api.techno-academies');
    // Trae las líneas tecnológicas
    Route::get('web-api/techno-academies/{techno_academy}/technological-lines', function($technoAcademy) {
        return response(TechnologicalLine::select('id', 'name')->where('technological_lines.techno_academy_id', $technoAcademy)->get());
    })->name('web-api.techno-academies.technological-lines');
    // Trae las líneas de investigación
    Route::get('web-api/research-lines', function() {
        return response(ResearchLine::selectRaw('research_lines.id as value, concat(research_lines.name, chr(10), \'∙ Grupo de investigación: \', research_groups.name, chr(10), \'∙ Centro de formación: \', academic_centres.name, chr(10), \'∙ Regional: \', regional.name) as label')->join('research_groups', 'research_lines.research_group_id', 'research_groups.id')->join('academic_centres', 'research_groups.academic_centre_id','academic_centres.id')->join('regional', 'academic_centres.regional_id', 'regional.id')->get());
    })->name('web-api.research-lines');
    // Trae los tipos de proyectos
    Route::get('web-api/project-types', function() {
        return response(ProjectType::selectRaw('project_types.id as value, concat(project_types.name, chr(10), \'∙ Línea programática: \', programmatic_lines.name) as label')->join('programmatic_lines', 'project_types.programmatic_line_id', 'programmatic_lines.id')->get());
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
    // Trae los centros de formación
    Route::get('web-api/academic-centres', function() {
        return response(AcademicCentre::selectRaw('academic_centres.id as value, concat(academic_centres.name, chr(10), \'∙ Código: \', academic_centres.code, chr(10), \'∙ Regional: \', regional.name) as label')->join('regional', 'academic_centres.regional_id', 'regional.id')->orderBy('academic_centres.name', 'ASC')->get());
    })->name('web-api.academic-centres');
    // Trae las regionales
    Route::get('web-api/regional', function() {
        return response(Regional::select('id as value', 'name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.regional');
    // Trae las líneas programáticas
    Route::get('web-api/programmatic-lines', function() {
        return response(ProgrammaticLine::select('id as value', 'name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.programmatic-lines');
    // Trae las líneas programáticas
    Route::get('web-api/research-groups', function() {
        return response(ResearchGroup::selectRaw('research_groups.id as value, concat(research_groups.name, chr(10), \'∙ Acrónimo: \', research_groups.acronym, chr(10), \'∙ Centro de formación: \', academic_centres.name, chr(10), \'∙ Regional: \', regional.name) as label')->join('academic_centres', 'research_groups.academic_centre_id', 'academic_centres.id')->join('regional', 'academic_centres.regional_id', 'regional.id')->get());
    })->name('web-api.research-groups');
    // Trae las subtipologías Minciencias
    Route::get('web-api/minciencias-subtypologies', function() {
        return response(MincienciasSubtypology::selectRaw('minciencias_subtypologies.id as value, concat(minciencias_subtypologies.name, chr(10), \'∙ Tipología Minciencias: \', minciencias_typologies.name) as label')->join('minciencias_typologies', 'minciencias_subtypologies.minciencias_typology_id', 'minciencias_typologies.id')->orderBy('minciencias_subtypologies.name')->get());
    })->name('web-api.minciencias-subtypologies');

    // Trae los conceptos internos SENA
    Route::get('web-api/second-budget-info', function() {
        return response(SecondBudgetInfo::select('second_budget_info.id as value', 'second_budget_info.name as label')->orderBy('name', 'ASC')->get());
    })->name('web-api.second-budget-info');

    Route::get('web-api/third-budget-info/{secondBudgetInfo}', function($secondBudgetInfo) {
        return response(ThirdBudgetInfo::selectRaw('DISTINCT(third_budget_info.id) as value, third_budget_info.name as label')
            ->join('sennova_budgets', 'third_budget_info.id', 'sennova_budgets.third_budget_info_id')
            ->where('sennova_budgets.second_budget_info_id', $secondBudgetInfo)
            ->get());
    })->name('web-api.third-budget-info');
    // Trae los usos presupuestales
    Route::get('web-api/calls/{call}/programmatic-lines/{programmaticLine}/sennova-budgets/second-budget-info/{secondBudgetInfo}/third-budget-info/{thirdBudgetInfo}', function($call, $programmaticLine, $secondBudgetInfo, $thirdBudgetInfo) {
        return response(SennovaBudget::select('call_budgets.id as value', 'budget_usages.description as label')
            ->join('budget_usages', 'sennova_budgets.budget_usage_id', 'budget_usages.id')
            ->join('call_budgets', 'sennova_budgets.id', 'call_budgets.sennova_budget_id')
            ->where('call_budgets.call_id', $call)
            ->where('sennova_budgets.programmatic_line_id', $programmaticLine)
            ->where('sennova_budgets.second_budget_info_id', $secondBudgetInfo)
            ->where('sennova_budgets.third_budget_info_id', $thirdBudgetInfo)
            ->orderBy('budget_usages.description', 'ASC')->get());
    })->name('web-api.budget-usages');

    Route::get('web-api/call-budgets/{call_budget}', function($callBudget) {
        return response(SennovaBudget::select('sennova_budgets.requires_market_research', 'sennova_budgets.message')
            ->join('call_budgets', 'sennova_budgets.id', 'call_budgets.sennova_budget_id')
            ->where('call_budgets.id', $callBudget)
            ->first());
    })->name('web-api.budget-requires-market-research');

    Route::get('web-api/calls/{call}/{programmaticLine}/project-sennova-roles', function($call, $programmaticLine) {
        return response(CallSennovaRole::selectRaw('call_sennova_roles.id as value, concat(sennova_roles.name, chr(10), \'∙ Asignación mensual: \', call_sennova_roles.salary) as label, call_sennova_roles.qty_months, call_sennova_roles.qty_roles')
            ->join('sennova_roles', 'call_sennova_roles.sennova_role_id', 'sennova_roles.id')
            ->where('sennova_roles.programmatic_line_id', $programmaticLine)
            ->where('call_sennova_roles.call_id', $call)
            ->orderBy('sennova_roles.name')->get());
    })->name('web-api.calls.project-sennova-roles');

    // Resources
    Route::resource('calls.projects.risk-analysis', RiskAnalysisController::class)->parameters(['risk-analysis' => 'risk_analysis']);
    Route::resource('calls.projects.project-annexes', ProjectAnnexeController::class)->parameters(['project-annexes' => 'project-annexe']);
    Route::resource('annexes', AnnexeController::class)->parameters(['annexes' => 'annexe']);
    Route::resources(
        [
            'sector-based-committees' => SectorBasedCommitteeSectorBasedCommitteeController::class,
            'technological-lines' => TechnologicalLineController::class,
            'techno-academies' => TechnoAcademyController::class,
            'calls.projects.project-sennova-budgets.project-budget-batches' => ProjectBudgetBatchController::class,
            'budget-usages' => BudgetUsageController::class,
            'minciencias-typologies' => MincienciasTypologyController::class,
            'minciencias-subtypologies' => MincienciasSubtypologyController::class,
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
            'calls.projects.outputs' => OutputController::class,
            'calls.projects.activities' => ActivityController::class,
            'calls.projects.project-sennova-budgets' => ProjectSennovaBudgetController::class,
            'calls.projects.project-sennova-roles' => ProjectSennovaRoleController::class,
            'calls.rdi.partner-organizations' => PartnerOrganizationController::class,
            'calls.rdi.partner-organizations.partner-organization-members' => PartnerOrganizationMemberController::class,
            'calls.call-sennova-roles' => CallSennovaRoleController::class,
            'projects.direct-causes' => DirectCauseController::class,
            'projects.direct-effects' => DirectEffectController::class,
            'direct-causes.indirect-causes' => IndirectCauseController::class,
            'first-budget-info' => FirstBudgetInfoController::class,
            'second-budget-info' => SecondBudgetInfoController::class,
            'third-budget-info' => ThirdBudgetInfoController::class,
            'sennova-budgets' => SennovaBudgetController::class,
            'sennova-roles' => SennovaRoleController::class,
            'call-budgets' => CallBudgetController::class,
        ]
    );
});

require __DIR__.'/auth.php';
