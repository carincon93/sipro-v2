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

    $: $title = $_('Create') + ' ' + $_('Knowledge networks.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeNetworks   = authUser.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'
    let canShowKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.show') == 'knowledge-networks.show'
    let canCreateKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.create') == 'knowledge-networks.create'
    let canEditKnowledgeNetworks    = authUser.can.find(element => element == 'knowledge-networks.edit') == 'knowledge-networks.edit'
    let canDeleteKnowledgeNetworks  = authUser.can.find(element => element == 'knowledge-networks.delete') == 'knowledge-networks.delete'

    let sending = false
    let form = remember({
        name:  '',
    })

    function submit() {
        if (canCreateKnowledgeNetworks || isSuperAdmin) {
            Inertia.post(route('knowledge-networks.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexKnowledgeNetworks || canCreateKnowledgeNetworks || isSuperAdmin}
            <a use:inertia href={route('knowledge-networks.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Knowledge networks.plural')}
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
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateKnowledgeNetworks || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Knowledge networks.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
