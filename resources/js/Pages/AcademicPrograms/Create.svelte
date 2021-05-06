<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from '@/Components/Select'
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre'

    export let errors
    export let studyModes

    $: $title = $_('Create') + ' ' + $_('Academic programs.singular').toLowerCase()

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

    let sending = false
    let form = useForm({
        name:               '',
        code:               '',
        study_mode:         '',
        academic_centre:    '',
    })

    function submit() {
        if (canCreateAcademicPrograms || isSuperAdmin) {
            Inertia.post(route('academic-programs.store'), $form, {
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
                    {#if canIndexAcademicPrograms || canCreateAcademicPrograms || isSuperAdmin}
                        <a use:inertia href={route('academic-programs.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Academic programs.plural')}
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
            <fieldset class="p-8" disabled={canCreateAcademicPrograms || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required  />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="code" value="Código" />
                    <Input id="code" type="text" class="mt-1 block w-full" bind:value={$form.code} error={errors.code} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="study_mode" value="Modalidad de estudio" />
                    <Select id="study_mode" items={studyModes} bind:selectedValue={$form.study_mode} error={errors.study_mode} autocomplete="off" placeholder="Seleccione una modalidad de estudio" required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="academic_centre" value="Centro de formación" />
                    <DropdownAcademicCentre id="academic_centre" bind:formAcademicCentre={$form.academic_centre} message={errors.academic_centre} required />
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateAcademicPrograms || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Academic programs.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>

