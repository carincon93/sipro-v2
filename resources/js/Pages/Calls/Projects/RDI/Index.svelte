<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let rdi
    export let call

    $title = $_('RDI.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexRDI     = authUser.can.find(element => element == 'rdi.index') == 'rdi.index'
    let canCreateRDI    = authUser.can.find(element => element == 'rdi.create') == 'rdi.create'
    let canShowRDI      = authUser.can.find(element => element == 'rdi.show') == 'rdi.show'
    let canEditRDI      = authUser.can.find(element => element == 'rdi.edit') == 'rdi.edit'
    let canDeleteRDI    = authUser.can.find(element => element == 'rdi.delete') == 'rdi.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('RDI.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateRDI || isSuperAdmin}
            <Link href={route('calls.rdi.create', [call.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">proyecto {$_('RDI.singular')}</span>
                </div>
            </Link>
        {/if}
    </div>
    <div class="bg-white rounded shadow ">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Título</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Fecha de ejecución</th>
                </tr>
            </thead>
            <tbody>
                {#each rdi.data as rdi (rdi.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditRDI || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.rdi.edit', [call.id, rdi.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {rdi.title}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {rdi.title}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditRDI || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.rdi.edit', [call.id, rdi.id])}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {rdi.start_date}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {rdi.start_date}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if rdi.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={rdi.links} />
</AuthenticatedLayout>
