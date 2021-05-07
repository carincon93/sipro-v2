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

    export let programmaticLines = []

    $title = $_('Programmatic lines.plural')

    /**
     * Permisos
     */
    let authUser    = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexProgrammaticLines   = authUser.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'
    let canShowProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.show') == 'programmatic-lines.show'
    let canCreateProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.create') == 'programmatic-lines.create'
    let canEditProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.edit') == 'programmatic-lines.edit'
    let canDeleteProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.delete') == 'programmatic-lines.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">

        <div slot="title">{$_('Programmatic lines.plural')}</div>

        <div slot="actions">
            {#if canCreateProgrammaticLines || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('programmatic-lines.create'))} variant="raised">
                {$_('Create')} {$_('Programmatic lines.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Código</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Categoría</th>
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each programmaticLines.data as programmaticLine (programmaticLine.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {programmaticLine.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center">
                            {programmaticLine.code}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center">
                            {programmaticLine.project_category}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowProgrammaticLines || canEditProgrammaticLines ||canDeleteProgrammaticLines || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('programmatic-lines.edit', programmaticLine.id)))}>
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

            {#if programmaticLines.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={programmaticLines.links} />
</AuthenticatedLayout>
