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
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre.svelte'

    export let errors
    export let academicProgram = {}
    export let studyModes = {}
    export let selectedStudyMode

    $: $title = academicProgram ? academicProgram.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexAcademicPrograms    = authUser.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'
    let canShowAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.show') == 'academic-programs.show'
    let canCreateAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.create') == 'academic-programs.create'
    let canEditAcademicPrograms     = authUser.can.find(element => element == 'academic-programs.edit') == 'academic-programs.edit'
    let canDeleteAcademicPrograms   = authUser.can.find(element => element == 'academic-programs.delete') == 'academic-programs.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:               academicProgram.name,
        code:               academicProgram.code,
        study_mode:         selectedStudyMode,
        academic_centre:    academicProgram.academic_centre_id,
    })

    function submit() {
        if (canEditAcademicPrograms || isSuperAdmin) {
            Inertia.put(route('academic-programs.update', academicProgram.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
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
                    {#if canIndexAcademicPrograms || canEditAcademicPrograms || isSuperAdmin}
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
            <div class="p-8">
                <div class="mt-4">
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label id="code" value="Código" />
                    <Input id="code" type="text" class="mt-1 block w-full" bind:value={$form.code} required />
                    <InputError message={errors.code} />
                </div>

                <div class="mt-4">
                    <Label id="study_mode" value="Modalidad de estudio" />
                    <Select items={studyModes} bind:selectedValue={$form.study_mode} autocomplete="off" placeholder="Seleccione una modalidad de estudio"/>
                    <InputError message={errors.study_mode} />
                </div>

                <div class="mt-4">
                    <Label id="academic_centre" value="Centro de formación" />
                    <DropdownAcademicCentre id="academic_centre" bind:formAcademicCentre={$form.academic_centre} message={errors.academic_centre} />
                    <InputError message={errors.academic_centre} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteAcademicPrograms || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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

