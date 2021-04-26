<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import CreateMarketResearch from '@/Pages/Calls/Projects/ProjectSennovaBudgets/MarketResearch/Create'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Button from '@/Components/Button'
    import Pagination from '@/Components/Pagination'
    import { Modal, Card } from 'svelte-chota'

    export let call
    export let project
    export let projectSennovaBudget
    export let projectBudgetBatches = []
    export let errors

    $title = $_('Market research.plural')

    let modal_open = $page.props.flash.success || errors.length > 0 ? true : false

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin             = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexMarketResearch   = authUser.can.find(element => element == 'market-research.index') == 'market-research.index'
    let canShowMarketResearch    = authUser.can.find(element => element == 'market-research.show') == 'market-research.show'
    let canCreateMarketResearch  = authUser.can.find(element => element == 'market-research.create') == 'market-research.create'
    let canEditMarketResearch    = authUser.can.find(element => element == 'market-research.edit') == 'market-research.edit'
    let canDeleteMarketResearch  = authUser.can.find(element => element == 'market-research.delete') == 'market-research.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexMarketResearch || canEditMarketResearch || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.project-sennova-budgets.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project sennova budgets.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {projectSennovaBudget.call_budget.sennova_budget.budget_usage.description}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Market research.plural')}
                </h1>
            </div>
        </div>
    </header>

    <h1 class="font-bold text-3xl m-24 text-center">{$_('Market research.plural')}</h1>

    <div class="bg-indigo-100 p-5 text-indigo-600 mb-10">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {#if projectSennovaBudget.call_budget.sennova_budget.requires_market_research}
            {#if projectSennovaBudget.call_budget.sennova_budget.requires_market_research_batch}
                <p class="mb-4">
                    El uso presupuestal <strong>{projectSennovaBudget.call_budget.sennova_budget.budget_usage.description}</strong> permite que se agreguen multiples estudios de mercado. De clic en el botón <strong>'{$_('Add')} {$_('Market research.singular').toLowerCase()}'</strong> y añada los que considere necesarios.
                </p>
            {/if}
            {#if !projectSennovaBudget.call_budget.sennova_budget.requires_market_research_batch && projectBudgetBatches.data.length < 1 || projectSennovaBudget.call_budget.sennova_budget.requires_market_research_batch}
                <div class="mb-6 flex justify-between items-center">
                    <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
                    {#if canCreateMarketResearch || isSuperAdmin}
                        <Button classes="inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 ml-auto" tabindex="-1" type="button">
                            <div on:click={event => modal_open = true} class="px-4 py-2">
                                {$_('Add')} {$_('Market research.singular').toLowerCase()}
                            </div>
                        </Button>
                    {/if}
                </div>
            {/if}
        {/if}
        <table class="w-full whitespace-no-wrap bg-white mt-4 mb-4">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl" colspan="2">Estudio(s) de mercado</th>
                </tr>
            </thead>
            <tbody>
                {#each projectBudgetBatches.data as projectBudgetBatch, i}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t px-6 pt-6 pb-4">
                            <a
                                use:inertia
                                href={route('calls.projects.project-sennova-budgets.project-budget-batches.edit', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id])}
                                class="focus:text-indigo-500">
                                    <h1>Estudio de mercado #{i + 1}</h1>
                                    <p>Cantidad de items: {projectBudgetBatch.qty_items}</p>
                                    <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id])}>Descargar ficha técnica</a>
                            </a>
                        </td>
                        <td class="border-t px-6 pt-6 pb-4">
                            <a
                                use:inertia
                                href={route('calls.projects.project-sennova-budgets.project-budget-batches.edit', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id])}
                                class="focus:text-indigo-500">
                                    {#each projectBudgetBatch.market_research as {id, company_name, price_quote}}
                                            <div><strong>Nombre de la compañía: </strong>{company_name}</div>
                                            <div><strong>Valor: </strong>${new Intl.NumberFormat('de-DE').format(price_quote)} COP</div>

                                            <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download-price-qoute-file', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id, id])}>Descargar soporte</a>
                                    {/each}
                            </a>
                        </td>
                    </tr>
                {/each}

                {#if projectBudgetBatches.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
            <tfoot>
                <tr>
                    <td class="border-t px-6 pt-6 pb-4" colspan="2">
                        <h1>Valor promedio del estudio de mercado: <strong>${new Intl.NumberFormat('de-DE').format(projectSennovaBudget.average)} COP</strong></h1>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <Modal bind:open={modal_open}>
        <Card>
            <CreateMarketResearch {errors} {call} {project} {projectSennovaBudget} {projectBudgetBatches}/>
        </Card>
    </Modal>

    <Pagination links={projectBudgetBatches.links} />
</AuthenticatedLayout>
