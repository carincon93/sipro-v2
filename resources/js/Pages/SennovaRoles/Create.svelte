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
    import Textarea from '@/Components/Textarea'
    import DropdownProgrammaticLine from '@/Dropdowns/DropdownProgrammaticLine.svelte'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Sennova roles.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexSennovaRoles  = authUser.can.find(element => element == 'sennova-roles.index') == 'sennova-roles.index'
    let canShowSennovaRoles   = authUser.can.find(element => element == 'sennova-roles.show') == 'sennova-roles.show'
    let canCreateSennovaRoles = authUser.can.find(element => element == 'sennova-roles.create') == 'sennova-roles.create'
    let canEditSennovaRoles   = authUser.can.find(element => element == 'sennova-roles.edit') == 'sennova-roles.edit'
    let canDeleteSennovaRoles = authUser.can.find(element => element == 'sennova-roles.delete') == 'sennova-roles.delete'

    let sending = false
    let form = remember({
        name: '',
        description: '',
        programmatic_line_id: '',
    })

    function submit() {
        if (canCreateSennovaRoles || isSuperAdmin) {
            Inertia.post(route('sennova-roles.store'), $form, {
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
                    {#if canIndexSennovaRoles || canCreateSennovaRoles || isSuperAdmin}
                        <a use:inertia href={route('sennova-roles.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Sennova roles.plural')}
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
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label id="programmatic_line_id" value={$_('Programmatic lines.singular')} />
                    <DropdownProgrammaticLine id="programmatic_line_id" bind:formProgrammaticLine={$form.programmatic_line_id} message={errors.programmatic_line_id} />
                </div>

            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateSennovaRoles || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Sennova roles.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
