<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownMincienciasSubtypology from '@/Dropdowns/DropdownMincienciasSubtypology'
    import Select from 'svelte-select'

    export let call
    export let project
    export let errors
    export let researchResults

    $: $title = $_('Create') + ' ' + $_('Outputs.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRDIOutputs  = authUser.can.find(element => element == 'rdi-outputs.index') == 'rdi-outputs.index'
    let canShowRDIOutputs   = authUser.can.find(element => element == 'rdi-outputs.show') == 'rdi-outputs.show'
    let canCreateRDIOutputs = authUser.can.find(element => element == 'rdi-outputs.create') == 'rdi-outputs.create'
    let canEditRDIOutputs   = authUser.can.find(element => element == 'rdi-outputs.edit') == 'rdi-outputs.edit'
    let canDeleteRDIOutputs = authUser.can.find(element => element == 'rdi-outputs.delete') == 'rdi-outputs.delete'

    let sending = false
    let form = remember({
        name: '',
        research_result_id: '',
        // minciencias_subtypology_id: '',
        start_date: '',
        end_date: ''
    })

    function submit() {
        if (canCreateRDIOutputs || isSuperAdmin) {
            Inertia.post(route('calls.projects.outputs.store', [call.id, project.id]), $form, {
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
                    {#if canIndexRDIOutputs || canCreateRDIOutputs || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.outputs.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Outputs.plural')}
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
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label id="research_result_id" value={$_('Research results.singular')} />
                    <Select items={researchResults} bind:selectedValue={$form.research_result_id} autocomplete="off" placeholder="Seleccione un resultado"/>
                    <InputError message={errors.research_result_id} />
                </div>

                {#if project.rdi}
                    <div class="mt-4">
                        <Label id="minciencias_subtypology_id" value={$_('Minciencias subtypologies.singular')} />
                        <DropdownMincienciasSubtypology id="minciencias_subtypology_id" bind:formMincienciasSubtypology={$form.minciencias_subtypology_id} message={errors.minciencias_subtypology_id} />
                        <InputError message={errors.name} />
                    </div>
                {/if}

                <div class="mt-4">
                    <p class="text-center">Fecha de ejecución</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={$form.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={$form.end_date} required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateRDIOutputs || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Outputs.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
