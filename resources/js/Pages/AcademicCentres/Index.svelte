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

    export let academicCentres = []

    $title = $_('Academic centres.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAcademicCentres     = authUser.can.find(element => element == 'academic-centres.index') == 'academic-centres.index'
    let canShowAcademicCentres      = authUser.can.find(element => element == 'academic-centres.show') == 'academic-centres.show'
    let canCreateAcademicCentres    = authUser.can.find(element => element == 'academic-centres.create') == 'academic-centres.create'
    let canEditAcademicCentres      = authUser.can.find(element => element == 'academic-centres.edit') == 'academic-centres.edit'
    let canDeleteAcademicCentres    = authUser.can.find(element => element == 'academic-centres.delete') == 'academic-centres.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>
        <div slot="title">{$_('Academic centres.plural')}</div>

        <div slot="actions">
            {#if canCreateAcademicCentres || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('academic-centres.create'))} variant="raised">
                    {$_('Create')} {$_('Academic centres.singular')}
                </Button>
            {/if}
        </div>

        <tr class="text-left font-bold" slot="thead">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Código</th>
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Regional</th>
        </tr>

        <tbody slot="tbody">
            {#each academicCentres.data as academicCentre (academicCentre.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {academicCentre.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center">
                            {academicCentre.code}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center">
                            {academicCentre.regional?.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canEditAcademicCentres || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('academic-centres.edit', academicCentre.id)))}>
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

            {#if academicCentres.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>

    <Pagination links={academicCentres.links} />
</AuthenticatedLayout>
