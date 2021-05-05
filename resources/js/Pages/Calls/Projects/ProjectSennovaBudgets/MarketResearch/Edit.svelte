<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import File from '@/Components/File'
    import Switch from '@/Components/Switch'
    import { afterUpdate } from 'svelte';

    export let errors
    export let call
    export let project
    export let projectSennovaBudget
    export let projectBudgetBatch

    $: $title = projectSennovaBudget.call_budget.sennova_budget.budget_usage.description ? projectSennovaBudget.call_budget.sennova_budget.budget_usage.description : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexMarketResearch  = authUser.can.find(element => element == 'market-research.index') == 'market-research.index'
    let canShowMarketResearch   = authUser.can.find(element => element == 'market-research.show') == 'market-research.show'
    let canCreateMarketResearch = authUser.can.find(element => element == 'market-research.create') == 'market-research.create'
    let canEditMarketResearch   = authUser.can.find(element => element == 'market-research.edit') == 'market-research.edit'
    let canDeleteMarketResearch = authUser.can.find(element => element == 'market-research.delete') == 'market-research.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        requires_third_market_research: projectBudgetBatch.market_research[2] || errors.third_price_quote || errors.third_company_name || errors.third_price_quote_file ? true : false,
        call_budget_id: projectSennovaBudget.call_budget.id,
        qty_items: projectBudgetBatch.qty_items,
        fact_sheet: '',

        first_market_research_id: projectBudgetBatch.market_research[0].id,
        first_price_quote: projectBudgetBatch.market_research[0].price_quote,
        first_company_name: projectBudgetBatch.market_research[0].company_name,
        first_price_quote_file: '',

        second_market_research_id: projectBudgetBatch.market_research[1].id,
        second_price_quote: projectBudgetBatch.market_research[1].price_quote,
        second_company_name: projectBudgetBatch.market_research[1].company_name,
        second_price_quote_file: '',

        third_market_research_id: projectBudgetBatch.market_research[2]?.id ?? '',
        third_price_quote: projectBudgetBatch.market_research[2]?.price_quote ?? '',
        third_company_name: projectBudgetBatch.market_research[2]?.company_name ?? '',
        third_price_quote_file: '',
    })

    function submit() {
        if (canEditMarketResearch || isSuperAdmin) {
            let formData = new FormData()
            formData.append('_method', 'put')
            formData.append('call_budget_id', $form.call_budget_id)
            formData.append('qty_items', $form.qty_items)
            formData.append('fact_sheet', $form.fact_sheet)

            formData.append('first_market_research_id', $form.first_market_research_id)
            formData.append('first_price_quote', $form.first_price_quote)
            formData.append('first_company_name', $form.first_company_name)
            formData.append('first_price_quote_file', $form.first_price_quote_file)

            formData.append('second_market_research_id', $form.second_market_research_id)
            formData.append('second_price_quote', $form.second_price_quote)
            formData.append('second_company_name', $form.second_company_name)
            formData.append('second_price_quote_file', $form.second_price_quote_file)

            formData.append('requires_third_market_research', $form.requires_third_market_research)
            formData.append('third_market_research_id', $form.third_market_research_id)
            if ($form.requires_third_market_research) {
                formData.append('third_price_quote', $form.third_price_quote)
                formData.append('third_company_name', $form.third_company_name)
                formData.append('third_price_quote_file', $form.third_price_quote_file)
            }

            sending = true,
            Inertia.post(route('calls.projects.project-sennova-budgets.project-budget-batches.update', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id]), formData, {
                onStart: ()     => sending = true,
                onFinish: ()    => {
                    sending     = false
                },
                onError: () => {
                    $form.requires_third_market_research = errors.third_price_quote || errors.third_company_name || errors.third_price_quote_file ? true : false
                },
            })
        }
    }

    function destroy() {
        if (canDeleteMarketResearch || isSuperAdmin) {
            Inertia.delete(route('calls.projects.project-sennova-budgets.project-budget-batches.destroy', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id]))
        }
    }

    let average
    afterUpdate(() => {
        average = ((parseInt($form.first_price_quote) + parseInt($form.second_price_quote) + (parseInt($form.third_price_quote) > 0 && $form.requires_third_market_research ? parseInt($form.third_price_quote) : 0)) / (parseInt($form.third_price_quote) > 0 && $form.requires_third_market_research ? 3 : 2))
    })
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
                    {#if canIndexMarketResearch || canEditMarketResearch || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.project-sennova-budgets.project-budget-batches.index', [call.id, project.id, projectSennovaBudget.id])} class="text-indigo-400 hover:text-indigo-600">
                            {projectSennovaBudget.call_budget.sennova_budget.budget_usage.description}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Market research.plural')}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Edit')}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="qty_items" value="Indique la cantidad requerida del producto o servicio relacionado" />
                    <Input id="qty_items" type="number" min="1" class="mt-1 block w-full" bind:value={$form.qty_items} error={errors.qty_items} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="fact_sheet" value="ANEXO 2. Fichas técnicas para maquinaria y equipos" />
                    <File id="fact_sheet" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.fact_sheet} error={errors.fact_sheet} />
                    <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.id])}>Descargar ficha técnica</a>
                </div>

                <h1 class="text-center mt-20 mb-20">Primer estudio de mercado</h1>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="first_price_quote" value="Valor (incluido IVA)" />
                    <Input id="first_price_quote" type="number" min="1" class="mt-1 block w-full" bind:value={$form.first_price_quote} error={errors.first_price_quote} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="first_company_name" value="Nombre de la empresa" />
                    <Input id="first_company_name" type="text" class="mt-1 block w-full" bind:value={$form.first_company_name} error={errors.first_company_name} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="first_price_quote_file" value="Soporte" />
                    <File id="first_price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.first_price_quote_file} error={errors.first_price_quote_file} />
                    <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.market_research[0].id])}>Descargar soporte</a>
                </div>

                <h1 class="text-center mt-20 mb-20">Segundo estudio de mercado</h1>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="second_price_quote" value="Valor (incluido IVA)" />
                    <Input id="second_price_quote" type="number" min="1" class="mt-1 block w-full" bind:value={$form.second_price_quote} error={errors.second_price_quote} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="second_company_name" value="Nombre de la empresa" />
                    <Input id="second_company_name" type="text" class="mt-1 block w-full" bind:value={$form.second_company_name} error={errors.second_company_name} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="second_price_quote_file" value="Soporte" />
                    <File id="second_price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.second_price_quote_file} error={errors.second_price_quote_file} />
                    <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.market_research[1].id])}>Descargar soporte</a>
                </div>

                <div class="mt-8">
                    <Label labelFor="requires_third_market_research" value="¿Requiere de un tercer estudio de mercado?" class="inline-block mb-4" />
                    <br>
                    <Switch bind:checked={$form.requires_third_market_research} />
                </div>

                {#if $form.requires_third_market_research}
                    <h1 class="text-center mt-20 mb-20">Tercer estudio de mercado</h1>
                    <div class="mt-4">
                        <Label required class="mb-4" labelFor="third_price_quote" value="Valor (incluido IVA)" />
                        <Input id="third_price_quote" type="number" min="0" class="mt-1 block w-full" bind:value={$form.third_price_quote} error={errors.third_price_quote} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" labelFor="third_company_name" value="Nombre de la empresa" />
                        <Input id="third_company_name" type="text" class="mt-1 block w-full" bind:value={$form.third_company_name} error={errors.third_company_name} required />
                    </div>

                    <div class="mt-4">
                        <Label labelFor="third_price_quote_file" value="Soporte" required />
                        <File id="third_price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.third_price_quote_file} error={errors.third_price_quote_file} />
                        {#if projectBudgetBatch.market_research[2] != undefined} <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-sennova-budgets.project-budget-batches.download', [call.id, project.id, projectSennovaBudget.id, projectBudgetBatch.market_research[2].id])} required>Descargar soporte</a> {/if}
                    </div>
                {/if}
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteMarketResearch || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Market research.singular').toLowerCase()}
                    </button>
                {/if}
                <p class="break-all w-72">
                    Valor promedio: ${ average > 0 ? new Intl.NumberFormat('de-DE').format(average) : 0 } COP
                </p>
                {#if canEditMarketResearch || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Market research.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>

        <Dialog bind:open={dialog_open}>
        <div slot="title" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Eliminar recurso
        </div>
        <div slot="content">
            <p>
                ¿Está seguro(a) que desea eliminar este recurso?
                <br>
                Todos los datos se eliminarán de forma permanente.
                <br>
                Está acción no se puede deshacer.
            </p>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button on:click={event => dialog_open = false} variant={null}>{$_('Cancel')}</Button>
                <Button variant="raised" on:click={destroy}>
                    {$_('Confirm')}
                </Button>
            </div>
        </div>
    </Dialog>
    </div>
</AuthenticatedLayout>
