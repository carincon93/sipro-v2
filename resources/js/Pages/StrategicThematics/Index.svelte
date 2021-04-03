<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let strategicThematics = []

    $title = $_('Strategic thematics.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexStrategicThematics  = authUser.can.find(element => element == 'strategic-thematics.index') == 'strategic-thematics.index'
    let canShowStrategicThematics   = authUser.can.find(element => element == 'strategic-thematics.show') == 'strategic-thematics.show'
    let canCreateStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.create') == 'strategic-thematics.create'
    let canEditStrategicThematics   = authUser.can.find(element => element == 'strategic-thematics.edit') == 'strategic-thematics.edit'
    let canDeleteStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.destroy') == 'strategic-thematics.destroy'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Strategic thematics.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateStrategicThematics || isSuperAdmin}
            <Link href={route('strategic-thematics.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Strategic thematics.singular')}</span>
                </div>
            </Link>
        {/if}
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Nombre</th>
            </tr>
            {#each strategicThematics.data as strategicThematic (strategicThematic.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        {#if canEditStrategicThematics || isSuperAdmin}
                            <a
                                use:inertia
                                href={route('strategic-thematics.edit', strategicThematic.id)}
                                class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {strategicThematic.name}
                            </a>
                        {:else}
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {strategicThematic.name}
                            </p>
                        {/if}
                    </td>
                </tr>
            {/each}

            {#if strategicThematics.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </table>
    </div>
    <Pagination links={strategicThematics.links} />
</AuthenticatedLayout>
