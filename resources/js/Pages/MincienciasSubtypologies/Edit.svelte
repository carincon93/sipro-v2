<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'

    export let errors
    export let mincienciasSubtypology
    export let mincienciasTypologies
    export let selectedMincienciasTypology

    $: $title = mincienciasSubtypology ? mincienciasSubtypology.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                       = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexMincienciasSubtypologies   = authUser.can.find(element => element == 'minciencias-subtypologies.index') == 'minciencias-subtypologies.index'
    let canShowMincienciasSubtypologies    = authUser.can.find(element => element == 'minciencias-subtypologies.show') == 'minciencias-subtypologies.show'
    let canCreateMincienciasSubtypologies  = authUser.can.find(element => element == 'minciencias-subtypologies.create') == 'minciencias-subtypologies.create'
    let canEditMincienciasSubtypologies    = authUser.can.find(element => element == 'minciencias-subtypologies.edit') == 'minciencias-subtypologies.edit'
    let canDeleteMincienciasSubtypologies  = authUser.can.find(element => element == 'minciencias-subtypologies.delete') == 'minciencias-subtypologies.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        name:   mincienciasSubtypology.name,
        minciencias_typology_id: selectedMincienciasTypology
    })

    function submit() {
        if (canIndexMincienciasSubtypologies || isSuperAdmin) {
            Inertia.put(route('minciencias-subtypologies.update', mincienciasSubtypology.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteMincienciasSubtypologies || isSuperAdmin) {
            Inertia.delete(route('minciencias-subtypologies.destroy', mincienciasSubtypology.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexMincienciasSubtypologies || canEditMincienciasSubtypologies || isSuperAdmin}
                        <a use:inertia href={route('minciencias-subtypologies.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Minciencias subtypologies.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {mincienciasSubtypology.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="minciencias_typology_id" value="Tipología Minciencias" />
                    <Select items={mincienciasTypologies} bind:selectedValue={$form.minciencias_typology_id} autocomplete="off" placeholder="Seleccione una tipología Minciencias"/>
                    <InputError message={errors.minciencias_typology_id} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteMincienciasSubtypologies || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Minciencias subtypologies.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditMincienciasSubtypologies || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Minciencias subtypologies.singular')}
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
