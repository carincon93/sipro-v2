<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Button from '@/Components/Button'
    import Select from '@/Components/Select'
    import DynamicList from '@/Dropdowns/DynamicList'

    export let errors
    export let academicProgram = {}
    export let studyModes

    $: $title = academicProgram ? academicProgram.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAcademicPrograms    = authUser.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'
    let canShowAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.show') == 'academic-programs.show'
    let canCreateAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.create') == 'academic-programs.create'
    let canEditAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.edit') == 'academic-programs.edit'
    let canDeleteAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.delete') == 'academic-programs.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        name:               academicProgram.name,
        code:               academicProgram.code,
        study_mode:         {value: academicProgram.study_mode, label: studyModes.find(item => item.value == academicProgram.study_mode)?.label},
        academic_centre_id: academicProgram.academic_centre_id,
    })

    function submit() {
        if (canEditAcademicPrograms || isSuperAdmin) {
            Inertia.put(route('academic-programs.update', academicProgram.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true
            })
        }
    }

    function destroy() {
        if (canDeleteAcademicPrograms || isSuperAdmin) {
            Inertia.delete(route('academic-programs.destroy', academicProgram.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexAcademicPrograms || canShowAcademicPrograms || canEditAcademicPrograms || canDeleteAcademicPrograms || isSuperAdmin}
                        <a use:inertia href={route('academic-programs.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Academic programs.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {academicProgram.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset class="p-8" disabled={canEditAcademicPrograms || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required  />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="code" value="Código" />
                    <Input id="code" type="number" min="0" class="mt-1 block w-full" bind:value={$form.code} error={errors.code} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="study_mode" value="Modalidad de estudio" />
                    <Select id="study_mode" items={studyModes} bind:selectedValue={$form.study_mode} error={errors.study_mode} autocomplete="off" placeholder="Seleccione una modalidad de estudio" required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="academic_centre_id" value="Centro de formación" />
                    <DynamicList id="academic_centre_id" bind:value={$form.academic_centre_id} routeWebApi={route('web-api.academic-centres')} placeholder="Busque por el nombre del centro de formación" message={errors.academic_centre_id} required/>
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteAcademicPrograms || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Academic programs.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditAcademicPrograms || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Academic programs.singular')}
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

