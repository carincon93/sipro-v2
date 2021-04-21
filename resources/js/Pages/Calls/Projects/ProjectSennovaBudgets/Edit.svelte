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
    import File from '@/Components/File'

    export let call
    export let project
    export let errors
    export let projectSennovaBudget
    export let projectBudgetBatch

    $: $title = projectSennovaBudget ? projectSennovaBudget.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectSennovaBudgets   = authUser.can.find(element => element == 'project-sennova-budgets.index') == 'project-sennova-budgets.index'
    let canShowProjectSennovaBudgets    = authUser.can.find(element => element == 'project-sennova-budgets.show') == 'project-sennova-budgets.show'
    let canCreateProjectSennovaBudgets  = authUser.can.find(element => element == 'project-sennova-budgets.create') == 'project-sennova-budgets.create'
    let canEditProjectSennovaBudgets    = authUser.can.find(element => element == 'project-sennova-budgets.edit') == 'project-sennova-budgets.edit'
    let canDeleteProjectSennovaBudgets  = authUser.can.find(element => element == 'project-sennova-budgets.delete') == 'project-sennova-budgets.delete'

    let modal_open = false
    let sending = false
    let form = useForm({
        call_budget_id: projectSennovaBudget.call_budget_id,
        description: projectSennovaBudget.description,
        justification: projectSennovaBudget.justification,
        qty_items: projectBudgetBatch.qty_items,
        fact_sheet: projectBudgetBatch.fact_sheet,
    })

    function submit() {
        if (canEditProjectSennovaBudgets || isSuperAdmin) {
            let formData = new FormData()
            formData.append('call_budget_id', $form.call_budget_id)
            formData.append('description', $form.description)
            formData.append('justification', $form.justification)
            formData.append('qty_items', $form.qty_items)
            formData.append('fact_sheet', $form.fact_sheet)

            Inertia.put(route('calls.projects.project-sennova-budgets.update', [call.id, project.id, projectSennovaBudget.id]), formData, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
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
                    {projectSennovaBudget.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label id="call_budget_id" value="Concepto interno SENA" />
                    <DropdownCallBudget id="call_budget_id" bind:selectedBudgetUsage={$form.call_budget_id} message={errors.call_budget_id} />
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

