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
    export let projectType
    export let programmaticLines
    export let selectedProgrammaticLine

    $: $title = projectType ? projectType.name : null

    let canUpdateprojectType = $page.props.auth.user.can.find(element => element == 'project-types.edit') == 'project-types.edit'
    let canDeleteprojectType = $page.props.auth.user.can.find(element => element == 'project-types.delete') == 'project-types.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   projectType.name,
        maximum_value:   projectType.maximum_value,
        programmatic_line: selectedProgrammaticLine
    })

    function submit() {
        if (canUpdateprojectType) {
            Inertia.put(route('project-types.update', projectType.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteprojectType) {
            Inertia.delete(route('project-types.destroy', projectType.id))
        }
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('project-types.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Project types.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {projectType.name}
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
                <Label id="maximum_value" value="Valor máximo" />
                <Input id="maximum_value" type="number" min="0" class="mt-1 block w-full" bind:value={$form.maximum_value} required autofocus />
                <InputError message={errors.maximum_value} />
            </div>

            <div class="mt-4">
                <Label id="programmatic_line" value="Línea programática" />
                <Select items={programmaticLines} bind:selectedValue={$form.programmatic_line} autocomplete="off" placeholder="Seleccione una subárea de conocimiento"/>
                <InputError message={errors.programmatic_line} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteprojectType}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')} {$_('Project types.singular').toLowerCase()}
                </button>
            {/if}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Update')} {$_('Project types.singular')}
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
