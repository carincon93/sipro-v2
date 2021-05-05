<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'

    export let knowledgeNetworks = []

    $title = $_('Knowledge networks.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexKnowledgeNetworks   = authUser.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'
    let canShowKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.show') == 'knowledge-networks.show'
    let canCreateKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.create') == 'knowledge-networks.create'
    let canEditKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.edit') == 'knowledge-networks.edit'
    let canDeleteKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.delete') == 'knowledge-networks.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Knowledge networks.plural')}</h1>
    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateKnowledgeNetworks || isSuperAdmin}
            <Button on:click={() => Inertia.visit(route('knowledge-networks.create'))} variant="raised">
               {$_('Create')} {$_('Knowledge networks.singular')}
            </Button>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                </tr>
            </thead>
            <tbody>
                {#each knowledgeNetworks.data as knowledgeNetwork (knowledgeNetwork.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditKnowledgeNetworks || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('knowledge-networks.edit', knowledgeNetwork.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {knowledgeNetwork.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {knowledgeNetwork.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if knowledgeNetworks.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={knowledgeNetworks.links} />
</AuthenticatedLayout>
