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
    import Button from '@/Components/Button'
    import Select from '@/Components/Select'
    import Checkbox from '@smui/checkbox'
    import FormField from '@smui/form-field'
    import Dialog from '@/Components/Dialog'
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre'

    export let errors
    export let user = {}
    export let documentTypes
    export let participationTypes
    export let roles
    export let userRoles

    $: $title = user ? user.name : null

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

    console.log(userRoles);

    let dialog_open = false
    let sending     = false
    let form = useForm({
        name:               user.name,
        email:              user.email,
        password:           user.password,
        document_type:      {value: user.document_type, label: documentTypes.find(item => item.value == user.document_type)?.label},
        document_number:    user.document_number,
        cellphone_number:   user.cellphone_number,
        is_enabled:         user.is_enabled,
        participation_type: {value: user.participation_type, label: documentTypes.find(item => item.value == user.participation_type)?.label},
        academic_centre_id: user.academic_centre_id,
        role_id:            userRoles
    })

    function submit() {
        if (canEditUsers || isSuperAdmin) {
            Inertia.put(route('users.update', user.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true
            })
        }
    }

    function destroy() {
        if (canDeleteUsers || isSuperAdmin) {
            Inertia.delete(route('users.destroy', user.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexUsers || canEditUsers || isSuperAdmin}
                        <a use:inertia href={route('users.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Users.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {user.name}
                </h1>
            </div>
        </div>
    </header>

    <form on:submit|preventDefault={submit}>
        <div class="bg-white rounded shadow max-w-3xl">
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre completo" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required  />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="email" value="Correo electrónico" />
                    <Input id="email" type="email" class="mt-1 block w-full" bind:value={$form.email} error={errors.email} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="document_type" value="Tipo de documento" />
                    {$form.document_type}
                    <Select id="document_type" items={documentTypes} bind:selectedValue={$form.document_type} error={errors.document_type} autocomplete="off" placeholder="Seleccione un tipo de documento" required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="document_number" value="Número de documento" />
                    <Input id="document_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.document_number} error={errors.document_number} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="cellphone_number" value="Número de celular" />
                    <Input id="cellphone_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.cellphone_number} error={errors.cellphone_number} required />
                </div>
                <div class="mt-4">
                    <Label required labelFor="is_enabled" value="¿Usuario habilitado para ingresar al sistema?" class="inline-block mb-4" />
                    <br>
                    <Switch bind:checked={$form.is_enabled} />
                    <InputError message={errors.is_enabled} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="participation_type" value="Tipo de participación" />
                    <Select id="participation_type" items={participationTypes} bind:selectedValue={$form.participation_type}  error={errors.participation_type} autocomplete="off" placeholder="Seleccione el tipo de participación" required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="academic_centre_id" value="Centro de formación" />
                    <DropdownAcademicCentre id="academic_centre_id" bind:formAcademicCentre={$form.academic_centre_id} message={errors.academic_centre_id} />
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow overflow-hidden mt-20">
            <div class="grid grid-cols-2">
                {#each roles as {id, name}, i}
                    <div class="pt-8 pb-8 border-t">
                        <FormField>
                            <Checkbox
                                bind:group={$form.role_id}
                                value={id}
                            />
                                <span slot="label">{name}</span>
                        </FormField>
                    </div>
                {/each}
            </div>
        </div>

        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
            {#if canDeleteUsers || isSuperAdmin}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                    {$_('Delete')} {$_('Users.singular').toLowerCase()}
                </button>
            {/if}
            {#if canEditUsers || isSuperAdmin}
                <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                    {$_('Update')} {$_('Users.singular')}
                </LoadingButton>
            {/if}
        </div>
    </form>

    <Dialog bind:open={dialog_open}>
        <div slot="title" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Eliminar recurso
        </div>
        <div slot="content">
            <p>
                ¿Está seguro(a) que desea eliminar este recurso?
                <br>
                Todos los datos se eliminarán de forma permanente.
                <br>
                Está acción no se puede deshacer.
            </p>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button on:click={event => dialog_open = false} variant={null}>{$_('Cancel')}</Button>
                <Button variant="raised" on:click={destroy}>
                    {$_('Confirm')}
                </Button>
            </div>
        </div>
    </Dialog>
</AuthenticatedLayout>
