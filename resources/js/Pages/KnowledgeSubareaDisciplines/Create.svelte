<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember } from '@inertiajs/inertia-svelte'
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

    let sending = false
    let form = remember({
        name: '',
        knowledge_subarea: '',
    })

    function submit() {
        Inertia.post(route('knowledge-subarea-disciplines.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('knowledge-subarea-disciplines.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Knowledge subarea disciplines.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {$_('Create')}
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
                <Label id="knowledge_subarea" value="Subárea de conocimiento" />
                <Select items={knowledgeSubareas} bind:selectedValue={$form.knowledge_subarea} autocomplete="off" placeholder="Seleccione una subárea de conocimiento"/>
                <InputError message={errors.knowledge_subarea} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Create')} {$_('Knowledge subarea disciplines.singular')}
            </LoadingButton>
        </div>
    </form>
</div>
