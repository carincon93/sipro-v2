
<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexCalls = authUser.can.find(element => element == 'calls.index') == 'calls.index'
    let canIndexUsers = authUser.can.find(element => element == 'users.index') == 'users.index'
    let canIndexRegional = authUser.can.find(element => element == 'regional.index') == 'regional.index'
    let canIndexAcademicCentres = authUser.can.find(element => element == 'academic-centres.index') == 'academic-centres.index'
    let canIndexAcademicPrograms = authUser.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'
    let canIndexKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.index') == 'knowledge-areas.index'
    let canIndexKnowledgeSubareas = authUser.can.find(element => element == 'knowledge-subareas.index') == 'knowledge-subareas.index'
    let canIndexKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.index') == 'knowledge-subarea-disciplines.index'
    let canIndexProgrammaticLines = authUser.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'
    let canIndexKnowledgeNetworks = authUser.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'
    let canIndexStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.index') == 'strategic-thematics.index'
    let canIndexProjectTypes = authUser.can.find(element => element == 'project-types.index') == 'project-types.index'
    let canIndexProductiveSectors = authUser.can.find(element => element == 'productive-sectors.index') == 'productive-sectors.index'
    let canIndexTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.index') == 'technical-committees.index'
    let canIndexPrioritizedTopics = authUser.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'
    let canIndexResearchGroups = authUser.can.find(element => element == 'research-groups.index') == 'research-groups.index'
    let canIndexResearchLines = authUser.can.find(element => element == 'research-lines.index') == 'research-lines.index'
    let canIndexResearchTeams = authUser.can.find(element => element == 'research-teams.index') == 'research-teams.index'
    let canIndexRoles = authUser.can.find(element => element == 'roles.index') == 'roles.index'
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1 class="font-bold text-5xl">Convocatoria 2022</h1>
                <p class="text-2xl mt-4">El proceso empezó el 15 de mayo de 2021 y finaliza el 15 de junio de 2021.</p>
                {#if canIndexCalls || isSuperAdmin}
                    <a use:inertia href={route('calls.index')} class="bg-indigo-600 hover:bg-indigo-500 inline-block mt-4 overflow-hidden px-6 py-2 shadow-sm sm:rounded-lg text-white transition-colors">
                        {$_('Calls.plural')}
                    </a>
                {/if}
            </div>
            <div>
                <figure>
                    <img src="/storage/images/dashboard.png" alt="">
                </figure>
            </div>
        </div>
    </header>
    <div class="py-12">
        <div class="grid grid-cols-3 gap-10">
            {#if canIndexUsers || isSuperAdmin}
                <a use:inertia href={route('users.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Users.plural')}
                </a>
            {/if}
            {#if canIndexRegional || isSuperAdmin}
                <a use:inertia href={route('regional.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Regional.plural')}
                </a>
            {/if}
            {#if canIndexAcademicCentres || isSuperAdmin}
                <a use:inertia href={route('academic-centres.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Academic centres.plural')}
                </a>
            {/if}
            {#if canIndexAcademicPrograms || isSuperAdmin}
                <a use:inertia href={route('academic-programs.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Academic programs.plural')}
                </a>
            {/if}
            {#if canIndexKnowledgeAreas || isSuperAdmin}
                <a use:inertia href={route('knowledge-areas.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Knowledge areas.plural')}
                </a>
            {/if}
            {#if canIndexKnowledgeSubareas || isSuperAdmin}
                <a use:inertia href={route('knowledge-subareas.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Knowledge subareas.plural')}
                </a>
            {/if}
            {#if canIndexKnowledgeSubareaDisciplines || isSuperAdmin}
                <a use:inertia href={route('knowledge-subarea-disciplines.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Knowledge subarea disciplines.plural')}
                </a>
            {/if}
            {#if canIndexProgrammaticLines || isSuperAdmin}
                <a use:inertia href={route('programmatic-lines.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Programmatic lines.plural')}
                </a>
            {/if}
            {#if canIndexKnowledgeNetworks || isSuperAdmin}
                <a use:inertia href={route('knowledge-networks.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Knowledge networks.plural')}
                </a>
            {/if}
            {#if canIndexStrategicThematics || isSuperAdmin}
                <a use:inertia href={route('strategic-thematics.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Strategic thematics.plural')}
                </a>
            {/if}
            {#if canIndexProjectTypes || isSuperAdmin}
                <a use:inertia href={route('project-types.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Project types.plural')}
                </a>
            {/if}
            {#if canIndexProductiveSectors || isSuperAdmin}
                <a use:inertia href={route('productive-sectors.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Productive sectors.plural')}
                </a>
            {/if}
            {#if canIndexTechnicalCommittees || isSuperAdmin}
                <a use:inertia href={route('technical-committees.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Technical committees.plural')}
                </a>
            {/if}
            {#if canIndexPrioritizedTopics || isSuperAdmin}
                <a use:inertia href={route('prioritized-topics.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Prioritized topics.plural')}
                </a>
            {/if}
            {#if canIndexResearchGroups || isSuperAdmin}
                <a use:inertia href={route('research-groups.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Research groups.plural')}
                </a>
            {/if}
            {#if canIndexResearchLines || isSuperAdmin}
                <a use:inertia href={route('research-lines.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Research lines.plural')}
                </a>
            {/if}
            {#if canIndexResearchTeams || isSuperAdmin}
                <a use:inertia href={route('research-teams.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Research teams.plural')}
                </a>
            {/if}
            {#if canIndexRoles || isSuperAdmin}
                <a use:inertia href={route('roles.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('System roles.plural')}
                </a>
            {/if}
        </div>
    </div>
</AuthenticatedLayout>

