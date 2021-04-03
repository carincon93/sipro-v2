<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Switch from '@/Components/Switch'
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre'
    import Select from 'svelte-select'

    export let errors
    export let user = {}
    export let documentTypes
    export let participationTypes

    $: $title = user ? user.name : null

    // Permisos
    let authUser        = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexUsers   = authUser.can.find(element => element == 'users.index') == 'users.index'
    let canShowUsers    = authUser.can.find(element => element == 'users.show') == 'users.show'
    let canCreateUsers  = authUser.can.find(element => element == 'users.create') == 'users.create'
    let canEditUsers    = authUser.can.find(element => element == 'users.edit') == 'users.edit'
    let canDeleteUsers  = authUser.can.find(element => element == 'users.delete') == 'users.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:               user.name,
        email:              user.email,
        password:           user.password,
        document_type:      user.document_type,
        document_number:    user.document_number,
        cellphone:          user.cellphone,
        is_enabled:         user.is_enabled,
        participation_type: user.participation_type,
        academic_centre_id: user.academic_centre_id
    })

    function submit() {
        if (canEditUsers || isSuperAdmin) {
            Inertia.put(route('users.update', user.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
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

    <div class="bg-white rounded shadow max-w-3xl">
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
                    <Select items={documentTypes} bind:selectedValue={$form.document_type} autocomplete="off" placeholder="Seleccione un tipo de documento"/>
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
                    <Select items={participationTypes} bind:selectedValue={$form.participation_type} autocomplete="off" placeholder="Seleccione el tipo de participación"/>
                    <InputError message={errors.participation_type} />
                </div>

                <div class="mt-4">
                    <Label id="academic_centre_id" value="Centro de formación" />
                    <DropdownAcademicCentre id="academic_centre_id" bind:formAcademicCentre={$form.academic_centre_id} message={errors.academic_centre_id} />
                    <InputError message={errors.academic_centre_id} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteUsers || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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
</AuthenticatedLayout>
