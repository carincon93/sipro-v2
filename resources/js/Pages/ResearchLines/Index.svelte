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

    export let researchLines = []

    $title = $_('Research lines.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexResearchLines   = authUser.can.find(element => element == 'research-lines.index') == 'research-lines.index'
    let canShowResearchLines    = authUser.can.find(element => element == 'research-lines.show') == 'research-lines.show'
    let canCreateResearchLines  = authUser.can.find(element => element == 'research-lines.create') == 'research-lines.create'
    let canEditResearchLines    = authUser.can.find(element => element == 'research-lines.edit') == 'research-lines.edit'
    let canDeleteResearchLines  = authUser.can.find(element => element == 'research-lines.delete') == 'research-lines.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>
        <div slot="title">{$_('Research lines.plural')}</div>

        <div slot="actions">
            {#if canCreateResearchLines || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('research-lines.create'))} variant="raised">
                    {$_('Create')} {$_('Research lines.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Centro de formación</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Regional</th>
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each researchLines.data as researchLine (researchLine.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {researchLine.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {researchLine.research_group?.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {researchLine.research_group?.academic_centre?.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowResearchLines || canEditResearchLines ||canDeleteResearchLines || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('research-lines.edit', researchLine.id)))}>
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

            {#if researchLines.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={researchLines.links} />
</AuthenticatedLayout>
