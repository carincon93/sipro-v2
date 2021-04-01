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
    import Select from 'svelte-select'

    export let errors
    export let knowledgeSubarea
    export let knowledgeAreas
    export let selectedKnowledgeArea

    $: $title = knowledgeSubarea ? knowledgeSubarea.name : null

    let canUpdateKnowledgeSubarea = $page.props.auth.user.can.find(element => element == 'knowledge-subareas.edit') == 'knowledge-subareas.edit'
    let canDeleteKnowledgeSubarea = $page.props.auth.user.can.find(element => element == 'knowledge-subareas.delete') == 'knowledge-subareas.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   knowledgeSubarea.name,
        knowledge_area: selectedKnowledgeArea
    })

    function submit() {
        if (canUpdateKnowledgeSubarea) {
            Inertia.put(route('knowledge-subareas.update', knowledgeSubarea.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteKnowledgeSubarea) {
            Inertia.delete(route('knowledge-subareas.destroy', knowledgeSubarea.id))
        }
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('knowledge-subareas.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Knowledge subareas.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {knowledgeSubarea.name}
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
                <Label id="knowledge_area" value="Área de conocimiento" />
                <Select items={knowledgeAreas} bind:selectedValue={$form.knowledge_area} autocomplete="off" placeholder="Seleccione una área de conocimiento"/>
                <InputError message={errors.knowledge_area} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteKnowledgeSubarea}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')} {$_('Knowledge subareas.singular').toLowerCase()}
                </button>
            {/if}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Update')} {$_('Knowledge subareas.singular')}
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
