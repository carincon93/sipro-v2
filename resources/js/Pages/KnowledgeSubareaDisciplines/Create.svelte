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
    export let knowledgeSubareas

    $: $title = $_('Create') + ' ' + $_('Knowledge subarea disciplines.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                         = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeSubareaDisciplines  = authUser.can.find(element => element == 'knowledge-subarea-disciplines.index') == 'knowledge-subarea-disciplines.index'
    let canShowKnowledgeSubareaDisciplines   = authUser.can.find(element => element == 'knowledge-subarea-disciplines.show') == 'knowledge-subarea-disciplines.show'
    let canCreateKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.create') == 'knowledge-subarea-disciplines.create'
    let canEditKnowledgeSubareaDisciplines   = authUser.can.find(element => element == 'knowledge-subarea-disciplines.edit') == 'knowledge-subarea-disciplines.edit'
    let canDeleteKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.delete') == 'knowledge-subarea-disciplines.delete'

    let sending = false
    let form = remember({
        name: '',
        knowledge_subarea: '',
    })

    function submit() {
        if (canCreateKnowledgeSubareaDisciplines || isSuperAdmin) {
            Inertia.post(route('knowledge-subarea-disciplines.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexKnowledgeSubareaDisciplines || canCreateKnowledgeSubareaDisciplines || isSuperAdmin}
            <a use:inertia href={route('knowledge-subarea-disciplines.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Knowledge subarea disciplines.plural')}
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
                    <Label id="knowledge_subarea" value="Subárea de conocimiento" />
                    <Select items={knowledgeSubareas} bind:selectedValue={$form.knowledge_subarea} autocomplete="off" placeholder="Seleccione una subárea de conocimiento"/>
                    <InputError message={errors.knowledge_subarea} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateKnowledgeSubareaDisciplines || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Knowledge subarea disciplines.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
