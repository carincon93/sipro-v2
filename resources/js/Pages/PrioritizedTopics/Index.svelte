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

    export let prioritizedTopics = []

    $title = $_('Prioritized topics.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexPrioritizedTopics   = authUser.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'
    let canShowPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.show') == 'prioritized-topics.show'
    let canCreatePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.create') == 'prioritized-topics.create'
    let canEditPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.edit') == 'prioritized-topics.edit'
    let canDeletePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.delete') == 'prioritized-topics.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">
        <div slot="title">{$_('Prioritized topics.plural')}</div>

        <div slot="actions">
            {#if canCreatePrioritizedTopics || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('prioritized-topics.create'))} variant="raised">
                    {$_('Create')} {$_('Prioritized topics.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Sector productivo</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Mesa técnica de servicios tecnológicos</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Acciones</th>
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each prioritizedTopics.data as prioritizedTopic (prioritizedTopic.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {prioritizedTopic.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {prioritizedTopic.productive_sector?.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {prioritizedTopic.technical_committee?.name}
                        </p>
                    </td>
                    <td class="border-t td-actions">
                        <ResourceMenu>
                            {#if canShowPrioritizedTopics || canEditPrioritizedTopics ||canDeletePrioritizedTopics || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('prioritized-topics.edit', prioritizedTopic.id)))}>
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

            {#if prioritizedTopics.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={prioritizedTopics.links} />
</AuthenticatedLayout>
