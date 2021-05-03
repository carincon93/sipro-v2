<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Textarea from '@/Components/Textarea'
    import Switch from '@/Components/Switch'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Calls.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin   = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexCalls  = authUser.can.find(element => element == 'calls.index') == 'calls.index'
    let canShowCalls   = authUser.can.find(element => element == 'calls.show') == 'calls.show'
    let canCreateCalls = authUser.can.find(element => element == 'calls.create') == 'calls.create'
    let canEditCalls   = authUser.can.find(element => element == 'calls.edit') == 'calls.edit'
    let canDeleteCalls = authUser.can.find(element => element == 'calls.delete') == 'calls.delete'

    let sending = false
    let form = remember({
        description: '',
        project_start_date: '',
        project_end_date: '',
        active: '',
        start_date: '',
        end_date: ''
    })

    function submit() {
        if (canCreateCalls || isSuperAdmin) {
            Inertia.post(route('calls.store'), $form, {
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
                    {#if canIndexCalls || canCreateCalls || isSuperAdmin}
                        <a use:inertia href={route('calls.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Calls.plural')}
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
                    <p class="text-center">Fecha de la conovicatoria</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label required id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={$form.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label required id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={$form.end_date} required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label required id="active" value="Desea activar está convocatoria?" class="inline-block mb-4" />
                    <br>
                    <Switch bind:checked={$form.active} />
                    <InputError message={errors.active} />
                </div>

                <div class="mt-4">
                    <p class="text-center">Fecha de ejecución de proyectos</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.project_start_date ? '' : 'items-center'}">
                            <Label required id="project_start_date" class="{errors.project_start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="project_start_date" type="date" class="mt-1 block w-full" error={errors.project_start_date} bind:value={$form.project_start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.project_end_date ? '' : 'items-center'}">
                            <Label required id="project_end_date" class="{errors.project_end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="project_end_date" type="date" class="mt-1 block w-full" error={errors.project_end_date} bind:value={$form.project_end_date} required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateCalls || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Calls.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
