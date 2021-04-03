<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let knowledgeSubareas = []

    $title = $_('Knowledge subareas.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeSubareas   = authUser.can.find(element => element == 'knowledge-subareas.index') == 'knowledge-subareas.index'
    let canShowKnowledgeSubareas    = authUser.can.find(element => element == 'knowledge-subareas.show') == 'knowledge-subareas.show'
    let canCreateKnowledgeSubareas  = authUser.can.find(element => element == 'knowledge-subareas.create') == 'knowledge-subareas.create'
    let canEditKnowledgeSubareas    = authUser.can.find(element => element == 'knowledge-subareas.edit') == 'knowledge-subareas.edit'
    let canDeleteKnowledgeSubareas  = authUser.can.find(element => element == 'knowledge-subareas.delete') == 'knowledge-subareas.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Knowledge subareas.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateKnowledgeSubareas || isSuperAdmin}
            <Link href={route('knowledge-subareas.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Knowledge subareas.singular')}</span>
                </div>
            </Link>
        {/if}
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Nombre</th>
                <th class="px-6 pt-6 pb-4">Área de conocimiento</th>
            </tr>
            {#each knowledgeSubareas.data as knowledgeSubarea (knowledgeSubarea.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        {#if canEditKnowledgeSubareas || isSuperAdmin}
                            <a
                                use:inertia
                                href={route('knowledge-subareas.edit', knowledgeSubarea.id)}
                                class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {knowledgeSubarea.name}
                            </a>
                        {:else}
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {knowledgeSubarea.name}
                            </p>
                        {/if}
                    </td>
                    <td class="border-t">
                        {#if canEditKnowledgeSubareas || isSuperAdmin}
                            <a
                                use:inertia
                                href={route('knowledge-subareas.edit', knowledgeSubarea.id)}
                                class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {knowledgeSubarea.knowledge_area?.name}
                            </a>
                        {:else}
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {knowledgeSubarea.knowledge_area?.name}
                            </p>
                        {/if}
                    </td>
                </tr>
            {/each}

            {#if knowledgeSubareas.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </table>
    </div>
    <Pagination links={knowledgeSubareas.links} />
</AuthenticatedLayout>
