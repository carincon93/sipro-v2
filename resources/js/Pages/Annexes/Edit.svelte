<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Textarea from '@/Components/Textarea'
    import Label from '@/Components/Label'
    import Button from '@/Components/Button'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@smui/checkbox'
    import FormField from '@smui/form-field'

    export let errors
    export let annexe = {}
    export let programmaticLines
    export let annexeProgrammaticLines

    $: $title = annexe ? annexe.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAnnexes    = authUser.can.find(element => element == 'annexes.index') == 'annexes.index'
    let canShowAnnexes     = authUser.can.find(element => element == 'annexes.show') == 'annexes.show'
    let canCreateAnnexes   = authUser.can.find(element => element == 'annexes.create') == 'annexes.create'
    let canEditAnnexes     = authUser.can.find(element => element == 'annexes.edit') == 'annexes.edit'
    let canDeleteAnnexes   = authUser.can.find(element => element == 'annexes.delete') == 'annexes.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        name:  annexe.name,
        description: annexe.description,
        programmatic_line_id: annexeProgrammaticLines,
    })

    function submit() {
        if (canEditAnnexes || isSuperAdmin) {
            Inertia.put(route('annexes.update', annexe.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true
            })
        }
    }

    function destroy() {
        if (canDeleteAnnexes || isSuperAdmin) {
            Inertia.delete(route('annexes.destroy', annexe.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexAnnexes || canEditAnnexes || isSuperAdmin}
                        <a use:inertia href={route('annexes.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Annexes.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {annexe.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset class="p-8" disabled={canEditAnnexes || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre del anexo" />
                    <Textarea rows="4" id="name" error={errors.name} bind:value={$form.name} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="description" value="Descripción" />
                    <Textarea rows="4" id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="bg-white rounded shadow overflow-hidden mt-20">
                    <div class="grid grid-cols-2">
                        {#each programmaticLines as {id, name, code}, i}
                            <FormField>
                                <Checkbox
                                    bind:group={$form.programmatic_line_id}
                                    value={id}
                                />
                                    <span slot="label">{name} ({code})</span>
                            </FormField>
                        {/each}
                    </div>
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteAnnexes || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Annexes.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditAnnexes || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Annexes.singular')}
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

