<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let academicCentres = []

    $title = $_('Academic centres.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexAcademicCentres     = authUser.can.find(element => element == 'academic-centres.index') == 'academic-centres.index'
    let canShowAcademicCentres      = authUser.can.find(element => element == 'academic-centres.show') == 'academic-centres.show'
    let canCreateAcademicCentres    = authUser.can.find(element => element == 'academic-centres.create') == 'academic-centres.create'
    let canEditAcademicCentres      = authUser.can.find(element => element == 'academic-centres.edit') == 'academic-centres.edit'
    let canDeleteAcademicCentres    = authUser.can.find(element => element == 'academic-centres.delete') == 'academic-centres.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Academic centres.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateAcademicCentres || isSuperAdmin}
            <a use:inertia href={route('academic-centres.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Academic centres.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Código</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Regional</th>
                </tr>
            </thead>
            <tbody>
                {#each academicCentres.data as academicCentre (academicCentre.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditAcademicCentres || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('academic-centres.edit', academicCentre.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {academicCentre.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {academicCentre.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditAcademicCentres || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('academic-centres.edit', academicCentre.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {academicCentre.code}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {academicCentre.code}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditAcademicCentres || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('academic-centres.edit', academicCentre.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {academicCentre.regional?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {academicCentre.regional?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if academicCentres.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={academicCentres.links} />
</AuthenticatedLayout>
