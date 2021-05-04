<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import ResourceMenu from '@/Components/ResourceMenu'
    import Button from '@/Components/Button'
    import { Item, Text } from '@smui/list'
    import { Inertia } from '@inertiajs/inertia'
    import Stepper from '@/Components/Stepper'

    export let call
    export let project
    export let projectSennovaBudgets = []
    export let secondBudgetInfo

    $title = $_('Project sennova budgets.plural')

    /**
     * Permisos
     */
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
        Ingrese cada uno de los rubros que requiere el proyecto. Actualmente el total del costo de los productos o servicios requeridos es: ${new Intl.NumberFormat('de-DE').format(!isNaN(project.total_project_budget) ? project.total_project_budget : 0)} COP
    </h2>

    <table class="w-full whitespace-no-wrap">
        <thead>
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Concepto SENA</th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Regla</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    Servicios especiales de construcción
                </td>
                <td class="border-t">
                    El valor no debe superar el 5% (${new Intl.NumberFormat('de-DE').format(!isNaN(project.total_industrial_machinery) ? (project.total_industrial_machinery * 0.05) : 0)}) del rubro de "MAQUINARIA INDUSTRIAL" (${new Intl.NumberFormat('de-DE').format(!isNaN(project.total_industrial_machinery) ? project.total_industrial_machinery : 0)}).
                </td>
            </tr>

            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    Viáticos
                </td>
                <td class="border-t">
                    La sumatoria de todos los rubros de viáticos (${new Intl.NumberFormat('de-DE').format(!isNaN(project.total_viatics) ? project.total_viatics : 0)}) no debe superar el valor de $4.000.000
                </td>
            </tr>

            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    Mantenimiento de maquinaria, equipo, transporte y sofware
                </td>
                <td class="border-t">
                    El valor no debe superar el 5% (${new Intl.NumberFormat('de-DE').format(!isNaN(project.total_project_budget) ? (project.total_project_budget * 0.05) : 0)}) del total del proyecto ( ${new Intl.NumberFormat('de-DE').format(!isNaN(project.total_project_budget) ? project.total_project_budget : 0)}).
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <strong>Nota:</strong> Los valores en paréntesis son los valores calculados del proyecto.
                </td>
            </tr>
        </tfoot>
    </table>

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
    <div class="mb-6 flex justify-end items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        <div>
            {#if canCreateProjectSennovaBudgets || isSuperAdmin}
                <Button href={route('calls.projects.project-sennova-budgets.create', [call.id, project.id])}>
                    <div>
                        <span>{$_('Create')}</span>
                        <span class="hidden md:inline">{$_('Project sennova budgets.singular')}</span>
                    </div>
                </Button>
            {/if}
        </div>
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Información</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl" colspan="2">Subtotal del costo de los productos o servicios requeridos</th>
                </tr>
            </thead>
            <tbody>
                {#each projectSennovaBudgets.data as projectSennovaBudget (projectSennovaBudget.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <div class="flex flex-col focus:text-indigo-500 px-6 py-4">
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
                        </td>
                        <td class="border-t">
                            <div class="mt-3">
                                {#if projectSennovaBudget.average > 0} ${new Intl.NumberFormat('de-DE').format(projectSennovaBudget.average)} COP {:else if projectSennovaBudget.totalByBudgetWithoutMarketResearch > 0} ${new Intl.NumberFormat('de-DE').format(projectSennovaBudget.totalByBudgetWithoutMarketResearch)} {/if}
                            </div>
                            {#if !projectSennovaBudget.call_budget?.sennova_budget?.can_be_added}
                                <span class="bg-red-200 p-2 rounded-3xl mt-4 inline-block text-xs">Este uso presupuestal NO suma al total del presupuesto</span>
                            {/if}
                        </td>
                        <td class="border-t">
                            <ResourceMenu>
                                {#if canShowProjectSennovaBudgets || canEditProjectSennovaBudgets ||canDeleteProjectSennovaBudgets || isSuperAdmin}
                                    <Item on:SMUI:action={() => (Inertia.visit(route('calls.projects.project-sennova-budgets.edit', [call.id, project.id, projectSennovaBudget.id])))}>
                                        <Text>{$_('View details')}</Text>
                                    </Item>
                                {:else}
                                    <Item>
                                        <Text>{$_('You don\'t have permissions')}</Text>
                                    </Item>
                                {/if}
                            </ResourceMenu>
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
