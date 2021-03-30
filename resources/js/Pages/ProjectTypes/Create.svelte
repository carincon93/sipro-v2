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
    export let programmaticLines

    $: $title = $_('Create') + ' ' + $_('Project types.singular').toLowerCase()

    let sending = false
    let form = remember({
        name: '',
        maximum_value: '',
        programmatic_line: '',
    })

    function submit() {
        Inertia.post(route('project-types.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('project-types.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Project types.plural')}
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
                <Label id="maximum_value" value="Valor máximo" />
                <Input id="maximum_value" type="number" min="0" class="mt-1 block w-full" bind:value={$form.maximum_value} required autofocus />
                <InputError message={errors.maximum_value} />
            </div>

            <div class="mt-4">
                <Label id="programmatic_line" value="Línea programática" />
                <Select items={programmaticLines} bind:selectedValue={$form.programmatic_line} autocomplete="off" placeholder="Seleccione una línea programática"/>
                <InputError message={errors.programmatic_line} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Create')} {$_('Project types.singular')}
            </LoadingButton>
        </div>
    </form>
</div>
