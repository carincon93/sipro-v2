<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownCallBudget from '@/Dropdowns/DropdownCallBudget'
    import Textarea from '@/Components/Textarea'

    export let call
    export let project
    export let errors

    $: $title = $_('Create') + ' ' + $_('Project sennova budgets.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin              = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectSennovaBudgets    = authUser.can.find(element => element == 'project-sennova-budgets.index') == 'project-sennova-budgets.index'
    let canShowProjectSennovaBudgets     = authUser.can.find(element => element == 'project-sennova-budgets.show') == 'project-sennova-budgets.show'
    let canCreateProjectSennovaBudgets   = authUser.can.find(element => element == 'project-sennova-budgets.create') == 'project-sennova-budgets.create'
    let canEditProjectSennovaBudgets     = authUser.can.find(element => element == 'project-sennova-budgets.edit') == 'project-sennova-budgets.edit'
    let canDeleteProjectSennovaBudgets   = authUser.can.find(element => element == 'project-sennova-budgets.delete') == 'project-sennova-budgets.delete'

    let showQtyInput = true
    let sending = false
    let form = useForm({
        call_budget_id: '',
        description: '',
        justification: '',
        value: '',
        qty_items: ''
    })

    function submit() {
        if (canCreateProjectSennovaBudgets || isSuperAdmin) {
            sending = true,
            Inertia.post(route('calls.projects.project-sennova-budgets.store', [call.id, project.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProjectSennovaBudgets || canCreateProjectSennovaBudgets || isSuperAdmin}
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
                    <DropdownCallBudget bind:selectedBudgetUsage={$form.call_budget_id} bind:showQtyInput={showQtyInput} message={errors.call_budget_id} {call} programmaticLine={project.project_type.programmatic_line} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="description" value="Describa el bien o servicio a adquirir. Sea específico"/>
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="justification" value="Justificación de la necesidad: ¿por qué se requiere este producto o servicio?"/>
                    <Textarea id="justification" error={errors.justification} bind:value={$form.justification} required />
                </div>

                {#if !showQtyInput}
                    <div class="mt-4">
                        <Label required class="mb-4" id="qty_items" value="Indique la cantidad requerida del producto o servicio relacionado" />
                        <Input id="qty_items" type="number" min="1" class="mt-1 block w-full" bind:value={$form.qty_items} error={errors.qty_items} required />
                    </div>
                    <div class="mt-4">
                        <Label required class="mb-4" id="value" value="Valor" />
                        <Input id="value" type="number" min="1" class="mt-1 block w-full" bind:value={$form.value} error={errors.value} required />
                    </div>
                {/if}
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateProjectSennovaBudgets && $form.call_budget_id != ''|| isSuperAdmin && $form.call_budget_id != ''}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Project sennova budgets.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
