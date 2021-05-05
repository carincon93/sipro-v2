<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'
    import DataTable from '@/Components/DataTable'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'

    export let annexes = []

    $title = $_('Annexes.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAnnexes     = authUser.can.find(element => element == 'annexes.index') == 'annexes.index'
    let canShowAnnexes      = authUser.can.find(element => element == 'annexes.show') == 'annexes.show'
    let canCreateAnnexes    = authUser.can.find(element => element == 'annexes.create') == 'annexes.create'
    let canEditAnnexes      = authUser.can.find(element => element == 'annexes.edit') == 'annexes.edit'
    let canDeleteAnnexes    = authUser.can.find(element => element == 'annexes.delete') == 'annexes.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>
        <div slot="title">{$_('Academic centres.plural')}</div>

        <div slot="actions">
            {#if canCreateAnnexes || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('annexes.create'))} variant="raised">
                    {$_('Create')} {$_('Annexes.singular')}
                </Button>
            {/if}
        </div>

        <tr class="text-left font-bold" slot="thead">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Nombre</th>
        </tr>

        <tbody slot="tbody">
            {#each annexes.data as annexe (annexe.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {annexe.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canEditAnnexes || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('annexes.edit', annexe.id)))}>
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

            {#if annexes.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
                {/if}
        </tbody>
    </DataTable>

    <Pagination links={annexes.links} />
</AuthenticatedLayout>
