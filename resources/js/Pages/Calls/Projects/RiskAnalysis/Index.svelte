<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'
    import Stepper from '@/Components/Stepper';
    import { Inertia } from '@inertiajs/inertia';

    export let call
    export let project
    export let riskAnalysis = []

    $title = $_('Risk analysis.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexRiskAnalysis    = authUser.can.find(element => element == 'risk-analysis.index') == 'risk-analysis.index'
    let canShowRiskAnalysis     = authUser.can.find(element => element == 'risk-analysis.show') == 'risk-analysis.show'
    let canCreateRiskAnalysis   = authUser.can.find(element => element == 'risk-analysis.create') == 'risk-analysis.create'
    let canEditRiskAnalysis     = authUser.can.find(element => element == 'risk-analysis.edit') == 'risk-analysis.edit'
    let canDeleteRiskAnalysis   = authUser.can.find(element => element == 'risk-analysis.delete') == 'risk-analysis.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <h1 class="font-bold text-3xl mt-24 text-center">{$_('Risk analysis.plural')}</h1>
    <h2 class="text-center mt-10 mb-24">
        Debe ingresar mínimo un análisis de riesgo por cada nivel (A nivel de objetivo general - A nivel de actividades - A nivel de productos).
    </h2>
    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateRiskAnalysis || isSuperAdmin}
            <Button on:click={() => Inertia.visit(route('calls.projects.risk-analysis.create', [call.id, project.id]))} variant="raised">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">análisis de riesgos</span>
                </div>
            </Button>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nivel</th>
                </tr>
            </thead>
            <tbody>
                {#each riskAnalysis.data as riskAnalysis (riskAnalysis.id)}
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

                        <td class="border-t">
                            {#if canEditRiskAnalysis || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.risk-analysis.edit', [call.id, project.id, riskAnalysis.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.level}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {riskAnalysis.level}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if riskAnalysis.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={riskAnalysis.links} />
</AuthenticatedLayout>

