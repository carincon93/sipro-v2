<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'
    import Stepper from '@/Components/Stepper.svelte';

    export let call
    export let project
    export let riskAnalysis = []

    $title = $_('Risk analysis.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRiskAnalysis    = authUser.can.find(element => element == 'risk-analysis.index') == 'risk-analysis.index'
    let canShowRiskAnalysis     = authUser.can.find(element => element == 'risk-analysis.show') == 'risk-analysis.show'
    let canCreateRiskAnalysis   = authUser.can.find(element => element == 'risk-analysis.create') == 'risk-analysis.create'
    let canEditRiskAnalysis     = authUser.can.find(element => element == 'risk-analysis.edit') == 'risk-analysis.edit'
    let canDeleteRiskAnalysis   = authUser.can.find(element => element == 'risk-analysis.delete') == 'risk-analysis.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <h1 class="mb-8 font-bold text-3xl">{$_('Risk analysis.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateRiskAnalysis || isSuperAdmin}
            <Link href={route('calls.projects.risk-analysis.create', [call.id, project.id, riskAnalysis.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">análisis de riesgos</span>
                </div>
            </Link>
        {/if}
    </div>
    <h1 class="mb-8 font-bold text-3xl text-center mt-52 mb-28">A nivel del objetivo general</h1>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Nombre</th>
            </tr>
            {#each riskAnalysis.data as riskAnalysis (riskAnalysis.id)}
                {#if riskAnalysis.level == 'A nivel del objetivo general'}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditRiskAnalysis || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.risk-analysis.edit', [call.id, project.id, riskAnalysis.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.description}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.description}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/if}
            {/each}

            {#if riskAnalysis.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </table>
    </div>
    <Pagination links={riskAnalysis.links} />

    <h1 class="mb-8 font-bold text-3xl text-center mt-52 mb-28">A nivel de productos</h1>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Nombre</th>
            </tr>
            {#each riskAnalysis.data as riskAnalysis (riskAnalysis.id)}
                {#if riskAnalysis.level == 'A nivel de productos'}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditRiskAnalysis || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.risk-analysis.edit', [call.id, project.id, riskAnalysis.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.description}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.description}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/if}
            {/each}

            {#if riskAnalysis.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </table>
    </div>
    <Pagination links={riskAnalysis.links} />

    <h1 class="mb-8 font-bold text-3xl text-center mt-52 mb-28">A nivel de actividades</h1>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Nombre</th>
            </tr>
            {#each riskAnalysis.data as riskAnalysis (riskAnalysis.id)}
                {#if riskAnalysis.level == 'A nivel de actividades'}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditRiskAnalysis || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.risk-analysis.edit', [call.id, project.id, riskAnalysis.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.description}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.description}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/if}
            {/each}

            {#if riskAnalysis.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                </tr>
            {/if}
        </table>
    </div>
    <Pagination links={riskAnalysis.links} />
</AuthenticatedLayout>

