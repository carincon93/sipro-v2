<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'

    import Stepper from '@/Components/Stepper'

    export let call
    export let project
    export let projectSennovaRoles = []

    $title = $_('Project sennova roles.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectSennovaRoles     = authUser.can.find(element => element == 'project-sennova-roles.index') == 'project-sennova-roles.index'
    let canShowProjectSennovaRoles      = authUser.can.find(element => element == 'project-sennova-roles.show') == 'project-sennova-roles.show'
    let canCreateProjectSennovaRoles    = authUser.can.find(element => element == 'project-sennova-roles.create') == 'project-sennova-roles.create'
    let canEditProjectSennovaRoles      = authUser.can.find(element => element == 'project-sennova-roles.edit') == 'project-sennova-roles.edit'
    let canDeleteProjectSennovaRoles    = authUser.can.find(element => element == 'project-sennova-roles.delete') == 'project-sennova-roles.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <h1 class="font-bold text-3xl m-24 text-center">{$_('Project sennova roles.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateProjectSennovaRoles || isSuperAdmin}
            <a use:inertia href={route('calls.projects.project-sennova-roles.create', [call.id, project.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Project sennova roles.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Salario</th>
                </tr>
            </thead>
            <tbody>
                {#each projectSennovaRoles.data as projectSennovaRole (projectSennovaRole.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditProjectSennovaRoles || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.project-sennova-roles.edit', [call.id, project.id, projectSennovaRole.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectSennovaRole?.call_sennova_role?.sennova_role?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectSennovaRole?.call_sennova_role?.sennova_role?.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditProjectSennovaRoles || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.project-sennova-roles.edit', [call.id, project.id, projectSennovaRole.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectSennovaRole?.call_sennova_role?.salary}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {projectSennovaRole?.call_sennova_role?.salary}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if projectSennovaRoles.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={projectSennovaRoles.links} />
</AuthenticatedLayout>

