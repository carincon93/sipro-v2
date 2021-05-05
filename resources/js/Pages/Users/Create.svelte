<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Switch from '@/Components/Switch'
    import Checkbox from '@/Components/Checkbox'
    import Select from 'svelte-select'
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre'

    export let errors
    export let documentTypes
    export let participationTypes
    export let roles

    $: $title = $_('Create') + ' ' + $_('Users.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser        = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexUsers   = authUser.can.find(element => element == 'users.index') == 'users.index'
    let canShowUsers    = authUser.can.find(element => element == 'users.show') == 'users.show'
    let canCreateUsers  = authUser.can.find(element => element == 'users.create') == 'users.create'
    let canEditUsers    = authUser.can.find(element => element == 'users.edit') == 'users.edit'
    let canDeleteUsers  = authUser.can.find(element => element == 'users.delete') == 'users.delete'

    let sending = false
    let form = useForm({
        name:               '',
        email:              '',
        document_type:      '',
        document_number:    '',
        cellphone_number:   '',
        is_enabled:         '',
        participation_type: '',
        academic_centre_id: '',
        role_id: []
    })

    function submit() {
        if (canCreateUsers || isSuperAdmin) {
            Inertia.post(route('users.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexUsers || canCreateUsers || isSuperAdmin}
                        <a use:inertia href={route('users.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Users.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Create')}
                </h1>
            </div>
        </div>
    </header>

    <form on:submit|preventDefault={submit}>
        <div class="bg-white rounded shadow max-w-3xl">
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre completo" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="email" value="Correo electrónico" />
                    <Input id="email" type="email" class="mt-1 block w-full" bind:value={$form.email} required />
                    <InputError message={errors.email} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="document_type" value="Tipo de documento" />
                    <Select noOptionsMessage={$_('No data recorded')} items={documentTypes} bind:selectedValue={$form.document_type} autocomplete="off" placeholder="Seleccione un tipo de documento"/>
                    <InputError message={errors.document_type} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="document_number" value="Número de documento" />
                    <Input id="document_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.document_number} required />
                    <InputError message={errors.document_number} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="cellphone_number" value="Número de celular" />
                    <Input id="cellphone_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.cellphone_number} required />
                    <InputError message={errors.cellphone_number} />
                </div>
                <div class="mt-4">
                    <Label required labelFor="is_enabled" value="¿Usuario habilitado para ingresar al sistema?" class="inline-block mb-4" />
                    <br>
                    <Switch bind:checked={$form.is_enabled} />
                    <InputError message={errors.is_enabled} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="participation_type" value="Tipo de participación" />
                    <Select noOptionsMessage={$_('No data recorded')} items={participationTypes} bind:selectedValue={$form.participation_type} autocomplete="off" placeholder="Seleccione el tipo de participación"/>
                    <InputError message={errors.participation_type} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="academic_centre_id" value="Centro de formación" />
                    <DropdownAcademicCentre id="academic_centre_id" bind:formAcademicCentre={$form.academic_centre_id} message={errors.academic_centre_id} />
                </div>

                <div>
                    <p>La contraseña de este usuario es: {#if $form.document_number} Sena{$form.document_number}*{/if}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow overflow-hidden mt-20">
            <div class="grid grid-cols-2">
                {#each roles as {id, name}, i}
                    <div class="p-3 border-t border-b flex items-center text-sm">{name}</div>

                    <div class="pt-8 pb-8 border-t border-b flex flex-col-reverse items-center justify-between">
                        <Checkbox id={id} bind:group={$form.role_id} value={id}/>
                    </div>
                {/each}
            </div>
        </div>

        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
            {#if canCreateUsers || isSuperAdmin}
                <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                    {$_('Create')} {$_('Users.singular')}
                </LoadingButton>
            {/if}
        </div>
    </form>
</AuthenticatedLayout>
