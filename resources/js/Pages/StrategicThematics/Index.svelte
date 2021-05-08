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

    export let strategicThematics = []

    $title = $_('Strategic thematics.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canIndexStrategicThematics =
        authUser.can.find(
            (element) => element == 'strategic-thematics.index',
        ) == 'strategic-thematics.index'
    let canShowStrategicThematics =
        authUser.can.find((element) => element == 'strategic-thematics.show') ==
        'strategic-thematics.show'
    let canCreateStrategicThematics =
        authUser.can.find(
            (element) => element == 'strategic-thematics.create',
        ) == 'strategic-thematics.create'
    let canEditStrategicThematics =
        authUser.can.find((element) => element == 'strategic-thematics.edit') ==
        'strategic-thematics.edit'
    let canDeleteStrategicThematics =
        authUser.can.find(
            (element) => element == 'strategic-thematics.delete',
        ) == 'strategic-thematics.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <DataTable class="mt-20">
        <div slot="title">{$_('Strategic thematics.plural')}</div>

        <div slot="actions">
            {#if canCreateStrategicThematics || isSuperAdmin}
                <Button
                    on:click={() =>
                        Inertia.visit(route('strategic-thematics.create'))}
                    variant="raised"
                >
                    {$_('Create')}
                    {$_('Strategic thematics.singular')}
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
            {#each strategicThematics.data as strategicThematic (strategicThematic.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p
                            class="px-6 py-4 flex items-center focus:text-indigo-500"
                        >
                            {strategicThematic.name}
                        </p>
                    </td>
                    <td class="border-t td-actions">
                        <ResourceMenu>
                            {#if canShowStrategicThematics || canEditStrategicThematics || canDeleteStrategicThematics || isSuperAdmin}
                                <Item
                                    on:SMUI:action={() =>
                                        Inertia.visit(
                                            route(
                                                'strategic-thematics.edit',
                                                strategicThematic.id,
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

            {#if strategicThematics.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4"
                        >{$_('No data recorded')}</td
                    >
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={strategicThematics.links} />
</AuthenticatedLayout>
