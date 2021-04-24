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
    import Textarea from '@/Components/Textarea'
    import DropdownProgrammaticLine from '@/Dropdowns/DropdownProgrammaticLine'

    export let errors
    export let sennovaRole = {}

    $: $title = sennovaRole ? sennovaRole.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexSennovaRoles = authUser.can.find(element => element == 'sennova-roles.index') == 'sennova-roles.index'
    let canShowSennovaRoles   = authUser.can.find(element => element == 'sennova-roles.show') == 'sennova-roles.show'
    let canCreateSennovaRoles = authUser.can.find(element => element == 'sennova-roles.create') == 'sennova-roles.create'
    let canEditSennovaRoles   = authUser.can.find(element => element == 'sennova-roles.edit') == 'sennova-roles.edit'
    let canDeleteSennovaRoles = authUser.can.find(element => element == 'sennova-roles.delete') == 'sennova-roles.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   sennovaRole.name,
        description:   sennovaRole.description,
        programmatic_line_id: sennovaRole.programmatic_line_id,

    })

    function submit() {
        if (canEditSennovaRoles || isSuperAdmin) {
            Inertia.put(route('sennova-roles.update', sennovaRole.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteSennovaRoles || isSuperAdmin) {
            Inertia.delete(route('sennova-roles.destroy', sennovaRole.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexSennovaRoles || canEditSennovaRoles || isSuperAdmin}
                        <a use:inertia href={route('sennova-roles.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Sennova roles.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {sennovaRole.name}
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
                    <Label required id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label required id="programmatic_line_id" value={$_('Programmatic lines.singular')} />
                    <DropdownProgrammaticLine id="programmatic_line_id" bind:formProgrammaticLine={$form.programmatic_line_id} message={errors.programmatic_line_id} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteSennovaRoles || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Sennova roles.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditSennovaRoles || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Sennova roles.singular')}
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
