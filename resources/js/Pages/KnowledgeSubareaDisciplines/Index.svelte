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

    export let knowledgeSubareaDisciplines = []

    $title = $_('Knowledge subarea disciplines.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                         = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexKnowledgeSubareaDisciplines  = authUser.can.find(element => element == 'knowledge-subarea-disciplines.index') == 'knowledge-subarea-disciplines.index'
    let canShowKnowledgeSubareaDisciplines   = authUser.can.find(element => element == 'knowledge-subarea-disciplines.show') == 'knowledge-subarea-disciplines.show'
    let canCreateKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.create') == 'knowledge-subarea-disciplines.create'
    let canEditKnowledgeSubareaDisciplines   = authUser.can.find(element => element == 'knowledge-subarea-disciplines.edit') == 'knowledge-subarea-disciplines.edit'
    let canDeleteKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.delete') == 'knowledge-subarea-disciplines.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">
        <div slot="title">{$_('Knowledge subarea disciplines.plural')}</div>

        <div slot="actions">
            {#if canCreateKnowledgeSubareaDisciplines || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('knowledge-subarea-disciplines.create'))} variant="raised">
                    {$_('Create')} {$_('Knowledge subarea disciplines.singular')}
                </Button>
            {/if}
        </div>

        <tr class="text-left font-bold" slot="thead">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Subárea de conocimiento</th>
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Acciones</th>
        </tr>

        <tbody slot="tbody">
            {#each knowledgeSubareaDisciplines.data as knowledgeSubareaDiscipline (knowledgeSubareaDiscipline.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {knowledgeSubareaDiscipline.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {knowledgeSubareaDiscipline.knowledge_subarea?.name}
                        </p>
                    </td>
                    <td class="border-t td-actions">
                        <ResourceMenu>
                            {#if canShowKnowledgeSubareaDisciplines || canEditKnowledgeSubareaDisciplines ||canDeleteKnowledgeSubareaDisciplines || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('knowledge-subarea-disciplines.edit', knowledgeSubareaDiscipline.id)))}>
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

            {#if knowledgeSubareaDisciplines.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={knowledgeSubareaDisciplines.links} />
</AuthenticatedLayout>
