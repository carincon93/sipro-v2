<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let prioritizedTopics = []

    $title = $_('Prioritized topics.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexPrioritizedTopics   = authUser.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'
    let canShowPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.show') == 'prioritized-topics.show'
    let canCreatePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.create') == 'prioritized-topics.create'
    let canEditPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.edit') == 'prioritized-topics.edit'
    let canDeletePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.delete') == 'prioritized-topics.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Prioritized topics.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreatePrioritizedTopics || isSuperAdmin}
            <Link href={route('prioritized-topics.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Prioritized topics.singular')}</span>
                </div>
            </Link>
        {/if}
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Nombre</th>
                <th class="px-6 pt-6 pb-4">Sector productivo</th>
                <th class="px-6 pt-6 pb-4">Mesa técnica de servicios tecnológicos</th>
            </tr>
            {#each prioritizedTopics.data as prioritizedTopic (prioritizedTopic.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        {#if canEditPrioritizedTopics || isSuperAdmin}
                            <a
                                use:inertia
                                href={route('prioritized-topics.edit', prioritizedTopic.id)}
                                class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {prioritizedTopic.name}
                            </a>
                        {:else}
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {prioritizedTopic.name}
                            </p>
                        {/if}
                    </td>
                    <td class="border-t">
                        {#if canEditPrioritizedTopics || isSuperAdmin}
                            <a
                                use:inertia
                                href={route('prioritized-topics.edit', prioritizedTopic.id)}
                                class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {prioritizedTopic.productive_sector?.name}
                            </a>
                        {:else}
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {prioritizedTopic.productive_sector?.name}
                            </p>
                        {/if}
                    </td>
                    <td class="border-t">
                        {#if canEditPrioritizedTopics || isSuperAdmin}
                            <a
                                use:inertia
                                href={route('prioritized-topics.edit', prioritizedTopic.id)}
                                class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {prioritizedTopic.technical_committee?.name}
                            </a>
                        {:else}
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {prioritizedTopic.technical_committee?.name}
                            </p>
                        {/if}
                    </td>
                </tr>
            {/each}

            {#if prioritizedTopics.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </table>
    </div>
    <Pagination links={prioritizedTopics.links} />
</AuthenticatedLayout>
