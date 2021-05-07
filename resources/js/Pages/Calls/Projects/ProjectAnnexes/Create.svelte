<script>
    import { useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import LoadingButton from '@/Components/LoadingButton'
    import File from '@/Components/File'

    export let errors
    export let call
    export let project
    export let annexe
    export let projectAnnexes
    export let sending = false

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin        = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexProjectAnnexes     = authUser.can.find(element => element == 'project-annexes.index') == 'project-annexes.index'
    let canShowProjectAnnexes      = authUser.can.find(element => element == 'project-annexes.show') == 'project-annexes.show'
    let canCreateProjectAnnexes    = authUser.can.find(element => element == 'project-annexes.create') == 'project-annexes.create'
    let canEditProjectAnnexes      = authUser.can.find(element => element == 'project-annexes.edit') == 'project-annexes.edit'
    let canDeleteProjectAnnexes    = authUser.can.find(element => element == 'project-annexes.delete') == 'project-annexes.delete'

    let form = useForm({
        file:       null,
        annexe_id:  annexe.id,
    })

    function submit() {
        if (canCreateProjectAnnexes && !sending || canEditProjectAnnexes && !sending || isSuperAdmin && !sending) {
            $form.post(route('calls.projects.project-annexes.store', [call.id, project.id]), {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    console.log(annexe);
</script>

<form on:submit|preventDefault={submit} class="mt-4 p-4">
    {#if projectAnnexes.data.filter(function(i) { return i.annexe_id == annexe.id}).length > 0 }
        <a target="_blank" class="text-indigo-400 underline inline-block mb-4" download href={route('calls.projects.project-annexes.download', [call.id, project.id, annexe.id])}>{annexe.name}</a>
    {/if}
    <fieldset disabled={canCreateProjectAnnexes && !sending || canEditProjectAnnexes && !sending || isSuperAdmin && !sending ? undefined : true}>
        <div>
            <File id="file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.file} error={errors?.file} required />
        </div>
        <div>
            <LoadingButton loading={sending} class="w-full mt-4" type="submit">
                {$_('Upload')} {annexe.name}
            </LoadingButton>
        </div>
        {#if $form.progress}
            <progress value={$form.progress.percentage} max="100" class="mt-4">
                {$form.progress.percentage}%
            </progress>
        {/if}
    </fieldset>
</form>
