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
    import Stepper from '@/Components/Stepper'

    export let call
    export let rdi
    export let partnerOrganizations = []

    $title = $_('Partner organizations.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexPartnerOrganizations    = authUser.can.find(element => element == 'partner-organizations.index') == 'partner-organizations.index'
    let canShowPartnerOrganizations     = authUser.can.find(element => element == 'partner-organizations.show') == 'partner-organizations.show'
    let canCreatePartnerOrganizations   = authUser.can.find(element => element == 'partner-organizations.create') == 'partner-organizations.create'
    let canEditPartnerOrganizations     = authUser.can.find(element => element == 'partner-organizations.edit') == 'partner-organizations.edit'
    let canDeletePartnerOrganizations   = authUser.can.find(element => element == 'partner-organizations.delete') == 'partner-organizations.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} project={rdi} />

    <DataTable>
        <div slot="title">{$_('Partner organizations.plural')}</div>

        <div slot="actions">
            {#if canCreatePartnerOrganizations || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('calls.rdi.partner-organizations.create', [call.id, rdi.id]))} variant="raised">
                    {$_('Create')} {$_('Partner organizations.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Nombre</th>
            </tr>
        </thead>

        <tbody slot="tbody">
            {#each partnerOrganizations.data as partnerOrganization (partnerOrganization.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {partnerOrganization.name}
                        </p>
                    </td>
                    <td class="border-t">
                        <ResourceMenu>
                            {#if canShowPartnerOrganizations || canEditPartnerOrganizations ||canDeletePartnerOrganizations || isSuperAdmin}
                                <Item on:SMUI:action={() => (Inertia.visit(route('calls.rdi.partner-organizations.edit', [call.id, rdi.id, partnerOrganization.id])))}>
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

            {#if partnerOrganizations.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={partnerOrganizations.links} />
</AuthenticatedLayout>
