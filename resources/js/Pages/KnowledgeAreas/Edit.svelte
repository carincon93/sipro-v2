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

    export let errors
    export let knowledgeArea   = {}

    $: $title = knowledgeArea ? knowledgeArea.name : null

    let canUpdateKnowledgeArea = $page.props.auth.user.can.find(element => element == 'knowledge-areas.edit') == 'knowledge-areas.edit'
    let canDeleteKnowledgeArea = $page.props.auth.user.can.find(element => element == 'knowledge-areas.delete') == 'knowledge-areas.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   knowledgeArea.name,
    })

    function submit() {
        if (canUpdateKnowledgeArea) {
            Inertia.put(route('knowledge-areas.update', knowledgeArea.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteKnowledgeArea) {
            Inertia.delete(route('knowledge-areas.destroy', knowledgeArea.id))
        }
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('knowledge-areas.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_("Knowledge areas")}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {knowledgeArea.name}
</h1>

<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
    <form on:submit|preventDefault={submit}>
        <div class="p-8">
            <div class="mt-4">
                <Label id="name" value="Nombre" />
                <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                <InputError message={errors.name} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteKnowledgeArea}
                <button class="text-red-600 hover:underline" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    Delete knowledge area
                </button>
            {/if}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                Update knowledge area
            </LoadingButton>
        </div>
    </form>

    <Modal bind:open={modal_open}>
        <Card>
            <div class="p-4">
                <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 bg-red-500 hover:bg-red-400 ml-auto" type="button" on:click={destroy}>
                    {$_("Confirm")}
                </button>
                <button on:click={event => modal_open = false} type="button">{$_("Cancel")}</button>
            </div>
        </Card>
    </Modal>
</div>
