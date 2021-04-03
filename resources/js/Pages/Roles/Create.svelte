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

    export let errors
    export let role_permissions

    $: $title = $_('Create') + ' ' + $_('System roles.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRoles   = authUser.can.find(element => element == 'roles.index') == 'roles.index'
    let canShowRoles    = authUser.can.find(element => element == 'roles.show') == 'roles.show'
    let canCreateRoles  = authUser.can.find(element => element == 'roles.create') == 'roles.create'
    let canEditRoles    = authUser.can.find(element => element == 'roles.edit') == 'roles.edit'
    let canDeleteRoles  = authUser.can.find(element => element == 'roles.delete') == 'roles.delete'

    let sending = false
    let form = remember({
        name: '',
        description: '',
    })

    function submit() {
        if (canCreateRoles || isSuperAdmin) {
                Inertia.post(route('roles.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexRoles || canCreateRoles || isSuperAdmin}
            <a use:inertia href={route('roles.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('System roles.plural')}
            </a>
        {/if}
        <span class="text-indigo-400 font-medium">/</span>
        {$_('Create')}
    </h1>

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
                    <textarea name="description" id="description" class="w-full" cols="30" rows="10" bind:value={$form.description} required></textarea>
                    <InputError message={errors.description} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateRoles || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('System roles.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
