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
    import Select from 'svelte-select'

    export let errors
    export let knowledgeAreas

    $: $title = $_('Create') + ' ' + $_('Knowledge subareas.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeSubareas   = authUser.can.find(element => element == 'knowledge-subareas.index') == 'knowledge-subareas.index'
    let canShowKnowledgeSubareas    = authUser.can.find(element => element == 'knowledge-subareas.show') == 'knowledge-subareas.show'
    let canCreateKnowledgeSubareas  = authUser.can.find(element => element == 'knowledge-subareas.create') == 'knowledge-subareas.create'
    let canEditKnowledgeSubareas    = authUser.can.find(element => element == 'knowledge-subareas.edit') == 'knowledge-subareas.edit'
    let canDeleteKnowledgeSubareas  = authUser.can.find(element => element == 'knowledge-subareas.delete') == 'knowledge-subareas.delete'

    let sending = false
    let form = remember({
        name: '',
        knowledge_area: '',
    })

    function submit() {
        if (canCreateKnowledgeSubareas || isSuperAdmin) {
            Inertia.post(route('knowledge-subareas.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexKnowledgeSubareas || canCreateKnowledgeSubareas || isSuperAdmin}
            <a use:inertia href={route('knowledge-subareas.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Knowledge subareas.plural')}
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
                    <Label id="knowledge_area" value="Área de conocimiento" />
                    <Select items={knowledgeAreas} bind:selectedValue={$form.knowledge_area} autocomplete="off" placeholder="Seleccione una área de conocimiento"/>
                    <InputError message={errors.knowledge_area} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateKnowledgeSubareas || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Knowledge subareas.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
