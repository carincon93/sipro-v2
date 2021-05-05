<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'

    export let researchGroups = []

    $title = $_('Research groups.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexResearchGroups  = authUser.can.find(element => element == 'research-groups.index') == 'research-groups.index'
    let canShowResearchGroups   = authUser.can.find(element => element == 'research-groups.show') == 'research-groups.show'
    let canCreateResearchGroups = authUser.can.find(element => element == 'research-groups.create') == 'research-groups.create'
    let canEditResearchGroups   = authUser.can.find(element => element == 'research-groups.edit') == 'research-groups.edit'
    let canDeleteResearchGroups = authUser.can.find(element => element == 'research-groups.delete') == 'research-groups.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Research groups.plural')}</h1>
    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateResearchGroups || isSuperAdmin}
            <Button on:click={() => Inertia.visit(route('research-groups.create'))} variant="raised">
               {$_('Create')} {$_('Research groups.singular')}
            </Button>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Centro de formación</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Regional</th>
                </tr>
            </thead>
            <tbody>
                {#each researchGroups.data as researchGroup (researchGroup.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditResearchGroups || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-groups.edit', researchGroup.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchGroup.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchGroup.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditResearchGroups || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-groups.edit', researchGroup.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchGroup.academic_centre?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchGroup.academic_centre?.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditResearchGroups || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('research-groups.edit', researchGroup.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchGroup.academic_centre?.regional?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {researchGroup.academic_centre?.regional?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if researchGroups.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={researchGroups.links} />
</AuthenticatedLayout>
