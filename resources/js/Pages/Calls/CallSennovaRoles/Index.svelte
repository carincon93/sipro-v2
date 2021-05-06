<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia';

    import Pagination from '@/Components/Pagination'
    import DataTable from '@/Components/DataTable'
    import Button from '@/Components/Button'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'

    export let call
    export let callSennovaRoles = []

    $title = $_('Call sennova roles.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin              = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexCallSennovaRoles  = authUser.can.find(element => element == 'call-sennova-roles.index') == 'call-sennova-roles.index'
    let canShowCallSennovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.show') == 'call-sennova-roles.show'
    let canCreateCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.create') == 'call-sennova-roles.create'
    let canEditCallSennovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.edit') == 'call-sennova-roles.edit'
    let canDeleteCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.delete') == 'call-sennova-roles.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable>
        <div slot="title">{$_('Call sennova roles.plural')}</div>

        <div slot="actions">
            {#if canCreateCallSennovaRoles || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('calls.call-sennova-roles.create', call.id))} variant="raised">
                    {$_('Create')} {$_('Call sennova roles.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Asignación mensual</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Máximo de meses</th>
            </tr>
        </thead>

        <tbody slot="tbody">
            {#each callSennovaRoles.data as callSennovaRole (callSennovaRole.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p  class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {callSennovaRole.name}
                        </p>
                    </td>

                    <td class="border-t">
                        <p  class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {callSennovaRole.salary}
                        </p>
                    </td>

                    <td class="border-t">
                        <p  class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {callSennovaRole.qty_months ? callSennovaRole.qty_months : ''}
                        </p>
                    </td>

                    <td class="border-t">
                        <ResourceMenu>
                            {#if canEditCallSennovaRoles || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('calls.call-sennova-roles.edit', [call.id, callSennovaRole.id])))}>
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

            {#if callSennovaRoles.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={callSennovaRoles.links} />
</AuthenticatedLayout>
