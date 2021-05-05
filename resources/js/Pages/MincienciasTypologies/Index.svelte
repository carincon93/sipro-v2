<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'

    export let mincienciasTypologies = []

    $title = $_('Minciencias typologies.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexMincienciasTypologies   = authUser.can.find(element => element == 'minciencias-typologies.index') == 'minciencias-typologies.index'
    let canShowMincienciasTypologies    = authUser.can.find(element => element == 'minciencias-typologies.show') == 'minciencias-typologies.show'
    let canCreateMincienciasTypologies  = authUser.can.find(element => element == 'minciencias-typologies.create') == 'minciencias-typologies.create'
    let canEditMincienciasTypologies    = authUser.can.find(element => element == 'minciencias-typologies.edit') == 'minciencias-typologies.edit'
    let canDeleteMincienciasTypologies  = authUser.can.find(element => element == 'minciencias-typologies.delete') == 'minciencias-typologies.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Minciencias typologies.plural')}</h1>
    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateMincienciasTypologies || isSuperAdmin}
            <Button on:click={() => Inertia.visit(route('minciencias-typologies.create'))} variant="raised">
               {$_('Create')} {$_('Minciencias typologies.singular')}
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
                {#each mincienciasTypologies.data as mincienciasTypology (mincienciasTypology.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditMincienciasTypologies || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('minciencias-typologies.edit', mincienciasTypology.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {mincienciasTypology.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {mincienciasTypology.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if mincienciasTypologies.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={mincienciasTypologies.links} />
</AuthenticatedLayout>
