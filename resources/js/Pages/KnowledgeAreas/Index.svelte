<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let knowledgeAreas = []

    $title = $_('Knowledge areas.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeAreas  = authUser.can.find(element => element == 'knowledge-areas.index') == 'knowledge-areas.index'
    let canShowKnowledgeAreas   = authUser.can.find(element => element == 'knowledge-areas.show') == 'knowledge-areas.show'
    let canCreateKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.create') == 'knowledge-areas.create'
    let canEditKnowledgeAreas   = authUser.can.find(element => element == 'knowledge-areas.edit') == 'knowledge-areas.edit'
    let canDeleteKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.delete') == 'knowledge-areas.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Knowledge areas.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateKnowledgeAreas || isSuperAdmin}
            <Link href={route('knowledge-areas.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Knowledge areas.singular')}</span>
                </div>
            </Link>
        {/if}
    </div>
    <div class="bg-white rounded shadow ">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                </tr>
            </thead>
            <tbody>
                {#each knowledgeAreas.data as knowledgeArea (knowledgeArea.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditKnowledgeAreas || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('knowledge-areas.edit', knowledgeArea.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {knowledgeArea.name}
                                </a>
                            {:else}
                                <p  class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {knowledgeArea.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if knowledgeAreas.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={knowledgeAreas.links} />
</AuthenticatedLayout>
