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
    import DynamicList from '@/Dropdowns/DynamicList'

    export let errors
    export let researchTeam

    $: $title = researchTeam ? researchTeam.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchTeams   = authUser.can.find(element => element == 'research-teams.index') == 'research-teams.index'
    let canShowResearchTeams    = authUser.can.find(element => element == 'research-teams.show') == 'research-teams.show'
    let canCreateResearchTeams  = authUser.can.find(element => element == 'research-teams.create') == 'research-teams.create'
    let canEditResearchTeams    = authUser.can.find(element => element == 'research-teams.edit') == 'research-teams.edit'
    let canDeleteResearchTeams  = authUser.can.find(element => element == 'research-teams.delete') == 'research-teams.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   researchTeam.name,
        research_line_id: researchTeam.research_line_id,

    })

    function submit() {
        if (canEditResearchTeams || isSuperAdmin) {
            Inertia.put(route('research-teams.update', researchTeam.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteResearchTeam || isSuperAdmin) {
            Inertia.delete(route('research-teams.destroy', researchTeam.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexResearchTeams || canEditResearchTeams || isSuperAdmin}
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
            <div class="p-8">
                <div class="mt-4">
                    <Label required id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required id="research_line_id" value="Línea de investigación" />
                    <DynamicList id="research_line_id" bind:value={$form.research_line_id} routeWebApi={route('web-api.research-lines')} placeholder="Busque por el nombre de la línea de investigación, centro de formación, grupo de investigación o regional" message={errors.research_line_id} required/>
                    <InputError message={errors.research_line} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteResearchTeams || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
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
