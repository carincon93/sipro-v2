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
    import Select from 'svelte-select'

    export let call
    export let callSennovaRole
    export let selectedSennovaRoleValue
    export let sennovaRoles = []
    export let errors

    $: $title = callSennovaRole ? callSennovaRole.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.index') == 'call-sennova-roles.index'
    let canShowCallSennovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.show') == 'call-sennova-roles.show'
    let canCreateCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.create') == 'call-sennova-roles.create'
    let canEditCallSennovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.edit') == 'call-sennova-roles.edit'
    let canDeleteCallSennovaRoles = authUser.can.find(element => element == 'call-sennova-roles.delete') == 'call-sennova-roles.delete'

    let modal_open = false
    let sending = false
    let form = remember({
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
                    <Label id="sennova_role_id" value={$_('Call sennova roles.singular')} />
                    <Select items={sennovaRoles} bind:selectedValue={$form.sennova_role_id} autocomplete="off" placeholder="Seleccione un rol SENNOVA"/>
                    <InputError message={errors.sennova_role_id} />
                </div>

                <div class="mt-4">
                    <Label id="salary" value="Asignación mensual" />
                    <Input id="salary" type="number" min="0" class="mt-1 block w-full" bind:value={$form.salary} required autofocus />
                    <InputError message={errors.salary} />
                </div>

                <div class="mt-4">
                    <Label id="qty_months" value="Número de meses que requiere el apoyo" />
                    <Input id="qty_months" type="number" min="0" class="mt-1 block w-full" bind:value={$form.qty_months} required autofocus />
                    <InputError message={errors.qty_months} />
                </div>

                <div class="mt-4">
                    <Label id="qty_roles" value="Número de personas requeridas" />
                    <Input id="qty_roles" type="number" min="0" class="mt-1 block w-full" bind:value={$form.qty_roles} required autofocus />
                    <InputError message={errors.qty_roles} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteCallSennovaRoles || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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
