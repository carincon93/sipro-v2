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
    let isSuperAdmin                       = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexMincienciasSubtypologies   = authUser.can.find(element => element == 'minciencias-subtypologies.index') == 'minciencias-subtypologies.index'
    let canShowMincienciasSubtypologies    = authUser.can.find(element => element == 'minciencias-subtypologies.show') == 'minciencias-subtypologies.show'
    let canCreateMincienciasSubtypologies  = authUser.can.find(element => element == 'minciencias-subtypologies.create') == 'minciencias-subtypologies.create'
    let canEditMincienciasSubtypologies    = authUser.can.find(element => element == 'minciencias-subtypologies.edit') == 'minciencias-subtypologies.edit'
    let canDeleteMincienciasSubtypologies  = authUser.can.find(element => element == 'minciencias-subtypologies.delete') == 'minciencias-subtypologies.delete'

    let modal_open = false
    let sending = false
    let form = remember({
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
                    <Label required class="mb-4" id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="minciencias_typology_id" value="Tipología Minciencias" />
                    <Select items={mincienciasTypologies} bind:selectedValue={$form.minciencias_typology_id} autocomplete="off" placeholder="Seleccione una tipología Minciencias"/>
                    <InputError message={errors.minciencias_typology_id} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteMincienciasSubtypologies || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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
