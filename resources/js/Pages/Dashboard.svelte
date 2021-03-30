<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
</script>

<AuthenticatedLayout>
    <!-- <template #header> -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {$_("Dashboard")}
        </h2>
    <!-- </template> -->

    <div class="py-12">
        <div class="grid grid-cols-3 gap-10">
            {#if $page.props.auth.user.can.find(element => element == 'calls.index') == 'calls.index'}
                <a use:inertia href={route('calls.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Calls.plural")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'users.index') == 'users.index'}
                <a use:inertia href={route('users.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Users")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'regional.index') == 'regional.index'}
                <a use:inertia href={route('regional.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Regional")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'academic-centres.index') == 'academic-centres.index'}
                <a use:inertia href={route('academic-centres.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Academic centres")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'}
                <a use:inertia href={route('academic-programs.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Academic programs")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'knowledge-areas.index') == 'knowledge-areas.index'}
                <a use:inertia href={route('knowledge-areas.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Knowledge areas")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'knowledge-subareas.index') == 'knowledge-subareas.index'}
                <a use:inertia href={route('knowledge-subareas.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Knowledge subareas")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'knowledge-subarea-disciplines.index') == 'knowledge-subarea-disciplines.index'}
                <a use:inertia href={route('knowledge-subarea-disciplines.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Knowledge subarea disciplines")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'}
                <a use:inertia href={route('programmatic-lines.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Programmatic lines")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'}
                <a use:inertia href={route('knowledge-networks.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Knowledge networks")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'strategic-thematics.index') == 'strategic-thematics.index'}
                <a use:inertia href={route('strategic-thematics.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Strategc thematics")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'project-types.index') == 'project-types.index'}
                <a use:inertia href={route('project-types.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Project types")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'productive-sectors.index') == 'productive-sectors.index'}
                <a use:inertia href={route('productive-sectors.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Productive sectors")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'technical-committees.index') == 'technical-committees.index'}
                <a use:inertia href={route('technical-committees.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Technical committees")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'}
                <a use:inertia href={route('prioritized-topics.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Prioritized topics")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'research-groups.index') == 'research-groups.index'}
                <a use:inertia href={route('research-groups.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Research groups")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'research-lines.index') == 'research-lines.index'}
                <a use:inertia href={route('research-lines.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Research lines")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'research-teams.index') == 'research-teams.index'}
                <a use:inertia href={route('research-teams.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("Research teams")}
                </a>
            {/if}
            {#if $page.props.auth.user.can.find(element => element == 'roles.index') == 'roles.index'}
                <a use:inertia href={route('roles.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_("System roles")}
                </a>
            {/if}
        </div>
    </div>
</AuthenticatedLayout>

