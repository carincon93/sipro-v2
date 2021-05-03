<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let researchTeams = []

    $title = $_('Research teams.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchTeams   = authUser.can.find(element => element == 'research-teams.index') == 'research-teams.index'
    let canShowResearchTeams    = authUser.can.find(element => element == 'research-teams.show') == 'research-teams.show'
    let canCreateResearchTeams  = authUser.can.find(element => element == 'research-teams.create') == 'research-teams.create'
    let canEditResearchTeams    = authUser.can.find(element => element == 'research-teams.edit') == 'research-teams.edit'
    let canDeleteResearchTeams  = authUser.can.find(element => element == 'research-teams.delete') == 'research-teams.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Research teams.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateResearchTeams || isSuperAdmin}
            <a use:inertia href={route('research-teams.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Research teams.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Línea de investigación</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Grupo de investigación</th>
                </tr>
            </thead>
            <tbody>
                {#each researchTeams.data as researchTeam (researchTeam.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditResearchTeams || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-teams.edit', researchTeam.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchTeam.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchTeam.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditResearchTeams || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-teams.edit', researchTeam.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchTeam.research_line?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchTeam.research_line?.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditResearchTeams || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-teams.edit', researchTeam.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchTeam.research_line?.research_group?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchTeam.research_line?.research_group?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if researchTeams.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={researchTeams.links} />
</AuthenticatedLayout>
