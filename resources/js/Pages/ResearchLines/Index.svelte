<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let researchLines = []

    $title = $_('Research lines.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchLines   = authUser.can.find(element => element == 'research-lines.index') == 'research-lines.index'
    let canShowResearchLines    = authUser.can.find(element => element == 'research-lines.show') == 'research-lines.show'
    let canCreateResearchLines  = authUser.can.find(element => element == 'research-lines.create') == 'research-lines.create'
    let canEditResearchLines    = authUser.can.find(element => element == 'research-lines.edit') == 'research-lines.edit'
    let canDeleteResearchLines  = authUser.can.find(element => element == 'research-lines.delete') == 'research-lines.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Research lines.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateResearchLines || isSuperAdmin}
            <a use:inertia href={route('research-lines.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Research lines.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <tbody>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Centro de formación</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Regional</th>
                </tr>
            </tbody>
            <thead>
                {#each researchLines.data as researchLine (researchLine.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditResearchLines || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-lines.edit', researchLine.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchLine.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchLine.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditResearchLines || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-lines.edit', researchLine.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchLine.research_group?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchLine.research_group?.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditResearchLines || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-lines.edit', researchLine.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchLine.research_group?.academic_centre?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchLine.research_group?.academic_centre?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if researchLines.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </thead>
        </table>
    </div>
    <Pagination links={researchLines.links} />
</AuthenticatedLayout>
