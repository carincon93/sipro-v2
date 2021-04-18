<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'
    import File from '@/Components/File'

    export let errors
    export let call
    export let project
    export let annexes = {}

    $: $title = $_('Create') + ' ' + $_('Project annexes.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin               = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectAnnexes     = authUser.can.find(element => element == 'project-annexes.index') == 'project-annexes.index'
    let canShowProjectAnnexes      = authUser.can.find(element => element == 'project-annexes.show') == 'project-annexes.show'
    let canCreateProjectAnnexes    = authUser.can.find(element => element == 'project-annexes.create') == 'project-annexes.create'
    let canEditProjectAnnexes      = authUser.can.find(element => element == 'project-annexes.edit') == 'project-annexes.edit'
    let canDeleteProjectAnnexes    = authUser.can.find(element => element == 'project-annexes.delete') == 'project-annexes.delete'

    let sending = false
    let form = useForm({
        file: '',
        annexe_id: '',
    })

    function submit() {
        if (canCreateProjectAnnexes || isSuperAdmin) {

            let formData = new FormData()
            formData.append('file', $form.file)
            formData.append('annexe_id', $form.annexe_id)

            Inertia.post(route('calls.projects.project-annexes.store', [call.id, project.id]), $form, {
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
                    {#if canIndexProjectAnnexes || canCreateProjectAnnexes || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.project-annexes.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project annexes.plural')}
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
                    <Label id="annexes" value={$_('Annexes.singular')} />
                    <Select items={annexes} bind:selectedValue={$form.annexe_id} autocomplete="off" placeholder="Seleccione el anexo"/>
                    <InputError message={errors.annexes} />
                </div>
                <div class="mt-4">
                    <Label id="file" value="Anexo" />
                    <File id="file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.file} error={errors.file} required />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateProjectAnnexes || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Project annexes.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
