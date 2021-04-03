<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page} from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownResearchLine from '@/Dropdowns/DropdownResearchLine'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Research teams.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchTeams   = authUser.can.find(element => element == 'research-teams.index') == 'research-teams.index'
    let canShowResearchTeams    = authUser.can.find(element => element == 'research-teams.show') == 'research-teams.show'
    let canCreateResearchTeams  = authUser.can.find(element => element == 'research-teams.create') == 'research-teams.create'
    let canEditResearchTeams    = authUser.can.find(element => element == 'research-teams.edit') == 'research-teams.edit'
    let canDeleteResearchTeams  = authUser.can.find(element => element == 'research-teams.delete') == 'research-teams.delete'

    let sending = false
    let form = remember({
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
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexResearchTeams || canCreateResearchTeams || isSuperAdmin}
            <a use:inertia href={route('research-teams.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Research teams.plural')}
            </a>
        {/if}
        <span class="text-indigo-400 font-medium">/</span>
        {$_('Create')}
    </h1>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label id="research_line_id" value="Línea de investigación" />
                    <DropdownResearchLine id="research_line_id" bind:formResearchLine={$form.research_line_id} message={errors.research_line_id} />
                    <InputError message={errors.research_line} />
                </div>

            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateResearchTeams || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Research teams.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
