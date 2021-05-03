<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let projectTypes = []

    $title = $_('Project types.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectTypes    = authUser.can.find(element => element == 'project-types.index') == 'project-types.index'
    let canShowProjectTypes     = authUser.can.find(element => element == 'project-types.show') == 'project-types.show'
    let canCreateProjectTypes   = authUser.can.find(element => element == 'project-types.create') == 'project-types.create'
    let canEditProjectTypes     = authUser.can.find(element => element == 'project-types.edit') == 'project-types.edit'
    let canDeleteProjectTypes   = authUser.can.find(element => element == 'project-types.delete') == 'project-types.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Project types.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateProjectTypes || isSuperAdmin}
            <a use:inertia href={route('project-types.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Project types.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Línea programática</th>
                </tr>
            </thead>
            <tbody>
                {#each projectTypes.data as projectType (projectType.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditProjectTypes || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('project-types.edit', projectType.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectType.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectType.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditProjectTypes || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('project-types.edit', projectType.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectType.programmatic_line?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectType.programmatic_line?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if projectTypes.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={projectTypes.links} />
</AuthenticatedLayout>
