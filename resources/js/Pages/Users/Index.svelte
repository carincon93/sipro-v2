<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let users = []

    $title = $_('Users.plural')

    // Permisos
    let authUser        = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexUsers   = authUser.can.find(element => element == 'users.index') == 'users.index'
    let canShowUsers    = authUser.can.find(element => element == 'users.show') == 'users.show'
    let canCreateUsers  = authUser.can.find(element => element == 'users.create') == 'users.create'
    let canEditUsers    = authUser.can.find(element => element == 'users.edit') == 'users.edit'
    let canDeleteUsers  = authUser.can.find(element => element == 'users.delete') == 'users.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Users.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateUsers || isSuperAdmin}
            <Link href={route('users.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Users.singular')}</span>
                </div>
            </Link>
        {/if}
    </div>
    <div class="bg-white rounded shadow ">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Correo electrónico</th>
                </tr>
            </thead>
            <tbody>
                {#each users.data as user (user.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditUsers || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('users.edit', user.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {user.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {user.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditUsers || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('users.edit', user.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {user.email}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {user.email}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if users.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={users.links} />
</AuthenticatedLayout>
