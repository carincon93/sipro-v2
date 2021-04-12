<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'

    import Stepper from '@/Components/Stepper.svelte';

    export let call
    export let project
    export let annexes = []

    $title = $_('Annexes.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexAnnexes     = authUser.can.find(element => element == 'annexes.index') == 'annexes.index'
    let canShowAnnexes      = authUser.can.find(element => element == 'annexes.show') == 'annexes.show'
    let canCreateAnnexes    = authUser.can.find(element => element == 'annexes.create') == 'annexes.create'
    let canEditAnnexes      = authUser.can.find(element => element == 'annexes.edit') == 'annexes.edit'
    let canDeleteAnnexes    = authUser.can.find(element => element == 'annexes.delete') == 'annexes.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <h1 class="mb-8 font-bold text-3xl">{$_('Annexes.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateAnnexes || isSuperAdmin}
            <a use:inertia href={route('calls.projects.annexes.create', [call.id, project.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Annexes.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow ">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                </tr>
            </thead>
            <tbody>
                {#each annexes.data as annexe (annexe.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditAnnexes || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.annexes.edit', [call.id, project.id, annexe.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {annexe.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {annexe.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if annexes.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={annexes.links} />
</AuthenticatedLayout>
