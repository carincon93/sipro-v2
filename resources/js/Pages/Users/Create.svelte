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
    import Switch from '@/Components/Switch'
    import Select from 'svelte-select'

    export let errors
    export let documentTypes
    export let participationTypes

    $: $title = $_('Create') + ' ' + $_('Users.singular').toLowerCase()

    let sending = false
    let form = remember({
        name:               '',
        email:              '',
        document_type:      '',
        document_number:    '',
        cellphone:          '',
        is_enabled:         '',
        participation_type: '',
        academic_centre_id: ''
    })

    function submit() {
        Inertia.post(route('users.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('users.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Users.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {$_('Create')}
</h1>

<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
    <form on:submit|preventDefault={submit}>
        <div class="p-8">
            <div class="mt-4">
                <Label id="name" value="Nombre completo" />
                <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                <InputError message={errors.name} />
            </div>

            <div class="mt-4">
                <Label id="email" value="Correo electrónico" />
                <Input id="email" type="email" class="mt-1 block w-full" bind:value={$form.email} required />
                <InputError message={errors.email} />
            </div>

            <div class="mt-4">
                <Label id="document_type" value="Tipo de documento" />
                <Select noOptionsMessage={$_('No data recorded')} items={documentTypes} bind:selectedValue={$form.document_type} autocomplete="off" placeholder="Seleccione un tipo de documento"/>
                <InputError message={errors.document_type} />
            </div>

            <div class="mt-4">
                <Label id="document_number" value="Número de documento" />
                <Input id="document_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.document_number} required />
                <InputError message={errors.document_number} />
            </div>

            <div class="mt-4">
                <Label id="cellphone" value="Número de celular" />
                <Input id="cellphone" type="number" min="0" class="mt-1 block w-full" bind:value={$form.cellphone} required />
                <InputError message={errors.cellphone} />
            </div>
            <div class="mt-4">
                <Label id="is_enabled" value="¿Usuario habilitado para ingresar al sistema?" class="inline-block mb-4" />
                <br>
                <Switch bind:checked={$form.is_enabled} />
                <InputError message={errors.is_enabled} />
            </div>

            <div class="mt-4">
                <Label id="participation_type" value="Tipo de participación" />
                <Select noOptionsMessage={$_('No data recorded')} items={participationTypes} bind:selectedValue={$form.participation_type} autocomplete="off" placeholder="Seleccione el tipo de participación"/>
                <InputError message={errors.participation_type} />
            </div>

            <div>
                <input name="academic_centre_id" type="number" min="0" required bind:value={$form.academic_centre_id} />
                <InputError message={errors.academic_centre_id} />
            </div>

            <div>
                <p>La contraseña de este usuario es: {#if $form.document_number} Sena{$form.document_number}*{/if}</p>
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Create')} {$_('Users.singular')}
            </LoadingButton>
        </div>
    </form>
</div>
