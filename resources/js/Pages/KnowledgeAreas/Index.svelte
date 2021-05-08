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

    export let knowledgeAreas = []

    $title = $_('Knowledge areas.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexKnowledgeAreas  = authUser.can.find(element => element == 'knowledge-areas.index') == 'knowledge-areas.index'
    let canShowKnowledgeAreas   = authUser.can.find(element => element == 'knowledge-areas.show') == 'knowledge-areas.show'
    let canCreateKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.create') == 'knowledge-areas.create'
    let canEditKnowledgeAreas   = authUser.can.find(element => element == 'knowledge-areas.edit') == 'knowledge-areas.edit'
    let canDeleteKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.delete') == 'knowledge-areas.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">
        <div slot="title">{$_('Knowledge areas.plural')}</div>

        <div slot="actions">
            {#if canCreateKnowledgeAreas || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('knowledge-areas.create'))} variant="raised">
                    {$_('Create')} {$_('Knowledge areas.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Acciones</th>
            </tr>
        </thead>

        <tbody slot="tbody">
            {#each knowledgeAreas.data as knowledgeArea (knowledgeArea.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {knowledgeArea.name}
                        </p>
                    </td>
                    <td class="border-t td-actions">
                        <ResourceMenu>
                            {#if canShowKnowledgeAreas || canEditKnowledgeAreas || canDeleteKnowledgeAreas || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('knowledge-areas.edit', knowledgeArea.id)))}>
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

            {#if knowledgeAreas.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={knowledgeAreas.links} />
</AuthenticatedLayout>
