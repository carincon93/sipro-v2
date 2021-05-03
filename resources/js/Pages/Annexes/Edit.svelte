<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Textarea from '@/Components/Textarea'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@/Components/Checkbox'

    export let errors
    export let annexe = {}
    export let programmaticLines
    export let annexeProgrammaticLines

    $: $title = annexe ? annexe.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexAnnexes    = authUser.can.find(element => element == 'annexes.index') == 'annexes.index'
    let canShowAnnexes     = authUser.can.find(element => element == 'annexes.show') == 'annexes.show'
    let canCreateAnnexes   = authUser.can.find(element => element == 'annexes.create') == 'annexes.create'
    let canEditAnnexes     = authUser.can.find(element => element == 'annexes.edit') == 'annexes.edit'
    let canDeleteAnnexes   = authUser.can.find(element => element == 'annexes.delete') == 'annexes.delete'

    let modal_open = false
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
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" id="name" value="Nombre del anexo" />
                    <Textarea id="name" error={errors.name} bind:value={$form.name} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="bg-white rounded shadow overflow-hidden mt-20">
                    <div class="grid grid-cols-2">
                        {#each programmaticLines as {id, name, code}, i}
                            <div class="p-3 border-t border-b flex items-center text-sm">{name} ({code})</div>

                            <div class="pt-8 pb-8 border-t border-b flex flex-col-reverse items-center justify-between">
                                <Checkbox id={id} checked={annexeProgrammaticLines.includes(id)}  bind:group={$form.programmatic_line_id} value={id}/>
                            </div>
                        {/each}
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteAnnexes || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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

