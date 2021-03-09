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
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
