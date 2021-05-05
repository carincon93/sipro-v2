<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let mincienciasSubtypologies = []

    $title = $_('Minciencias subtypologies.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                       = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexMincienciasSubtypologies   = authUser.can.find(element => element == 'minciencias-subtypologies.index') == 'minciencias-subtypologies.index'
    let canShowMincienciasSubtypologies    = authUser.can.find(element => element == 'minciencias-subtypologies.show') == 'minciencias-subtypologies.show'
    let canCreateMincienciasSubtypologies  = authUser.can.find(element => element == 'minciencias-subtypologies.create') == 'minciencias-subtypologies.create'
    let canEditMincienciasSubtypologies    = authUser.can.find(element => element == 'minciencias-subtypologies.edit') == 'minciencias-subtypologies.edit'
    let canDeleteMincienciasSubtypologies  = authUser.can.find(element => element == 'minciencias-subtypologies.delete') == 'minciencias-subtypologies.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Minciencias subtypologies.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateMincienciasSubtypologies || isSuperAdmin}
            <a use:inertia href={route('minciencias-subtypologies.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Minciencias subtypologies.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Tipología Minciencias</th>
                </tr>
            </thead>
            <tbody>
                {#each mincienciasSubtypologies.data as mincienciasSubtypology (mincienciasSubtypology.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditMincienciasSubtypologies || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('minciencias-subtypologies.edit', mincienciasSubtypology.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {mincienciasSubtypology.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {mincienciasSubtypology.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditMincienciasSubtypologies || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('minciencias-subtypologies.edit', mincienciasSubtypology.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {mincienciasSubtypology.minciencias_typology?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {mincienciasSubtypology.minciencias_typology?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if mincienciasSubtypologies.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={mincienciasSubtypologies.links} />
</AuthenticatedLayout>
