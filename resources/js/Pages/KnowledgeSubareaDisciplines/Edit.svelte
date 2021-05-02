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
    import Select from 'svelte-select'

    export let errors
    export let knowledgeSubareaDiscipline
    export let knowledgeSubareas
    export let selectedKnowledgeSubarea

    $: $title = knowledgeSubareaDiscipline ? knowledgeSubareaDiscipline.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                         = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexKnowledgeSubareaDisciplines  = authUser.can.find(element => element == 'knowledge-subarea-disciplines.index') == 'knowledge-subarea-disciplines.index'
    let canShowKnowledgeSubareaDisciplines   = authUser.can.find(element => element == 'knowledge-subarea-disciplines.show') == 'knowledge-subarea-disciplines.show'
    let canCreateKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.create') == 'knowledge-subarea-disciplines.create'
    let canEditKnowledgeSubareaDisciplines   = authUser.can.find(element => element == 'knowledge-subarea-disciplines.edit') == 'knowledge-subarea-disciplines.edit'
    let canDeleteKnowledgeSubareaDisciplines = authUser.can.find(element => element == 'knowledge-subarea-disciplines.delete') == 'knowledge-subarea-disciplines.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:               knowledgeSubareaDiscipline.name,
        knowledge_subarea:  selectedKnowledgeSubarea
    })

    function submit() {
        if (canEditKnowledgeSubareaDisciplines || isSuperAdmin) {
            Inertia.put(route('knowledge-subarea-disciplines.update', knowledgeSubareaDiscipline.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteKnowledgeSubareaDisciplines || isSuperAdmin) {
            Inertia.delete(route('knowledge-subarea-disciplines.destroy', knowledgeSubareaDiscipline.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexKnowledgeSubareaDisciplines || canEditKnowledgeSubareaDisciplines || isSuperAdmin}
                        <a use:inertia href={route('knowledge-subarea-disciplines.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Knowledge subarea disciplines.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {knowledgeSubareaDiscipline.name}
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
                    <Label required class="mb-4" id="knowledge_subarea" value="Subárea de conocimiento" />
                    <Select items={knowledgeSubareas} bind:selectedValue={$form.knowledge_subarea} autocomplete="off" placeholder="Seleccione una subárea de conocimiento"/>
                    <InputError message={errors.knowledge_subarea} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteKnowledgeSubareaDisciplines || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Knowledge subarea disciplines.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditKnowledgeSubareaDisciplines || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Knowledge subarea disciplines.singular')}
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
