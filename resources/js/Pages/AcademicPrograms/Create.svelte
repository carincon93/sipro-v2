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
    export let academicCentres = {}
    export let studyModes

    $: $title = 'Crear programa de formación'

    let sending = false
    let form = remember({
        name:  '',
        code: '',
        study_mode: '',
        academic_centre: '',
    })

    function submit() {
        Inertia.post(route('academic-programs.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('academic-programs.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_("Academic program")}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    Crear
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
                <Label id="code" value="Código" />
                <Input id="code" type="text" class="mt-1 block w-full" bind:value={$form.code} required />
                <InputError message={errors.code} />
            </div>

            <div class="mt-4">
                <Label id="study_mode" value="Modalidad de estudio" />
                <Select items={studyModes} bind:selectedValue={$form.study_mode} autocomplete="off" placeholder="Seleccione una modalidad de estudio"/>
                <InputError message={errors.study_mode} />
            </div>

            <div class="mt-4">
                <Label id="academic_centre" value="Centro de formación" />
                <Select items={academicCentres} bind:selectedValue={$form.academic_centre} autocomplete="off" placeholder="Seleccione el centro de formación"/>
                <InputError message={errors.academic_centre} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                Create academic program
            </LoadingButton>
        </div>
    </form>
</div>
