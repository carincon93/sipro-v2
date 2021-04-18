<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import DropdownResearchGroup from '@/Dropdowns/DropdownResearchGroup'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Research lines.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchLines   = authUser.can.find(element => element == 'research-lines.index') == 'research-lines.index'
    let canShowResearchLines    = authUser.can.find(element => element == 'research-lines.show') == 'research-lines.show'
    let canCreateResearchLines  = authUser.can.find(element => element == 'research-lines.create') == 'research-lines.create'
    let canEditResearchLines    = authUser.can.find(element => element == 'research-lines.edit') == 'research-lines.edit'
    let canDeleteResearchLines  = authUser.can.find(element => element == 'research-lines.delete') == 'research-lines.delete'

    let sending = false
    let form = remember({
        name: '',
        research_group: '',
    })

    function submit() {
        if (canCreateResearchLines || isSuperAdmin) {
            Inertia.post(route('research-lines.store'), $form, {
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
                    {#if canIndexResearchLines || canCreateResearchLines || isSuperAdmin}
                        <a use:inertia href={route('research-lines.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Research lines.plural')}
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
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label id="research_group_id" value="Grupo de investigación" />
                    <DropdownResearchGroup id="research_group_id" bind:formResearchGroup={$form.research_group_id} message={errors.research_group_id} />
                    <InputError message={errors.research_group_id} />
                </div>

            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateResearchLines || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Research lines.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
