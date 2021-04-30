<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownMincienciasSubtypology from '@/Dropdowns/DropdownMincienciasSubtypology'
    import Select from 'svelte-select'

    export let call
    export let project
    export let errors
    export let output
    export let researchResults
    export let selectedResearchResult

    $: $title = output ? output.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin      = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexOutputs   = authUser.can.find(element => element == 'outputs.index') == 'outputs.index'
    let canShowOutputs    = authUser.can.find(element => element == 'outputs.show') == 'outputs.show'
    let canCreateOutputs  = authUser.can.find(element => element == 'outputs.create') == 'outputs.create'
    let canEditOutputs    = authUser.can.find(element => element == 'outputs.edit') == 'outputs.edit'
    let canDeleteOutputs  = authUser.can.find(element => element == 'outputs.delete') == 'outputs.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name: output.name,
        research_result_id: selectedResearchResult,
        minciencias_subtypology_id: output.rdi_output?.minciencias_subtypology_id,
        start_date: output.start_date,
        end_date: output.end_date
    })

    function submit() {
        if (canIndexOutputs || isSuperAdmin) {
            Inertia.put(route('calls.projects.outputs.update', [call.id, project.id, output.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteOutputs || isSuperAdmin) {
            Inertia.delete(route('calls.projects.outputs.destroy', [call.id, project.id, output.id]))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexOutputs || canEditOutputs || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.outputs.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Outputs.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {output.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required id="research_result_id" value={$_('Research results.singular')} />
                    <Select items={researchResults} bind:selectedValue={$form.research_result_id} autocomplete="off" placeholder="Seleccione un resultado"/>
                    <InputError message={errors.research_result_id} />
                </div>

                {#if output.rdi_output}
                    <div class="mt-4">
                        <Label required id="minciencias_subtypology_id" value={$_('Minciencias subtypologies.singular')} />
                        <DropdownMincienciasSubtypology id="minciencias_subtypology_id" bind:formMincienciasSubtypology={$form.minciencias_subtypology_id} message={errors.minciencias_subtypology_id} />
                        <InputError message={errors.name} />
                    </div>
                {/if}

                <div class="mt-8">
                    <p class="text-center">Fecha de ejecución</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label required id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={$form.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label required id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={$form.end_date} required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteOutputs || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Outputs.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditOutputs || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Outputs.singular')}
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
