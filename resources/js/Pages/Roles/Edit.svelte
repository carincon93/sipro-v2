<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@smui/checkbox'
    import FormField from '@smui/form-field'
    import Textarea from '@/Components/Textarea'

    export let errors
    export let role   = {}
    export let all_permissions
    export let role_permissions

    $: $title = role ? role.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRoles   = authUser.can.find(element => element == 'roles.index') == 'roles.index'
    let canShowRoles    = authUser.can.find(element => element == 'roles.show') == 'roles.show'
    let canCreateRoles  = authUser.can.find(element => element == 'roles.create') == 'roles.create'
    let canEditRoles    = authUser.can.find(element => element == 'roles.edit') == 'roles.edit'
    let canDeleteRoles  = authUser.can.find(element => element == 'roles.delete') == 'roles.delete'

    let modal_open  = false
    let sending     = false
    let form = useForm({
        name:           role.name,
        description:    role.description,
        permissions:    role_permissions
    })

    function submit() {
        if (canEditRoles || isSuperAdmin) {
            Inertia.put(route('roles.update', role.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true
            })
        }
    }

    function destroy() {
        if (canDeleteRoles || isSuperAdmin) {
            Inertia.delete(route('roles.destroy', role.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexRoles || canEditRoles || isSuperAdmin}
                        <a use:inertia href={route('roles.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('System roles.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {role.name}
                </h1>
            </div>
        </div>
    </header>

    <form on:submit|preventDefault={submit}>
        <div class="bg-white rounded shadow max-w-3xl p-8">
            <div class="mt-4">
                <Label required class="mb-4" id="name" value="Nombre" />
                <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required autofocus />
            </div>

            <div class="mt-4">
                <Label required class="mb-4" id="description" value="Descripción" />
                <Textarea rows="4" id="description" error={errors.description} bind:value={$form.description} required />
            </div>
        </div>

        <div class="bg-white rounded shadow overflow-hidden mt-20">
            <div class="grid grid-cols-6">
                {#each all_permissions as {id, only_name, method}, i}
                    {#if i % 5 === 0}
                        <div class="p-3 border-t border-b flex items-center text-sm">{$_(only_name+'.plural')}</div>
                    {/if}
                    <div class="pt-8 pb-8 border-t border-b flex flex-col-reverse items-center justify-between">
                        <FormField>
                            <Checkbox
                                bind:group={$form.permissions}
                                value={id}
                            />
                                <span slot="label">{$_(method)}</span>
                        </FormField>
                    </div>
                {/each}
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
            {#if canDeleteRoles || isSuperAdmin}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')} {$_('System roles.singular').toLowerCase()}
                </button>
            {/if}
            {#if canEditRoles || isSuperAdmin}
                <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                    {$_('Update')} {$_('System roles.singular')}
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
</AuthenticatedLayout>
