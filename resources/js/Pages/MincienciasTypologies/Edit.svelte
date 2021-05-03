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
    export let mincienciasTypology

    $: $title = mincienciasTypology ? mincienciasTypology.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexMincienciasTypologies   = authUser.can.find(element => element == 'minciencias-typologies.index') == 'minciencias-typologies.index'
    let canShowMincienciasTypologies    = authUser.can.find(element => element == 'minciencias-typologies.show') == 'minciencias-typologies.show'
    let canCreateMincienciasTypologies  = authUser.can.find(element => element == 'minciencias-typologies.create') == 'minciencias-typologies.create'
    let canEditMincienciasTypologies    = authUser.can.find(element => element == 'minciencias-typologies.edit') == 'minciencias-typologies.edit'
    let canDeleteMincienciasTypologies  = authUser.can.find(element => element == 'minciencias-typologies.delete') == 'minciencias-typologies.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   mincienciasTypology.name,
    })

    function submit() {
        if (canIndexMincienciasTypologies || isSuperAdmin) {
            Inertia.put(route('minciencias-typologies.update', mincienciasTypology.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteMincienciasTypologies || isSuperAdmin) {
            Inertia.delete(route('minciencias-typologies.destroy', mincienciasTypology.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexMincienciasTypologies || canEditMincienciasTypologies || isSuperAdmin}
                        <a use:inertia href={route('minciencias-typologies.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Minciencias typologies.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {mincienciasTypology.name}
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
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteMincienciasTypologies || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Minciencias typologies.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditMincienciasTypologies || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Minciencias typologies.singular')}
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
