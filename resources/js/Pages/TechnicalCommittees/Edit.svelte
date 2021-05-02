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
    export let technicalCommittee = {}

    $: $title = technicalCommittee ? technicalCommittee.name : null

    let authUser = $page.props.auth.user
    let isSuperAdmin                 = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexTechnicalCommittees  = authUser.can.find(element => element == 'technical-committees.index') == 'technical-committees.index'
    let canShowTechnicalCommittees   = authUser.can.find(element => element == 'technical-committees.show') == 'technical-committees.show'
    let canCreateTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.create') == 'technical-committees.create'
    let canEditTechnicalCommittees   = authUser.can.find(element => element == 'technical-committees.edit') == 'technical-committees.edit'
    let canDeleteTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.delete') == 'technical-committees.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   technicalCommittee.name,
    })

    function submit() {
        if (canEditTechnicalCommittees || isSuperAdmin) {
            Inertia.put(route('technical-committees.update', technicalCommittee.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
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
                    {#if canIndexTechnicalCommittees || canEditTechnicalCommittees || isSuperAdmin}
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
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteTechnicalCommittees || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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
