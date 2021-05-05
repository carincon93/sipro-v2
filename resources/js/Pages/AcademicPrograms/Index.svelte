<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'


    export let academicPrograms = []

    $title = $_('Academic programs.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAcademicPrograms    = authUser.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'
    let canShowAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.show') == 'academic-programs.show'
    let canCreateAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.create') == 'academic-programs.create'
    let canEditAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.edit') == 'academic-programs.edit'
    let canDeleteAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.delete') == 'academic-programs.delete'

    let filters = {}
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">{$_('Academic programs.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateAcademicPrograms || isSuperAdmin}
            <a use:inertia href={route('academic-programs.create')} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Academic programs.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Código</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Centro de formación</th>
                </tr>
            </thead>
            <tbody>
                {#each academicPrograms.data as academicProgram (academicProgram.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditAcademicPrograms || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('academic-programs.edit', academicProgram.id)}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {academicProgram.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {academicProgram.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditAcademicPrograms || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('academic-programs.edit', academicProgram.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {academicProgram.code}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {academicProgram.code}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditAcademicPrograms || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('academic-programs.edit', academicProgram.id)}
                                    class="px-6 py-4 flex items-center"
                                    tabindex="-1">
                                    {academicProgram.academic_centre?.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center">
                                    {academicProgram.academic_centre?.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if academicPrograms.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={academicPrograms.links} />
</AuthenticatedLayout>

