<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Regional' => 'App\Policies\RegionalPolicy',
        'App\Models\AcademicCentre' => 'App\Policies\AcademicCentrePolicy',
        'App\Models\AcademicProgram' => 'App\Policies\AcademicProgramPolicy',
        'App\Models\ProgrammaticLine' => 'App\Policies\ProgrammaticLinePolicy',
        'App\Models\KnowledgeArea' => 'App\Policies\KnowledgeAreaPolicy',
        'App\Models\KnowledgeSubarea' => 'App\Policies\KnowledgeSubareaPolicy',
        'App\Models\KnowledgeSubareaDiscipline' => 'App\Policies\KnowledgeSubareaDisciplinePolicy',
        'App\Models\KnowledgeNetwork' => 'App\Policies\KnowledgeNetworkPolicy',
        'App\Models\StrategicThematic' => 'App\Policies\StrategicThematicPolicy',
        'App\Models\ProjectType' => 'App\Policies\ProjectTypePolicy',
        'App\Models\ProductiveSector' => 'App\Policies\ProductiveSectorPolicy',
        'App\Models\TechnicalCommittee' => 'App\Policies\TechnicalCommitteePolicy',
        'App\Models\PrioritizedTopic' => 'App\Policies\PrioritizedTopicPolicy',
        'App\Models\ResearchGroup' => 'App\Policies\ResearchGroupPolicy',
        'App\Models\ResearchLine' => 'App\Policies\ResearchLinePolicy',
        'App\Models\ResearchTeam' => 'App\Policies\ResearchTeamPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Call' => 'App\Policies\CallPolicy',
        'App\Models\RDI' => 'App\Policies\RDIPolicy',
        'App\Models\RDIOutput' => 'App\Policies\RDIOutputPolicy',
        'App\Models\DirectEffect' => 'App\Policies\DirectEffectPolicy',
        'App\Models\Activity' => 'App\Policies\ActivityPolicy',
        'App\Models\IndirectCause' => 'App\Policies\IndirectCausePolicy',
        'App\Models\CallSennovaRole' => 'App\Policies\CallSennovaRolePolicy',
        'App\Models\SennovaRole' => 'App\Policies\SennovaRolePolicy',
        'App\Models\ProjectSennovaRole' => 'App\Policies\ProjectSennovaRolePolicy',
        'App\Models\FirstBudgetInfo' => 'App\Policies\FirstBudgetInfoPolicy',
        'App\Models\SecondBudgetInfo' => 'App\Policies\SecondBudgetInfoPolicy',
        'App\Models\ThirdBudgetInfo' => 'App\Policies\ThirdBudgetInfoPolicy',
        'App\Models\SennovaBudget' => 'App\Policies\SennovaBudgetPolicy',
        'App\Models\CallBudget' => 'App\Policies\CallBudgetPolicy',
        'App\Models\ProjectSennovaBudget' => 'App\Policies\ProjectSennovaBudgetPolicy',
        'App\Models\RiskAnalysis' => 'App\Policies\RiskAnalysisPolicy',
        'App\Models\PartnerOrganization' => 'App\Policies\PartnerOrganizationPolicy',
        'App\Models\Annexe' => 'App\Policies\AnnexePolicy',
        'App\Models\CIIUCode' => 'App\Policies\CIIUCodePolicy',
        'App\Models\MincienciasSubtypology' => 'App\Policies\MincienciasSubtypologyPolicy',
        'App\Models\MincienciasTypology' => 'App\Policies\MincienciasTypologyPolicy',
        'App\Models\ProjectAnnexe' => 'App\Policies\ProjectAnnexePolicy',
        'App\Models\BudgetUsage' => 'App\Policies\BudgetUsagePolicy',
        'App\Models\ProjectBudgetBatch' => 'App\Policies\ProjectBudgetBatchPolicy',
        'App\Models\MarketResearch' => 'App\Policies\MarketResearchPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerSuperAdminPolicy();
    }

    public function registerSuperAdminPolicy()
    {
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole(1) ? true : null;
        // });
    }
}
