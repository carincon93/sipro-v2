<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { inertia } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'

    export let users = []

    $title = 'Usuarios'

    let filters = {}
</script>

<h1 class="mb-8 font-bold text-3xl">{$_("Users")}</h1>
<div class="mb-6 flex justify-between items-center">
    <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
    <Link href={route('users.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
        <div>
            <span>Crear</span>
            <span class="hidden md:inline">usuario</span>
        </div>
    </Link>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4">Nombre</th>
            <th class="px-6 pt-6 pb-4">Correo electrónico</th>
        </tr>
        {#each users.data as user (user.id)}
        <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
                <a
                    use:inertia
                    href={route('users.edit', user.id)}
                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                    {user.name}
                </a>
            </td>
            <td class="border-t">
                <a
                    use:inertia
                    href={route('users.edit', user.id)}
                    class="px-6 py-4 flex items-center"
                    tabindex="-1">
                    {user.email}
                </a>
            </td>
        </tr>
        {/each}

        {#if users.data.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4">{$_("No data recorded")}</td>
            </tr>
        {/if}
    </table>
</div>
<Pagination links={users.links} />
