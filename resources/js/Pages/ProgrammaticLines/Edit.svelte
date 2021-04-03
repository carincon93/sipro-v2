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
    import Textarea from '@/Components/Textarea'

    export let errors
    export let programmaticLine   = {}
    export let selectedProjectCategory
    export let projectCategories

    $: $title = programmaticLine ? programmaticLine.name : null

    // Permisos
    let authUser    = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProgrammaticLines   = authUser.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'
    let canShowProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.show') == 'programmatic-lines.show'
    let canCreateProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.create') == 'programmatic-lines.create'
    let canEditProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.edit') == 'programmatic-lines.edit'
    let canDeleteProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.delete') == 'programmatic-lines.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:               programmaticLine.name,
        code:               programmaticLine.code,
        project_category:   selectedProjectCategory,
    })

    function submit() {
        if (canEditProgrammaticLines || isSuperAdmin) {
            Inertia.put(route('programmatic-lines.update', programmaticLine.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteProgrammaticLines|| isSuperAdmin) {
            Inertia.delete(route('programmatic-lines.destroy', programmaticLine.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProgrammaticLines || canEditProgrammaticLines || isSuperAdmin}
                        <a use:inertia href={route('programmatic-lines.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Programmatic lines.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {programmaticLine.name}
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
                    <Label id="code" value="Código" />
                    <Input id="code" type="text" class="mt-1 block w-full" bind:value={$form.code} required />
                    <InputError message={errors.code} />
                </div>

                <div class="mt-4">
                    <Label id="project_category" value="Categoría" />
                    <Select items={projectCategories} bind:selectedValue={$form.project_category} autocomplete="off" placeholder="Seleccione una categoría"/>
                    <InputError message={errors.project_category} />
                </div>

                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                    <InputError message={errors.description} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteProgrammaticLines || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Programmatic lines.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditProgrammaticLines || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Programmatic lines.singular')}
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
