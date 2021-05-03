<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let regional = []

    $title = $_('Regional.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRegional    = authUser.can.find(element => element == 'regional.index') == 'regional.index'
    let canShowRegional     = authUser.can.find(element => element == 'regional.show') == 'regional.show'
    let canCreateRegional   = authUser.can.find(element => element == 'regional.create') == 'regional.create'
    let canEditRegional     = authUser.can.find(element => element == 'regional.edit') == 'regional.edit'
    let canDeleteRegional   = authUser.can.find(element => element == 'regional.delete') == 'regional.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Regional.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateRegional || isSuperAdmin}
            <a use:inertia href={route('regional.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Regional.singular')}</span>
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
                </tr>
            </thead>
            <tbody>
                {#each regional.data as regional (regional.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditRegional || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('regional.edit', regional.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {regional.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {regional.name}
                                </p>
                            {/if}
                        </td>

                        <td class="border-t">
                            {#if canEditRegional || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('regional.edit', regional.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {regional.code}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {regional.code}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if regional.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={regional.links} />
</AuthenticatedLayout>
