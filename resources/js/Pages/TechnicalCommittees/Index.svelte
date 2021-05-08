<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'
    import DataTable from '@/Components/DataTable'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'
    import { Inertia } from '@inertiajs/inertia'

    export let technicalCommittees = []

    $title = $_('Technical committees.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canIndexTechnicalCommittees =
        authUser.can.find(
            (element) => element == 'technical-committees.index',
        ) == 'technical-committees.index'
    let canShowTechnicalCommittees =
        authUser.can.find(
            (element) => element == 'technical-committees.show',
        ) == 'technical-committees.show'
    let canCreateTechnicalCommittees =
        authUser.can.find(
            (element) => element == 'technical-committees.create',
        ) == 'technical-committees.create'
    let canEditTechnicalCommittees =
        authUser.can.find(
            (element) => element == 'technical-committees.edit',
        ) == 'technical-committees.edit'
    let canDeleteTechnicalCommittees =
        authUser.can.find(
            (element) => element == 'technical-committees.delete',
        ) == 'technical-committees.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">
        <div slot="title">{$_('Technical committees.plural')}</div>

        <div slot="actions">
            {#if canCreateTechnicalCommittees || isSuperAdmin}
                <Button
                    on:click={() =>
                        Inertia.visit(route('technical-committees.create'))}
                    variant="raised"
                >
                    {$_('Create')}
                    {$_('Technical committees.singular')}
                </Button>
            {/if}
        </div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                    >Nombre</th
                >
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                    >Acciones</th
                >
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each technicalCommittees.data as technicalCommittee (technicalCommittee.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                        >
                            {technicalCommittee.name}
                        </p>
                    </td>
                    <td class="border-t td-actions">
                        <ResourceMenu>
                            {#if canShowTechnicalCommittees || canEditTechnicalCommittees || canDeleteTechnicalCommittees || isSuperAdmin}
                                <Item
                                    on:SMUI:action={() =>
                                        Inertia.visit(
                                            route(
                                                'technical-committees.edit',
                                                technicalCommittee.id,
                                            ),
                                        )}
                                >
                                    <Text>{$_('View details')}</Text>
                                </Item>
                            {:else}
                                <Item>
                                    <Text
                                        >{$_(
                                            "You don't have permissions",
                                        )}</Text
                                    >
                                </Item>
                            {/if}
                        </ResourceMenu>
                    </td>
                </tr>
            {/each}

            {#if technicalCommittees.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4"
                        >{$_('No data recorded')}</td
                    >
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={technicalCommittees.links} />
</AuthenticatedLayout>
