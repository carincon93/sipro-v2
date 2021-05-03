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

    export let errors
    export let regional = {}

    $: $title = regional ? regional.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRegional    = authUser.can.find(element => element == 'regional.index') == 'regional.index'
    let canShowRegional     = authUser.can.find(element => element == 'regional.show') == 'regional.show'
    let canCreateRegional   = authUser.can.find(element => element == 'regional.create') == 'regional.create'
    let canEditRegional     = authUser.can.find(element => element == 'regional.edit') == 'regional.edit'
    let canDeleteRegional   = authUser.can.find(element => element == 'regional.delete') == 'regional.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:    regional.name,
        code:   regional.code,
    })

    function submit() {
        if (canEditRegional || isSuperAdmin) {
            Inertia.put(route('regional.update', regional.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteRegional || isSuperAdmin) {
            Inertia.delete(route('regional.destroy', regional.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexRegional || canEditRegional || isSuperAdmin}
                        <a use:inertia href={route('regional.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Regional.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {regional.name}
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

                <div class="mt-4">
                    <Label required class="mb-4" id="code" value="Código" />
                    <Input id="code" type="number" min="0" class="mt-1 block w-full" bind:value={$form.code} required />
                    <InputError message={errors.code} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteRegional || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Regional.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditRegional || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Regional.singular')}
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
