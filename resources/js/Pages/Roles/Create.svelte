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

    export let errors
    export let role_permissions

    console.log(role_permissions)

    $: $title = 'Crear rol de sistema'

    let sending = false
    let form = remember({
        name: '',
        description: '',
    })

    function submit() {
        Inertia.post(route('roles.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('roles.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_("Roles")}
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
                <Label id="description" value="Descripción" />
                <textarea name="description" id="description" class="w-full" cols="30" rows="10" bind:value={$form.description} required></textarea>
                <InputError message={errors.description} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                Create role
            </LoadingButton>
        </div>
    </form>
</div>
