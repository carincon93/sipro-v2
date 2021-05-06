<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'
    import DataTable from '@/Components/DataTable'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'

    export let regional = []

    $title = $_('Regional.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexRegional    = authUser.can.find(element => element == 'regional.index') == 'regional.index'
    let canShowRegional     = authUser.can.find(element => element == 'regional.show') == 'regional.show'
    let canCreateRegional   = authUser.can.find(element => element == 'regional.create') == 'regional.create'
    let canEditRegional     = authUser.can.find(element => element == 'regional.edit') == 'regional.edit'
    let canDeleteRegional   = authUser.can.find(element => element == 'regional.delete') == 'regional.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>
        <div slot="title">{$_('Regional.plural')}</div>

        <div slot="actions">
            {#if canCreateRegional || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('regional.create'))} variant="raised">
                    {$_('Create')} {$_('Regional.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Código</th>
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each regional.data as regional (regional.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {regional.name}
                        </p>
                    </td>

                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center">
                            {regional.code}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowRegional || canEditRegional ||canDeleteRegional || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('regional.edit', regional.id)))}>
                                    <Text>{$_('View details')}</Text>
                                </Item>
                            {:else}
                                <Item>
                                    <Text>{$_('You don\'t have permissions')}</Text>
                                </Item>
                            {/if}
                        </ResourceMenu>
                    </td>
                </tr>
            {/each}

            {#if regional.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={regional.links} />
</AuthenticatedLayout>
