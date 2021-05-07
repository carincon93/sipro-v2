<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import Button from '@/Components/Button'
    import LoadingButton from '@/Components/LoadingButton'

    export let errors
    export let technicalCommittee = {}

    $: $title = technicalCommittee ? technicalCommittee.name : null

    let authUser = $page.props.auth.user
    let isSuperAdmin                 = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexTechnicalCommittees  = authUser.can.find(element => element == 'technical-committees.index') == 'technical-committees.index'
    let canShowTechnicalCommittees   = authUser.can.find(element => element == 'technical-committees.show') == 'technical-committees.show'
    let canCreateTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.create') == 'technical-committees.create'
    let canEditTechnicalCommittees   = authUser.can.find(element => element == 'technical-committees.edit') == 'technical-committees.edit'
    let canDeleteTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.delete') == 'technical-committees.delete'

    let dialog_open = false
    let sending     = false
    let form = useForm({
        name: technicalCommittee.name,
    })

    function submit() {
        if (canEditTechnicalCommittees || isSuperAdmin) {
            Inertia.put(route('technical-committees.update', technicalCommittee.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true
            })
        }
    }

    function destroy() {
        if (canDeleteTechnicalCommittees || isSuperAdmin) {
            Inertia.delete(route('technical-committees.destroy', technicalCommittee.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexTechnicalCommittees || canShowTechnicalCommittees || canEditTechnicalCommittees || canDeleteTechnicalCommittees || isSuperAdmin}
                        <a use:inertia href={route('technical-committees.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Technical committees.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {technicalCommittee.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset class="p-8" disabled={canEditTechnicalCommittees || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required />
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteTechnicalCommittees || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')}  {$_('Technical committees.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditTechnicalCommittees || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Technical committees.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
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
</AuthenticatedLayout>
