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
    export let knowledgeNetwork = {}

    $: $title = knowledgeNetwork ? knowledgeNetwork.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeNetworks   = authUser.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'
    let canShowKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.show') == 'knowledge-networks.show'
    let canCreateKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.create') == 'knowledge-networks.create'
    let canEditKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.edit') == 'knowledge-networks.edit'
    let canDeleteKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.delete') == 'knowledge-networks.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name: knowledgeNetwork.name,
    })

    function submit() {
        if (canEdiKnowledgeNetworks || isSuperAdmin) {
            Inertia.put(route('knowledge-networks.update', knowledgeNetwork.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteKnowledgeNetworks || isSuperAdmin) {
            Inertia.delete(route('knowledge-networks.destroy', knowledgeNetwork.id))
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexKnowledgeNetworks || canEditKnowledgeNetworks || isSuperAdmin}
            <a use:inertia href={route('knowledge-networks.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Knowledge networks.plural')}
            </a>
        {/if}
        <span class="text-indigo-400 font-medium">/</span>
        {knowledgeNetwork.name}
    </h1>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteKnowledgeNetworks || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Knowledge networks.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditKnowledgeNetworks || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Knowledge networks.singular')}
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
