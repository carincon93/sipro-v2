<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import Button from '@/Components/Button'
    import LoadingButton from '@/Components/LoadingButton'
    import DynamicList from '@/Dropdowns/DynamicList'

    export let errors
    export let researchTeam

    $: $title = researchTeam ? researchTeam.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexResearchTeams   = authUser.can.find(element => element == 'research-teams.index') == 'research-teams.index'
    let canShowResearchTeams    = authUser.can.find(element => element == 'research-teams.show') == 'research-teams.show'
    let canCreateResearchTeams  = authUser.can.find(element => element == 'research-teams.create') == 'research-teams.create'
    let canEditResearchTeams    = authUser.can.find(element => element == 'research-teams.edit') == 'research-teams.edit'
    let canDeleteResearchTeams  = authUser.can.find(element => element == 'research-teams.delete') == 'research-teams.delete'

    let dialog_open = false
    let sending     = false
    let form = useForm({
        name:               researchTeam.name,
        research_line_id:   researchTeam.research_line_id,
    })

    function submit() {
        if (canEditResearchTeams || isSuperAdmin) {
            Inertia.put(route('research-teams.update', researchTeam.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
                preserveScroll: true

            })
        }
    }

    function destroy() {
        if (canDeleteResearchTeams || isSuperAdmin) {
            Inertia.delete(route('research-teams.destroy', researchTeam.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexResearchTeams || canShowResearchTeams || canEditResearchTeams || canDeleteResearchTeams || isSuperAdmin}
                        <a use:inertia href={route('research-teams.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Research teams.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {researchTeam.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset class="p-8" disabled={canEditResearchTeams || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required  />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="research_line_id" value="Línea de investigación" />
                    <DynamicList id="research_line_id" bind:value={$form.research_line_id} routeWebApi={route('web-api.research-lines')} placeholder="Busque por el nombre de la línea de investigación, centro de formación, grupo de investigación o regional" message={errors.research_line_id} required/>
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteResearchTeams || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Research teams.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditResearchTeams || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Research teams.singular')}
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
