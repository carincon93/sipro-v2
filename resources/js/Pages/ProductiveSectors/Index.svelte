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

    export let productiveSectors = []

    $title = $_('Productive sectors.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexProductiveSectors   = authUser.can.find(element => element == 'productive-sectors.index') == 'productive-sectors.index'
    let canShowProductiveSectors    = authUser.can.find(element => element == 'productive-sectors.show') == 'productive-sectors.show'
    let canCreateProductiveSectors  = authUser.can.find(element => element == 'productive-sectors.create') == 'productive-sectors.create'
    let canEditProductiveSectors    = authUser.can.find(element => element == 'productive-sectors.edit') == 'productive-sectors.edit'
    let canDeleteProductiveSectors  = authUser.can.find(element => element == 'productive-sectors.delete') == 'productive-sectors.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>

        <div slot="title">{$_('Productive sectors.plural')}</div>

        <div slot="actions">
            {#if canCreateProductiveSectors || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('productive-sectors.create'))} variant="raised">
                    {$_('Create')} {$_('Productive sectors.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Nombre</th>
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each productiveSectors.data as productiveSector (productiveSector.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p
                            class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {productiveSector.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowProductiveSectors || canEditProductiveSectors ||canDeleteProductiveSectors || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('productive-sectors.edit', productiveSector.id)))}>
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

            {#if productiveSectors.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={productiveSectors.links} />
</AuthenticatedLayout>
