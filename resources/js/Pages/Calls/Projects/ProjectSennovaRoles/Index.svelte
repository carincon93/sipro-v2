<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'
    import Stepper from '@/Components/Stepper.svelte'

    export let call
    export let project
    export let projectSennovaRoles = []

    $title = 'Roles de proyecto'

    let canCreateProjectSennovaRole = $page.props.auth.user.can.find(element => element == 'project-sennova-roles.create') == 'project-sennova-roles.create'

    let filters = {}
</script>

<Stepper {call} {project} />

<h1 class="mb-8 font-bold text-3xl">{$_('Project sennova roles.plural')}</h1>
<div class="mb-6 flex justify-between items-center">
    <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
    {#if canCreateProjectSennovaRole}
        <Link href={route('calls.projects.project-sennova-roles.create', [call.id, project.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
            <div>
                <span>{$_('Create')}</span>
                <span class="hidden md:inline">rol de proyecto</span>
            </div>
        </Link>
    {/if}
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4">Nombre</th>
            <th class="px-6 pt-6 pb-4">Salario</th>
        </tr>
        {#each projectSennovaRoles.data as projectSennovaRole (projectSennovaRole.id)}
        <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
                <a
                    use:inertia
                    href={route('calls.projects.project-sennova-roles.edit', [call.id, project.id, projectSennovaRole.id])}
                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                    {projectSennovaRole?.call_sennova_role?.sennova_role?.name}
                </a>
            </td>
            <td class="border-t">
                <a
                    use:inertia
                    href={route('calls.projects.project-sennova-roles.edit', [call.id, project.id, projectSennovaRole.id])}
                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                    {projectSennovaRole?.call_sennova_role?.salary}
                </a>
            </td>
        </tr>
        {/each}

        {#if projectSennovaRoles.data.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
            </tr>
        {/if}
    </table>
</div>
<Pagination links={projectSennovaRoles.links} />
