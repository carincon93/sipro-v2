<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let sennovaRoles = []

    $title = $_('Sennova roles.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexSennovaRoles  = authUser.can.find(element => element == 'sennova-roles.index') == 'sennova-roles.index'
    let canShowSennovaRoles   = authUser.can.find(element => element == 'sennova-roles.show') == 'sennova-roles.show'
    let canCreateSennovaRoles = authUser.can.find(element => element == 'sennova-roles.create') == 'sennova-roles.create'
    let canEditSennovaRoles   = authUser.can.find(element => element == 'sennova-roles.edit') == 'sennova-roles.edit'
    let canDeleteSennovaRoles = authUser.can.find(element => element == 'sennova-roles.delete') == 'sennova-roles.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Sennova roles.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateSennovaRoles || isSuperAdmin}
            <a use:inertia href={route('sennova-roles.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Sennova roles.singular')}</span>
                </div>
            </a>
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
                {#each sennovaRoles.data as sennovaRole (sennovaRole.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditSennovaRoles || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('sennova-roles.edit', sennovaRole.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {sennovaRole.name}
                                </a>
                            {:else}
                                <p  class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {sennovaRole.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if sennovaRoles.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={sennovaRoles.links} />
</AuthenticatedLayout>
