<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page} from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import DynamicList from '@/Dropdowns/DynamicList'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Research teams.singular').toLowerCase()

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

    let sending = false
    let form = useForm({
        name: '',
        research_line_id: '',
    })

    function submit() {
        if (canCreateResearchTeams || isSuperAdmin) {
            Inertia.post(route('research-teams.store'), $form, {
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
                    {#if canIndexResearchTeams || canCreateResearchTeams || isSuperAdmin}
                        <a use:inertia href={route('research-teams.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Research teams.plural')}
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
            <fieldset class="p-8" disabled={canCreateResearchTeams || isSuperAdmin ? undefined : true}>
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
                {#if canCreateResearchTeams || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Research teams.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
