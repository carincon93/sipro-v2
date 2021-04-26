<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownCallBudget from '@/Dropdowns/DropdownCallBudget'
    import Textarea from '@/Components/Textarea'

    export let call
    export let project
    export let errors
    export let projectSennovaBudget
    export let projectSennovaBudgetBatches

    let callBudget      = projectSennovaBudget.call_budget
    let sennovaBudget   = projectSennovaBudget

    $: $title = projectSennovaBudget.call_budget.sennova_budget.budget_usage ? projectSennovaBudget.call_budget.sennova_budget.budget_usage.description : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectSennovaBudgets    = authUser.can.find(element => element == 'project-sennova-budgets.index') == 'project-sennova-budgets.index'
    let canShowProjectSennovaBudgets     = authUser.can.find(element => element == 'project-sennova-budgets.show') == 'project-sennova-budgets.show'
    let canCreateProjectSennovaBudgets   = authUser.can.find(element => element == 'project-sennova-budgets.create') == 'project-sennova-budgets.create'
    let canEditProjectSennovaBudgets     = authUser.can.find(element => element == 'project-sennova-budgets.edit') == 'project-sennova-budgets.edit'
    let canDeleteProjectSennovaBudgets   = authUser.can.find(element => element == 'project-sennova-budgets.delete') == 'project-sennova-budgets.delete'

    let enabled = projectSennovaBudget.value != null ? false : true
    let modal_open = false
    let sending = false
    let form = useForm({
        call_budget_id: callBudget.id,
        description: projectSennovaBudget.description,
        justification: projectSennovaBudget.justification,
        value: projectSennovaBudget.value,
        qty_items: projectSennovaBudget.qty_items
    })

    function submit() {
        if (canEditProjectSennovaBudgets || isSuperAdmin) {
            Inertia.put(route('calls.projects.project-sennova-budgets.update', [call.id, project.id, projectSennovaBudget.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true
            })
        }
    }

    function destroy() {
        if (canDeleteProjectSennovaBudgets || isSuperAdmin) {
            Inertia.delete(route('calls.projects.project-sennova-budgets.destroy', [call.id, project.id, projectSennovaBudget.id]))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProjectSennovaBudgets || canEditProjectSennovaBudgets || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.project-sennova-budgets.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project sennova budgets.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {projectSennovaBudget.call_budget.sennova_budget.budget_usage.description}
                </h1>
            </div>
        </div>
    </header>

    <div class="{!enabled ? '' : 'flex'}">
        <div class="bg-white rounded shadow max-w-3xl{!enabled ? '' : ' flex-1'}">
            <form on:submit|preventDefault={submit} id="form-project-budget">
                <div class="p-8">
                    <div class="mt-4">
                        <DropdownCallBudget bind:selectedBudgetUsage={$form.call_budget_id} bind:enabled={enabled} {sennovaBudget} message={errors.call_budget_id} required />
                        <InputError message={errors.call_budget_id} />
                    </div>

                    {#if !enabled && projectSennovaBudget.project_budget_batches.length > 0}
                        <div class="bg-indigo-100 p-5 text-indigo-600 mb-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>El uso presupuestal seleccionado no requiere de estudio de mercado. Si el ítem a actualizar tenía estudios de mercado generados estos se eliminarán.</p>
                        </div>
                    {/if}

                    <div class="mt-4">
                        <Label required id="description" value="Describa el bien o servicio a adquirir. Sea específico"/>
                        <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                    </div>

                    <div class="mt-4">
                        <Label required id="justification" value="Justificación de la necesidad: ¿por qué se requiere este producto o servicio?"/>
                        <Textarea id="justification" error={errors.justification} bind:value={$form.justification} required />
                    </div>

                    {#if !enabled}
                        <div class="mt-4">
                            <Label required id="qty_items" value="Indique la cantidad requerida del producto o servicio relacionado" />
                            <Input id="qty_items" type="text" class="mt-1 block w-full" bind:value={$form.qty_items} error={errors.qty_items} required />
                        </div>
                        <div class="mt-4">
                            <Label required id="value" value="Valor" />
                            <Input id="value" type="text" class="mt-1 block w-full" bind:value={$form.value} error={errors.value} required />
                        </div>
                    {/if}
                </div>

                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                    {#if canDeleteProjectSennovaBudgets || isSuperAdmin}
                        <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                            {$_('Delete')} {$_('Project sennova budgets.singular').toLowerCase()}
                        </button>
                    {/if}
                    {#if canEditProjectSennovaBudgets || isSuperAdmin}
                        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                            {$_('Update')} {$_('Project sennova budgets.singular')}
                        </LoadingButton>
                    {/if}
                </div>
            </form>
        </div>
        {#if enabled}
            <div class="ml-4">
                {#if canEditProjectSennovaBudgets || isSuperAdmin}
                    <a use:inertia href={route('calls.projects.project-sennova-budgets.project-budget-batches.index', [call.id, project.id, projectSennovaBudget.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo mb-4">
                        {$_('Market research.plural')}
                    </a>
                {/if}
                <table class="w-full whitespace-no-wrap bg-white">
                    <thead>
                        <tr class="text-left font-bold">
                            <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl" colspan="2">Estudio(s) de mercado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#each projectSennovaBudgetBatches.project_budget_batches as projectSennovaBudgetBatch, i}
                            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t px-6 pt-6 pb-4">
                                    <h1>Estudio de mercado #{i + 1}</h1>
                                    <p>Cantidad de items: {projectSennovaBudgetBatch.qty_items}</p>
                                    <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download', [call.id, project.id, projectSennovaBudget.id, projectSennovaBudgetBatch.id])}>Descargar ficha técnica</a>
                                </td>
                                <td class="border-t px-6 pt-6 pb-4">
                                    {#each projectSennovaBudgetBatch.market_research as {id, company_name, price_quote}}
                                        <div><strong>Nombre de la compañía: </strong>{company_name}</div>
                                        <div><strong>Valor: </strong>${new Intl.NumberFormat('de-DE').format(price_quote)} COP</div>
                                        <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download-price-qoute-file', [call.id, project.id, projectSennovaBudget.id, projectSennovaBudgetBatch.id, id])}>Descargar soporte</a>
                                    {/each}
                                </td>
                            </tr>
                        {/each}

                        {#if projectSennovaBudgetBatches.project_budget_batches.length === 0}
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
        {/if}

        <Modal bind:open={modal_open}>
            <Card>
                <div class="p-4">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 bg-red-500 hover:bg-red-400 ml-auto" type="button" on:click={destroy}>
                        {$_('Confirm')}
                    </button>
                    <button on:click={event => modal_open = false} type="button">{$_('Cancel')}</button>
                </div>
            </Card>
        </Modal>
    </div>
</AuthenticatedLayout>

