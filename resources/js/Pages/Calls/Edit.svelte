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
    import Button from '@/Components/Button'
    import LoadingButton from '@/Components/LoadingButton'
    import Textarea from '@/Components/Textarea'
    import Switch from '@/Components/Switch'

    export let errors
    export let call   = {}

    $: $title = call ? $_('Calls.singular') + ' ' +  call.year : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
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

    let dialog_open = false
    let sending = false
    let form = useForm({
        description:        call.description,
        project_start_date: call.project_start_date,
        project_end_date:   call.project_end_date,
        active:             call.active,
        start_date:         call.start_date,
        end_date:           call.end_date
    })

    function submit() {
        if (canEditCalls || isSuperAdmin) {
            Inertia.put(route('calls.update', call.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    let values = {
        password: ''
    }

    function destroy() {
        if (canDeleteCalls || isSuperAdmin) {
            Inertia.visit(route('calls.destroy', [call.id]), {
                method: 'DELETE',
                data: values,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexCalls || canShowCalls || canEditCalls || canDeleteCalls || isSuperAdmin}
                        <a use:inertia href={route('calls.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Calls.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    <a use:inertia href={route('calls.dashboard', call.id)} class="text-indigo-400 hover:text-indigo-600">
                        {$_('Calls.singular')} {call.year}
                    </a>
                </h1>
            </div>
        </div>
    </header>

    {#if canIndexCallSenovaRoles || canShowCallSenovaRoles || canCreateCallSenovaRoles || canEditCallSenovaRoles || canDeleteCallSenovaRoles || isSuperAdmin}
        <Button variant="raised" on:click={() => Inertia.visit(route('calls.call-sennova-roles.index', call.id))} class="mb-4">
            {$_('Call sennova roles.plural')}
        </Button>
    {/if}
    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset class="p-8" disabled={canEditCalls || isSuperAdmin ? undefined : true}>
                <div class="mt-4 mb-20">
                    <p class="text-center">Fecha de la conovicatoria</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label required labelFor="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" bind:value={$form.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label required labelFor="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" bind:value={$form.end_date} required />
                            </div>
                        </div>
                    </div>
                </div>
                {#if errors.start_date || errors.end_date}
                    <InputError message={errors.start_date || errors.end_date} />
                {/if}

                <hr>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="description" value="Descripción" />
                    <Textarea rows="4" id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4 mb-20">
                    <Label required labelFor="active" value="Desea activar está convocatoria?" class="inline-block mb-4" />
                    <br>
                    <Switch bind:checked={$form.active} />
                    <InputError message={errors.active} />
                </div>

                <hr>

                <div class="mt-4">
                    <p class="text-center">Fecha de ejecución de proyectos</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.project_start_date ? '' : 'items-center'}">
                            <Label required labelFor="project_start_date" class="{errors.project_start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="project_start_date" type="date" class="mt-1 block w-full" bind:value={$form.project_start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.project_end_date ? '' : 'items-center'}">
                            <Label required labelFor="project_end_date" class="{errors.project_end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="project_end_date" type="date" class="mt-1 block w-full" bind:value={$form.project_end_date} required />
                            </div>
                        </div>
                    </div>
                </div>
                {#if errors.project_start_date || errors.project_end_date}
                    <InputError message={errors.project_start_date || errors.project_end_date} />
                {/if}
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteCalls || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
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
    </div>
    <Dialog bind:open={dialog_open}>
        <div slot="title" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Eliminar recurso
        </div>
        <div slot="content">
            <p>
                ¿Está seguro (a) que desea eliminar esta convocatoria?
                <br>
                Una vez eliminada la convocatoria, todos sus los proyectos y datos asociados se eliminarán de forma permanente.
            </p>

            <form on:submit|preventDefault={destroy} id="delete-rdi" class="mt-20 mb-28">
                <Label for="password" value="Ingrese su contraseña para confirmar que desea eliminar permanentemente esta convocatoria." />
                <Input id="password" type="password" class="mt-1 block w-full" error={errors.password} placeholder="Escriba su contraseña" bind:value={values.password} required />
            </form>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button on:click={event => dialog_open = false} variant={null}>{$_('Cancel')}</Button>
                <Button variant="raised" form="delete-rdi">
                    {$_('Confirm')}
                </Button>
            </div>
        </div>
    </Dialog>
</AuthenticatedLayout>
