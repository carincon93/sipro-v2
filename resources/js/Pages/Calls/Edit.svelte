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
    import Textarea from '@/Components/Textarea'
    import Switch from '@/Components/Switch'

    export let errors
    export let call   = {}

    $: $title = call ? $_('Calls.singular') + ' ' +  call.year : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexCalls   = authUser.can.find(element => element == 'calls.index') == 'calls.index'
    let canShowCalls    = authUser.can.find(element => element == 'calls.show') == 'calls.show'
    let canCreateCalls  = authUser.can.find(element => element == 'calls.create') == 'calls.create'
    let canEditCalls    = authUser.can.find(element => element == 'calls.edit') == 'calls.edit'
    let canDeleteCalls  = authUser.can.find(element => element == 'calls.delete') == 'calls.delete'


    let canIndexCallSenovaRoles   = authUser.can.find(element => element == 'call-sennova-roles.index') == 'call-sennova-roles.index'
    let canShowCallSenovaRoles    = authUser.can.find(element => element == 'call-sennova-roles.show') == 'call-sennova-roles.show'
    let canCreateCallSenovaRoles  = authUser.can.find(element => element == 'call-sennova-roles.create') == 'call-sennova-roles.create'
    let canEditCallSenovaRoles    = authUser.can.find(element => element == 'call-sennova-roles.edit') == 'call-sennova-roles.edit'
    let canDeleteCallSenovaRoles  = authUser.can.find(element => element == 'call-sennova-roles.delete') == 'call-sennova-roles.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        description: call.description,
        project_start_date: call.project_start_date,
        project_end_date: call.project_end_date,
        active: call.active,
        start_date: call.start_date,
        end_date: call.end_date
    })

    function submit() {
        if (canEditCalls || isSuperAdmin) {
            Inertia.put(route('calls.update', call.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteCalls || isSuperAdmin) {
            Inertia.delete(route('calls.destroy', call.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexCalls || canEditCalls || isSuperAdmin}
                        <a use:inertia href={route('calls.index', call.id)} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Calls.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Calls.singular')} {call.year}
                </h1>
            </div>
        </div>
    </header>

    {#if canIndexCallSenovaRoles || canShowCallSenovaRoles || canCreateCallSenovaRoles || canEditCallSenovaRoles || canDeleteCallSenovaRoles || isSuperAdmin}
        <a use:inertia href={route('calls.call-sennova-roles.index', call.id)} class="bg-indigo-600 hover:bg-indigo-500 inline-block mt-4 overflow-hidden px-6 py-2 shadow-sm sm:rounded-lg text-white transition-colors">
            {$_('Call sennova roles.plural')}
        </a>
    {/if}
    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <p class="text-center">Fecha de la conovicatoria</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={$form.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={$form.end_date} required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label id="active" value="Desea activar está convocatoria?" class="inline-block mb-4" />
                    <br>
                    <Switch bind:checked={$form.active} />
                    <InputError message={errors.active} />
                </div>

                <div class="mt-4">
                    <p class="text-center">Fecha de ejecución de proyectos</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.project_start_date ? '' : 'items-center'}">
                            <Label id="project_start_date" class="{errors.project_start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="project_start_date" type="date" class="mt-1 block w-full" error={errors.project_start_date} bind:value={$form.project_start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.project_end_date ? '' : 'items-center'}">
                            <Label id="project_end_date" class="{errors.project_end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="project_end_date" type="date" class="mt-1 block w-full" error={errors.project_end_date} bind:value={$form.project_end_date} required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteCalls || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Calls.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditCalls || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Calls.singular')}
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
