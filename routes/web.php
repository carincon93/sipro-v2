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

    // Route::apiResources(['api/roles' => RoleAPIController::class]);
    // Route::apiResources(['api/research-teams' => ResearchTeamAPIController::class]);
    // Route::apiResources(['api/research-lines' => ResearchLineAPIController::class]);
    // Route::apiResources(['api/research-groups' => ResearchGroupAPIController::class]);
    // Route::apiResources(['api/prioritized-topics' => PrioritizedTopicAPIController::class]);
    // Route::apiResources(['api/technical-committees' => TechnicalCommitteeAPIController::class]);
    // Route::apiResources(['apiproductive-sectors' => ProductiveSectorAPIController::class]);
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
