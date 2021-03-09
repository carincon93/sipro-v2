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
    export let academicCentres
    export let mincienciasCategories

    $: $title = 'Crear tipo de proyecto'

    let sending = false
    let form = remember({
        name: '',
        acronym: '',
        email: '',
        gruplac_link: '',
        minciencias_code: '',
        minciencias_category: '',
        academic_centre: '',
    })

    function submit() {
        Inertia.post(route('research-groups.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('research-groups.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_("Research groups")}
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
                <Label id="acronym" value="Sigla" />
                <Input id="acronym" type="text" class="mt-1 block w-full" bind:value={$form.acronym} required autofocus />
                <InputError message={errors.acronym} />
            </div>

            <div class="mt-4">
                <Label id="email" value="Correo electrónico" />
                <Input id="email" type="email" class="mt-1 block w-full" bind:value={$form.email} required autofocus />
                <InputError message={errors.email} />
            </div>

            <div class="mt-4">
                <Label id="gruplac_link" value="Enlace GrupLac" />
                <Input id="gruplac_link" type="url" class="mt-1 block w-full" bind:value={$form.gruplac_link} required autofocus />
                <InputError message={errors.gruplac_link} />
            </div>

            <div class="mt-4">
                <Label id="minciencias_code" value="Código Minciencias" />
                <Input id="minciencias_code" type="text" class="mt-1 block w-full" bind:value={$form.minciencias_code} required autofocus />
                <InputError message={errors.minciencias_code} />
            </div>

            <div class="mt-4">
                <Label id="minciencias_category" value="Categoría Minciencias" />
                <Select items={mincienciasCategories} bind:selectedValue={$form.minciencias_category} autocomplete="off" placeholder="Seleccione una categoría Minciencias"/>
                <InputError message={errors.minciencias_category} />
            </div>

            <div class="mt-4">
                <Label id="academic_centre" value="Centro de formación" />
                <Select items={academicCentres} bind:selectedValue={$form.academic_centre} autocomplete="off" placeholder="Seleccione un centro de formación"/>
                <InputError message={errors.academic_centre} />
            </div>

        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                Create research group
            </LoadingButton>
        </div>
    </form>
</div>
