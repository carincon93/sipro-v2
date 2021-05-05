<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import ResourceMenu from '@/Components/ResourceMenu'
    import Button from '@/Components/Button'
    import { Item, Text } from '@smui/list'
    import { Inertia } from '@inertiajs/inertia'

    export let rdi
    export let call

    $title = $_('RDI.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexRDI     = authUser.can.find(element => element == 'rdi.index') == 'rdi.index'
    let canCreateRDI    = authUser.can.find(element => element == 'rdi.create') == 'rdi.create'
    let canShowRDI      = authUser.can.find(element => element == 'rdi.show') == 'rdi.show'
    let canEditRDI      = authUser.can.find(element => element == 'rdi.edit') == 'rdi.edit'
    let canDeleteRDI    = authUser.can.find(element => element == 'rdi.delete') == 'rdi.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('RDI.plural')}</h1>

    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        <div>
            {#if canCreateRDI || isSuperAdmin}
                <Button on:click={() => Inertia.visit(route('calls.rdi.create', [call.id]))}>
                    <div>
                        <span>{$_('Create')}</span>
                        <span class="hidden md:inline">proyecto {$_('RDI.singular')}</span>
                    </div>
                </Button>
            {/if}
        </div>
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Título</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Fecha de ejecución</th>
                </tr>
            </thead>
            <tbody>
                {#each rdi.data as rdi (rdi.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {rdi.title}
                            </p>
                        </td>
                        <td class="border-t">
                            <p class="px-6 py-4 flex items-center">
                                {rdi.execution_date}
                            </p>
                        </td>
                        <td class="border-t">
                            <ResourceMenu>
                                {#if canShowRDI || canEditRDI ||canDeleteRDI || isSuperAdmin}
                                    <Item on:SMUI:action={() => (Inertia.visit(route('calls.rdi.edit', [call.id, rdi.id])))}>
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

                {#if rdi.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={rdi.links} />
</AuthenticatedLayout>
