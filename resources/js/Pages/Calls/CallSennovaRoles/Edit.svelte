<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'

    export let call
    export let callSennovaRole
    export let selectedSennovaRoleValue
    export let sennovaRoles = []
    export let errors

    $: $title = callSennovaRole ? callSennovaRole.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.index') == 'call-sennova-roles.index'
    let canShowCallSennovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.show') == 'call-sennova-roles.show'
    let canCreateCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.create') == 'call-sennova-roles.create'
    let canEditCallSennovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.edit') == 'call-sennova-roles.edit'
    let canDeleteCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.delete') == 'call-sennova-roles.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        salary: callSennovaRole.salary,
        qty_months: callSennovaRole.qty_months,
        sennova_role_id: selectedSennovaRoleValue
    })

    function submit() {
        if (canEditCallSennovaRoles || isSuperAdmin) {
            Inertia.put(route('calls.call-sennova-roles.update', [call.id, callSennovaRole.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteCallSennovaRoles || isSuperAdmin) {
            Inertia.delete(route('calls.call-sennova-roles.destroy', [call.id, callSennovaRole.id]))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexCallSennovaRoles || canEditCallSennovaRoles || isSuperAdmin}
                        <a use:inertia href={route('calls.call-sennova-roles.index', call.id)} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Call sennova roles.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {callSennovaRole.sennova_role.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="sennova_role_id" value={$_('Call sennova roles.singular')} />
                    <Select items={sennovaRoles} bind:selectedValue={$form.sennova_role_id} autocomplete="off" placeholder="Seleccione un rol SENNOVA"/>
                    <InputError message={errors.sennova_role_id} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="salary" value="Asignación mensual" />
                    <Input id="salary" type="number" min="0" class="mt-1 block w-full" bind:value={$form.salary} required autofocus />
                    <InputError message={errors.salary} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="qty_months" value="Número de meses que requiere el apoyo" />
                    <Input id="qty_months" type="number" min="0" class="mt-1 block w-full" bind:value={$form.qty_months} required autofocus />
                    <InputError message={errors.qty_months} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="qty_roles" value="Número de personas requeridas" />
                    <Input id="qty_roles" type="number" min="0" class="mt-1 block w-full" bind:value={$form.qty_roles} required autofocus />
                    <InputError message={errors.qty_roles} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteCallSennovaRoles || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Call sennova roles.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditCallSennovaRoles || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Call sennova roles.singular')}
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
    </div>
</AuthenticatedLayout>
