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

    $: $title = $_('Create') + ' ' + $_('Knowledge areas.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeAreas  = authUser.can.find(element => element == 'knowledge-areas.index') == 'knowledge-areas.index'
    let canShowKnowledgeAreas   = authUser.can.find(element => element == 'knowledge-areas.show') == 'knowledge-areas.show'
    let canCreateKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.create') == 'knowledge-areas.create'
    let canEditKnowledgeAreas   = authUser.can.find(element => element == 'knowledge-areas.edit') == 'knowledge-areas.edit'
    let canDeleteKnowledgeAreas = authUser.can.find(element => element == 'knowledge-areas.delete') == 'knowledge-areas.delete'

    let sending = false
    let form = remember({
        name: '',
    })

    function submit() {
        if (canCreateKnowledgeAreas || isSuperAdmin) {
            Inertia.post(route('knowledge-areas.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexKnowledgeAreas || canCreateKnowledgeAreas || isSuperAdmin}
            <a use:inertia href={route('knowledge-areas.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Knowledge areas.plural')}
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
                {#if canCreateKnowledgeAreas || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Knowledge areas.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
