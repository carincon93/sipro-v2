<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
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

    export let errors
    export let academicProgram = {}
    export let academicCentres = {}
    export let studyModes = {}
    export let selectedAcademicCentre
    export let selectedStudyMode

    $: $title = academicProgram ? academicProgram.name : null

    let canUpdateAcademicProgram = $page.props.auth.user.can.find(element => element == 'academic-programs.edit') == 'academic-programs.edit'
    let canDeleteAcademicProgram = $page.props.auth.user.can.find(element => element == 'academic-programs.delete') == 'academic-programs.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:               academicProgram.name,
        code:               academicProgram.code,
        study_mode:         selectedStudyMode,
        academic_centre:    selectedAcademicCentre,
    })

    function submit() {
        if (canUpdateAcademicProgram) {
            Inertia.put(route('academic-programs.update', academicProgram.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteAcademicProgram) {
            Inertia.delete(route('academic-programs.destroy', academicProgram.id))
        }
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('academic-programs.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Academic programs.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {academicProgram.name}
</h1>

<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
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
                <Select items={academicCentres} bind:selectedValue={$form.academic_centre} autocomplete="off" placeholder="Seleccione el centro de formación"/>
                <InputError message={errors.academic_centre} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteAcademicProgram}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')} {$_('Academic programs.singular').toLowerCase()}
                </button>
            {/if}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Update')} {$_('Academic programs.singular')}
            </LoadingButton>
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
