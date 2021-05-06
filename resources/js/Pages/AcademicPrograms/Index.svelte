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

    export let academicPrograms = []

    $title = $_('Academic programs.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAcademicPrograms    = authUser.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'
    let canShowAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.show') == 'academic-programs.show'
    let canCreateAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.create') == 'academic-programs.create'
    let canEditAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.edit') == 'academic-programs.edit'
    let canDeleteAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.delete') == 'academic-programs.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>
        <div slot="title">{$_('Academic programs.plural')}</div>

        <div slot="actions">
            {#if canCreateAcademicPrograms || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('academic-programs.create'))} variant="raised">
                {$_('Create')} {$_('Academic programs.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Código</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Centro de formación</th>
            </tr>
        </thead>

        <tbody slot="tbody">
            {#each academicPrograms.data as academicProgram (academicProgram.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {academicProgram.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center">
                            {academicProgram.code}
                        </p>
                    </td>
                    <td class="border-t">

                            <p class="px-6 py-4 flex items-center">
                                {academicProgram.academic_centre?.name}
                            </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowAcademicPrograms || canEditAcademicPrograms || canDeleteAcademicPrograms || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('academic-programs.edit', academicProgram.id)))}>
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

            {#if academicPrograms.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={academicPrograms.links} />
</AuthenticatedLayout>

