<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@/Components/Checkbox'

    export let errors
    export let role   = {}
    export let all_permissions
    export let role_permissions

    $: $title = role ? role.name : null

    let canUpdateRole = $page.props.auth.user.can.find(element => element == 'roles.edit') == 'roles.edit'
    let canDeleteRole = $page.props.auth.user.can.find(element => element == 'roles.delete') == 'roles.delete'

    let modal_open  = false
    let sending     = false
    let form = remember({
        name:           role.name,
        description:    role.description,
        role_permissions: role_permissions
    })

    function submit() {
        if (canUpdateRole) {
            Inertia.put(route('roles.update', role.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteRole) {
            Inertia.delete(route('roles.destroy', role.id))
        }
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('roles.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('System roles.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {role.name}
</h1>

<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
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

            <div class="block">
                {#each all_permissions as permission (permission.id)}
                    <label class="flex items-center" for={permission.name}>
                        <input type=checkbox checked={role_permissions.includes(permission.id)} bind:value={permission.id} >
                        <!-- <Checkbox name={permission.name} id={permission.name} bind:value={permission.id} /> -->
                        <span class="ml-2 text-sm text-gray-600">{$_(permission.name)}</span>
                    </label>
                {/each}
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteRole}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')} {$_('System roles.singular').toLowerCase()}
                </button>
            {/if}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Update')} {$_('System roles.singular')}
            </LoadingButton>
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
