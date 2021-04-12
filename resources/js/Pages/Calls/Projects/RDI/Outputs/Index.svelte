<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'

    import Stepper from '@/Components/Stepper.svelte'
    import Gantt from '@/Components/Gantt.svelte'

    export let call
    export let project
    export let outputs

    $title = $_('Outputs.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRDIOutputs  = authUser.can.find(element => element == 'calls.rdi.rdi-outputs.index') == 'calls.rdi.rdi-outputs.index'
    let canShowRDIOutputs   = authUser.can.find(element => element == 'calls.rdi.rdi-outputs.show') == 'calls.rdi.rdi-outputs.show'
    let canCreateRDIOutputs = authUser.can.find(element => element == 'calls.rdi.rdi-outputs.create') == 'calls.rdi.rdi-outputs.create'
    let canEditRDIOutputs   = authUser.can.find(element => element == 'calls.rdi.rdi-outputs.edit') == 'calls.rdi.rdi-outputs.edit'
    let canDeleteRDIOutputs = authUser.can.find(element => element == 'calls.rdi.rdi-outputs.delete') == 'calls.rdi.rdi-outputs.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <Stepper call={call} {project} />

    <h1 class="font-bold text-3xl m-24 text-center">{$_('Outputs.plural')}</h1>
    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        <div>
            {#if canCreateRDIOutputs || isSuperAdmin}
                <a use:inertia href={route('calls.projects.outputs.create', [call.id, project.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo">
                    <div>
                        <span>{$_('Create')}</span>
                        <span class="hidden md:inline">{$_('Outputs.singular')}</span>
                    </div>
                </a>
            {/if}
        </div>
    </div>

    <Gantt items={outputs.data} request={canEditRDIOutputs || isSuperAdmin ? {'uri': 'calls.projects.outputs.edit', 'params': [call.id, project.id]} : null} />

    <Pagination links={outputs.links} />

</AuthenticatedLayout>

