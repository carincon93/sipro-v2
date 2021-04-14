<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { Inertia } from '@inertiajs/inertia'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import LoadingButton from '@/Components/LoadingButton'
    import File from '@/Components/File.svelte'

    import Stepper from '@/Components/Stepper.svelte';

    export let call
    export let project
    export let projectAnnexes = []

    export let annexes

    $title = $_('Project annexes.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectAnnexes     = authUser.can.find(element => element == 'project-annexes.index') == 'project-annexes.index'
    let canShowProjectAnnexes      = authUser.can.find(element => element == 'project-annexes.show') == 'project-annexes.show'
    let canCreateProjectAnnexes    = authUser.can.find(element => element == 'project-annexes.create') == 'project-annexes.create'
    let canEditProjectAnnexes      = authUser.can.find(element => element == 'project-annexes.edit') == 'project-annexes.edit'
    let canDeleteProjectAnnexes    = authUser.can.find(element => element == 'project-annexes.delete') == 'project-annexes.delete'

    let filters = {}

    let sending = false
    function submit(e) {
        if (canCreateProjectAnnexes || isSuperAdmin) {
            let formData = new FormData(e.target)

            Inertia.post(route('calls.projects.project-annexes.store', [call.id, project.id]), formData, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <h1 class="font-bold text-3xl m-24 text-center">{$_('Project annexes.plural')}</h1>
    <div class="bg-white rounded shadow ">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white">Archivo</th>
                </tr>
            </thead>
            <tbody>
                {#each annexes.data as annexe (annexe.id)}
                    <tr>
                        <td class="border-t">
                            {#if canCreateProjectAnnexes || canEditProjectAnnexes || isSuperAdmin}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {annexe.name}
                                </p>
                            {/if}
                        </td>
                        <td class="border-t">
                            {#if canCreateProjectAnnexes || canEditProjectAnnexes || isSuperAdmin}
                                <form on:submit|preventDefault={(e) => submit(e)} class="mt-4 p-4">
                                    <input type="hidden" name="annexe_id" value={annexe.id}>
                                    <div>
                                        <File id="file" type="file" name="file" accept="application/pdf" class="mt-1 block w-full" required />
                                        {#if projectAnnexes.data.filter(function(i) { return i.annexe_id == annexe.id}).length > 0 }
                                            <a target="_blank" class="text-indigo-400 underline inline-block mt-4" download href={route('calls.projects.project-annexes.download', [call.id, project.id, projectAnnexes.data.filter(function(i) { return i.annexe_id == annexe.id})[0].id])}>{projectAnnexes.data.filter(function(i) { return i.annexe_id == annexe.id})[0].name}</a>
                                        {/if}
                                    </div>
                                    <div class="px-8 py-4 flex items-center">
                                        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                                            {$_('Upload')}
                                        </LoadingButton>
                                    </div>
                                </form>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if annexes.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={annexes.links} />
</AuthenticatedLayout>
