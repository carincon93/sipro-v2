<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let programmaticLines = []

    $title = $_('Programmatic lines.plural')

    /**
     * Permisos
     */
    let authUser    = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProgrammaticLines   = authUser.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'
    let canShowProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.show') == 'programmatic-lines.show'
    let canCreateProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.create') == 'programmatic-lines.create'
    let canEditProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.edit') == 'programmatic-lines.edit'
    let canDeleteProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.delete') == 'programmatic-lines.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Programmatic lines.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateProgrammaticLines || isSuperAdmin}
            <a use:inertia href={route('programmatic-lines.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Programmatic lines.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Código</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Categoría</th>
                </tr>
            </thead>
            <tbody>
                {#each programmaticLines.data as programmaticLine (programmaticLine.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditProgrammaticLines || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('programmatic-lines.edit', programmaticLine.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {programmaticLine.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {programmaticLine.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditProgrammaticLines || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('programmatic-lines.edit', programmaticLine.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {programmaticLine.code}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {programmaticLine.code}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditProgrammaticLines || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('programmatic-lines.edit', programmaticLine.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {programmaticLine.project_category}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {programmaticLine.project_category}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if programmaticLines.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={programmaticLines.links} />
</AuthenticatedLayout>
