<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'
    import DataTable from '@/Components/DataTable'

    export let knowledgeNetworks = []

    $title = $_('Knowledge networks.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexKnowledgeNetworks   = authUser.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'
    let canShowKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.show') == 'knowledge-networks.show'
    let canCreateKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.create') == 'knowledge-networks.create'
    let canEditKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.edit') == 'knowledge-networks.edit'
    let canDeleteKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.delete') == 'knowledge-networks.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">
        <div slot="title">{$_('Knowledge networks.plural')}</div>

        <div slot="actions">
            {#if canCreateKnowledgeNetworks || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('knowledge-networks.create'))} variant="raised">
                    {$_('Create')} {$_('Knowledge networks.singular')}
                </Button>
            {/if}
        </div>

        <tr class="text-left font-bold" slot="thead">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Nombre</th>
        </tr>

        <tbody slot="tbody">
            {#each knowledgeNetworks.data as knowledgeNetwork (knowledgeNetwork.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {knowledgeNetwork.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowKnowledgeNetworks || canEditKnowledgeNetworks ||canDeleteKnowledgeNetworks || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('knowledge-networks.edit', knowledgeNetwork.id)))}>
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

            {#if knowledgeNetworks.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={knowledgeNetworks.links} />
</AuthenticatedLayout>
