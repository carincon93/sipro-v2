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
    import Select from 'svelte-select'

    export let errors
    export let documentTypes
    export let call
    export let rdi
    export let partnerOrganization

    $: $title = $_('Create') + ' ' + $_('Partner organization members.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexPartnerOrganizationMembers  = authUser.can.find(element => element == 'partner-organization-members.index') == 'partner-organization-members.index'
    let canShowPartnerOrganizationMembers   = authUser.can.find(element => element == 'partner-organization-members.show') == 'partner-organization-members.show'
    let canCreatePartnerOrganizationMembers = authUser.can.find(element => element == 'partner-organization-members.create') == 'partner-organization-members.create'
    let canEditPartnerOrganizationMembers   = authUser.can.find(element => element == 'partner-organization-members.edit') == 'partner-organization-members.edit'
    let canDeletePartnerOrganizationMembers = authUser.can.find(element => element == 'partner-organization-members.delete') == 'partner-organization-members.delete'

    let sending = false
    let form = useForm({
        name:               '',
        email:              '',
        document_type:      '',
        document_number:    '',
        cellphone_number:   ''
    })

    function submit() {
        if (canCreatePartnerOrganizationMembers || isSuperAdmin) {
            Inertia.post(route('calls.rdi.partner-organizations.partner-organization-members.store', [call.id, rdi.id, partnerOrganization.id]), $form, {
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
                    {#if canIndexPartnerOrganizationMembers || canCreatePartnerOrganizationMembers || isSuperAdmin}
                        <a use:inertia href={route('calls.rdi.partner-organizations.partner-organization-members.index', [call.id, rdi.id, partnerOrganization.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Partner organization members.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Create')}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" id="name" value="Nombre completo" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="email" value="Correo electrónico" />
                    <Input id="email" type="email" class="mt-1 block w-full" bind:value={$form.email} required />
                    <InputError message={errors.email} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="document_type" value="Tipo de documento" />
                    <Select noOptionsMessage={$_('No data recorded')} items={documentTypes} bind:selectedValue={$form.document_type} autocomplete="off" placeholder="Seleccione un tipo de documento"/>
                    <InputError message={errors.document_type} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="document_number" value="Número de documento" />
                    <Input id="document_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.document_number} required />
                    <InputError message={errors.document_number} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="cellphone_number" value="Número de celular" />
                    <Input id="cellphone_number" type="number" min="0" class="mt-1 block w-full" bind:value={$form.cellphone_number} required />
                    <InputError message={errors.cellphone_number} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreatePartnerOrganizationMembers || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Partner organization members.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
