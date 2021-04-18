<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownCallBudget from '@/Dropdowns/DropdownCallBudget'
    import Textarea from '@/Components/Textarea'
    import File from '@/Components/File'
    import axios from 'axios';

    export let call
    export let project
    export let errors

    let projectSennovaBudget
    let projectBudgetBatch

    $: $title = $_('Create') + ' ' + $_('Project sennova budgets.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin              = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectBudgets    = authUser.can.find(element => element == 'project-budgets.index') == 'project-budgets.index'
    let canShowProjectBudgets     = authUser.can.find(element => element == 'project-budgets.show') == 'project-budgets.show'
    let canCreateProjectBudgets   = authUser.can.find(element => element == 'project-budgets.create') == 'project-budgets.create'
    let canEditProjectBudgets     = authUser.can.find(element => element == 'project-budgets.edit') == 'project-budgets.edit'
    let canDeleteProjectBudgets   = authUser.can.find(element => element == 'project-budgets.delete') == 'project-budgets.delete'

    let sending = false
    let form = useForm({
        call_budget_id: '',
        description: '',
        justification: '',
        qty_items: '',
        fact_sheet: ''
    })

    function submit() {
        if (canCreateProjectBudgets || isSuperAdmin) {
            let formData = new FormData()
            formData.append('call_budget_id', $form.call_budget_id)
            formData.append('description', $form.description)
            formData.append('justification', $form.justification)
            formData.append('qty_items', $form.qty_items)
            formData.append('fact_sheet', $form.fact_sheet)

            sending = true,
            axios.post(route('calls.projects.project-sennova-budgets.store', [call.id, project.id]), formData)
                .then(function (response) {
                    projectSennovaBudget = response.data.projectSennovaBudget.id
                    projectBudgetBatch = response.data.projectBudgetBatch.id
                    sending = false
                })
        }
    }

    let formMarketResearch = useForm({
        price_quote: '',
        company_name: '',
        price_quote_file: ''
    })

    function submitMarketResearch() {
        if (canCreateProjectBudgets && projectSennovaBudget || isSuperAdmin && projectSennovaBudget) {
            let formData = new FormData()
            formData.append('price_quote', $formMarketResearch.price_quote)
            formData.append('company_name', $formMarketResearch.company_name)
            formData.append('price_quote_file', $formMarketResearch.price_quote_file)

            sending = true,
            Inertia.post(route('calls.projects.project-sennova-budgets.project-budget-batches.market-research.store', [call.id, project.id, projectSennovaBudget, projectBudgetBatch]), formData, {
                onStart: ()     => sending = true,
                onFinish: ()    => {
                    sending = false,
                    $formMarketResearch.price_quote = '',
                    $formMarketResearch.company_name = '',
                    $formMarketResearch.price_quote_file = ''
                    document.getElementById('price_quote_file').value = ''
                },
                preserveScroll: true,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProjectBudgets || canCreateProjectBudgets || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.project-sennova-budgets.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project sennova budgets.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Create')}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <DropdownCallBudget bind:selectedBudgetUsage={$form.call_budget_id} message={errors.call_budget_id} />
                    <InputError message={errors.call_budget_id} />
                </div>

                <div class="mt-4">
                    <Label id="description" value="Describa el bien o servicio a adquirir. Sea específico" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label id="justification" value="Justificación de la necesidad: ¿por qué se requiere este producto o servicio?" />
                    <Textarea id="justification" error={errors.justification} bind:value={$form.justification} required />
                </div>

                <div class="mt-4">
                    <Label id="qty_items" value="Indique la cantidad requerida del producto o servicio relacionado" />
                    <Input id="qty_items" type="number" min="1" class="mt-1 block w-full" bind:value={$form.qty_items} error={errors.qty_items} required />
                </div>

                <div class="mt-4">
                    <Label id="fact_sheet" value="ANEXO 2. Fichas técnicas para maquinaria y equipos" />
                    <File id="fact_sheet" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.fact_sheet} error={errors.fact_sheet} required />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateProjectBudgets || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Project sennova budgets.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>

        {#if projectSennovaBudget}
            <form on:submit|preventDefault={submitMarketResearch}>
                <div class="p-8">

                    <div class="mt-4">
                        <Label id="price_quote" value="Valor (incluido IVA)" />
                        <Input id="price_quote" type="number" min="0" class="mt-1 block w-full" bind:value={$formMarketResearch.price_quote} error={errors.price_quote} required />
                    </div>

                    <div class="mt-4">
                        <Label id="company_name" value="Nombre de la empresa" />
                        <Input id="company_name" type="text" class="mt-1 block w-full" bind:value={$formMarketResearch.company_name} error={errors.company_name} required />
                    </div>

                    <div class="mt-4">
                        <Label id="price_quote_file" value="Soporte" />
                        <File id="price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$formMarketResearch.price_quote_file} error={errors.price_quote_file} required />
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                    {#if canCreateProjectBudgets || isSuperAdmin}
                        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                            {$_('Create')} {$_('Market research.singular')}
                        </LoadingButton>
                    {/if}
                </div>
            </form>
        {/if}
    </div>
</AuthenticatedLayout>

