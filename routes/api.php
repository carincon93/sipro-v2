<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AnnexeController as AnnexeAPIController;
use App\Http\Controllers\API\PartnerOrganizationController as PartnerOrganizationAPIController;
use App\Http\Controllers\API\RiskAnalysisController as RiskAnalysisAPIController;
use App\Http\Controllers\API\ProjectSennovaBudgetController as ProjectSennovaBudgetAPIController;
use App\Http\Controllers\API\CallBudgetController as CallBudgetAPIController;
use App\Http\Controllers\API\BudgetProgrammaticLineController as BudgetProgrammaticLineAPIController;
use App\Http\Controllers\API\SennovaBudgetController as SennovaBudgetAPIController;
use App\Http\Controllers\API\ThirdBudgetInfoController as ThirdBudgetInfoAPIController;
use App\Http\Controllers\API\SecondBudgetInfoController as SecondBudgetInfoAPIController;
use App\Http\Controllers\API\FirstBudgetInfoController as FirstBudgetInfoAPIController;
use App\Http\Controllers\API\ProjectSennovaRoleController as ProjectSennovaRoleAPIController;
use App\Http\Controllers\API\SennovaRoleController as SennovaRoleAPIController;
use App\Http\Controllers\API\CallSennovaRoleController as CallSennovaRoleAPIController;
use App\Http\Controllers\API\IndirectCauseController as IndirectCauseAPIController;
use App\Http\Controllers\API\ActivityController as ActivityAPIController;
use App\Http\Controllers\API\DirectEffectController as DirectEffectAPIController;
use App\Http\Controllers\API\DirectCauseController as DirectCauseAPIController;
use App\Http\Controllers\API\RDIController as RDIAPIController;
use App\Http\Controllers\API\RDIOutputController as RDIOutputAPIController;
use App\Http\Controllers\API\CallController as CallAPIController;
use App\Http\Controllers\API\RoleController as RoleAPIController;
use App\Http\Controllers\API\ResearchTeamController as ResearchTeamAPIController;
use App\Http\Controllers\API\ResearchLineController as ResearchLineAPIController;
use App\Http\Controllers\API\ResearchGroupController as ResearchGroupAPIController;
use App\Http\Controllers\API\PrioritizedTopicController as PrioritizedTopicAPIController;
use App\Http\Controllers\API\TechnicalCommitteeController as TechnicalCommitteeAPIController;
use App\Http\Controllers\API\ProductiveSectorController as ProductiveSectorAPIController;
use App\Http\Controllers\API\ProjectTypeController as ProjectTypeAPIController;
use App\Http\Controllers\API\StrategicThematicController as StrategicThematicAPIController;
use App\Http\Controllers\API\KnowledgeNetworkController as KnowledgeNetworkAPIController;
use App\Http\Controllers\API\KnowledgeSubareaDisciplineController as KnowledgeSubareaDisciplineAPIController;
use App\Http\Controllers\API\KnowledgeSubareaController as KnowledgeSubareaAPIController;
use App\Http\Controllers\API\KnowledgeAreaController as KnowledgeAreaAPIController;
use App\Http\Controllers\API\ProgrammaticLineController as ProgrammaticLineAPIController;
use App\Http\Controllers\API\AcademicProgramController as AcademicProgramAPIController;
use App\Http\Controllers\API\RegionalController as RegionalAPIController;
use App\Http\Controllers\API\UserController as UserAPIController;
use App\Http\Controllers\API\AcademicCentreController as AcademicCentreAPIController;
use App\Http\Controllers\API\CIIUCodeController as CIIUCodeAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    // API Resources
    Route::apiResources(
        [
            'annexes' => AnnexeAPIController::class,
            'partner-organizations' => PartnerOrganizationAPIController::class,
            'risk-analysis' => RiskAnalysisAPIController::class,
            'project-sennova-budgets' => ProjectSennovaBudgetAPIController::class,
            'call-budgets' => CallBudgetAPIController::class,
            'budgets-programmatic-lines' => BudgetProgrammaticLineAPIController::class,
            'sennova-budgets' => SennovaBudgetAPIController::class,
            'third-budget-info' => ThirdBudgetInfoAPIController::class,
            'second-budget-info' => SecondBudgetInfoAPIController::class,
            'first-budget-info' => FirstBudgetInfoAPIController::class,
            'calls.projects.project-sennova-roles' => ProjectSennovaRoleAPIController::class,
            'sennova-roles' => SennovaRoleAPIController::class,
            'call-sennova-roles' => CallSennovaRoleAPIController::class,
            'direct-causes.indirect-causes' => IndirectCauseAPIController::class,
            'specific-objectives.activities' => ActivityAPIController::class,
            'projects.direct-effects' => DirectEffectAPIController::class,
            'projects.direct-causes' => DirectCauseAPIController::class,
            'rdi-outputs' => RDIOutputAPIController::class,
            'rdi' => RDIAPIController::class,
            'calls' => CallAPIController::class,
            'roles' => RoleAPIController::class,
            'research-teams' => ResearchTeamAPIController::class,
            'research-lines' => ResearchLineAPIController::class,
            'research-groups' => ResearchGroupAPIController::class,
            'prioritized-topics' => PrioritizedTopicAPIController::class,
            'technical-committees' => TechnicalCommitteeAPIController::class,
            'productive-sectors' => ProductiveSectorAPIController::class,
            'project-types' => ProjectTypeAPIController::class,
            'strategic-thematics' => StrategicThematicAPIController::class,
            'knowledge-networks' => KnowledgeNetworkAPIController::class,
            'knowledge-subarea-disciplines' => KnowledgeSubareaDisciplineAPIController::class,
            'knowledge-subareas' => KnowledgeSubareaAPIController::class,
            'knowledge-areas' => KnowledgeAreaAPIController::class,
            'programmatic-lines' => ProgrammaticLineAPIController::class,
            'academic-programs' => AcademicProgramAPIController::class,
            'academic-centres' => AcademicCentreAPIController::class,
            'users' => UserAPIController::class,
            'regional' => RegionalAPIController::class,
            'ciiu-codes' => CIIUCodeAPIController::class
        ]
    );
});

