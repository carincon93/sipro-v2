<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'

    import Stepper from '@/Components/Stepper'

    export let call
    export let project
    export let projectSennovaBudgets = []
    export let secondBudgetInfo

    $title = $_('Project sennova budgets.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectSennovaBudgets   = authUser.can.find(element => element == 'project-sennova-budgets.index') == 'project-sennova-budgets.index'
    let canShowProjectSennovaBudgets    = authUser.can.find(element => element == 'project-sennova-budgets.show') == 'project-sennova-budgets.show'
    let canCreateProjectSennovaBudgets  = authUser.can.find(element => element == 'project-sennova-budgets.create') == 'project-sennova-budgets.create'
    let canEditProjectSennovaBudgets    = authUser.can.find(element => element == 'project-sennova-budgets.edit') == 'project-sennova-budgets.edit'
    let canDeleteProjectSennovaBudgets  = authUser.can.find(element => element == 'project-sennova-budgets.delete') == 'project-sennova-budgets.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <h1 class="font-bold text-3xl mt-24 text-center">{$_('Project sennova budgets.plural')}</h1>
    <h2 class="text-center mt-10 mb-24">
        Ingrese cada uno de los rubros que requiere el proyecto. Actualmente el total del costo de los productos o servicios requeridos es: ${new Intl.NumberFormat('de-DE').format(project.totalProjectBudget)} COP
    </h2>
    <div class="px-4">
        <h1 class="mb-4 text-center">Filtros</h1>
        <ul class="flex flex-wrap">
            {#each secondBudgetInfo as {name}}
                <li class="mr-2 mb-2 inline-flex">
                    <a class="bg-indigo-100 hover:bg-indigo-200 px-2 py-1 rounded-3xl text-center text-indigo-400" use:inertia="{{ preserveScroll: true }}" href="?search={name}">{name}</a>
                </li>
            {/each}
            <li class="mr-2 mb-2 inline-flex">
                <a class="bg-green-100 hover:bg-green-200 px-2 py-1 rounded-3xl text-center text-green-400" use:inertia="{{ preserveScroll: true }}" href="?search=">Todos</a>
            </li>
        </ul>
    </div>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreateProjectSennovaBudgets || isSuperAdmin}
            <a use:inertia href={route('calls.projects.project-sennova-budgets.create', [call.id, project.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Project sennova budgets.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl">Información</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl">Subtotal del costo de los productos o servicios requeridos</th>
                </tr>
            </thead>
            <tbody>
                {#each projectSennovaBudgets.data as projectSennovaBudget (projectSennovaBudget.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditProjectSennovaBudgets || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.project-sennova-budgets.edit', [call.id, project.id, projectSennovaBudget.id])}
                                    class="px-6 py-4 block focus:text-indigo-500">
                                    <div class="mt-3">
                                        <small>Concepto interno SENA</small>
                                        <p>{projectSennovaBudget.call_budget?.sennova_budget?.second_budget_info.name}</p>
                                    </div>
                                    <div class="mt-3">
                                        <small>Rubro</small>
                                        <p>{projectSennovaBudget.call_budget?.sennova_budget?.third_budget_info.name}</p>
                                    </div>
                                    <div class="mt-3">
                                        <small>Uso presupuestal</small>
                                        <p>{projectSennovaBudget.call_budget?.sennova_budget?.budget_usage.description}</p>
                                    </div>
                                </a>
                            {:else}
                                <div class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    <div class="mt-3">
                                        <small>Concepto interno SENA</small>
                                        <p>{projectSennovaBudget.call_budget?.sennova_budget?.second_budget_info.name}</p>
                                    </div>
                                    <div class="mt-3">
                                        <small>Rubro</small>
                                        <p></p>{projectSennovaBudget.call_budget?.sennova_budget?.third_budget_info.name}
                                    </div>
                                    <div class="mt-3">
                                        <small>Uso presupuestal</small>
                                        <p>{projectSennovaBudget.call_budget?.sennova_budget?.budget_usage.description}</p>
                                    </div>
                                </div>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canEditProjectSennovaBudgets || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.projects.project-sennova-budgets.edit', [call.id, project.id, projectSennovaBudget.id])}
                                    class="px-6 py-4 block focus:text-indigo-500">
                                    <div class="mt-3">
                                        {#if projectSennovaBudget.average > 0} ${new Intl.NumberFormat('de-DE').format(projectSennovaBudget.average)} COP {:else if projectSennovaBudget.totalByBudgetWithoutMarketResearch > 0} ${new Intl.NumberFormat('de-DE').format(projectSennovaBudget.totalByBudgetWithoutMarketResearch)} {/if}
                                    </div>
                                    {#if !projectSennovaBudget.call_budget?.sennova_budget?.can_be_added}
                                        <span class="bg-red-200 p-2 rounded-3xl mt-4 inline-block text-xs">Este uso presupuestal NO suma al total del presupuesto</span>
                                    {/if}
                                </a>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if projectSennovaBudgets.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={projectSennovaBudgets.links} />
</AuthenticatedLayout>
