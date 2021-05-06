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

    export let errors
    export let productiveSectors
    export let technicalCommittees

    $: $title = $_('Create') + ' ' + $_('Prioritized topics.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexPrioritizedTopics   = authUser.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'
    let canShowPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.show') == 'prioritized-topics.show'
    let canCreatePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.create') == 'prioritized-topics.create'
    let canEditPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.edit') == 'prioritized-topics.edit'
    let canDeletePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.delete') == 'prioritized-topics.delete'

    let sending = false
    let form = useForm({
        name:                   '',
        technical_committee_id: '',
        productive_sector_id:   ''
    })

    function submit() {
        if (canCreatePrioritizedTopics || isSuperAdmin) {
            Inertia.post(route('prioritized-topics.store'), $form, {
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
                    {#if canIndexPrioritizedTopics || canCreatePrioritizedTopics || isSuperAdmin}
                        <a use:inertia href={route('prioritized-topics.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Prioritized topics.plural')}
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
            <fieldset class="p-8" disabled={canCreatePrioritizedTopics || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required  />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="productive_sector_id" value="Sector productivo" />
                    <Select id="productive_sector_id" items={productiveSectors} bind:selectedValue={$form.productive_sector_id} error={errors.productive_sector_id} autocomplete="off" placeholder="Seleccione un sector productivo" required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="technical_committee_id" value="Mesa técnica de servicios tecnológicos" />
                    <Select id="technical_committee_id" items={technicalCommittees} bind:selectedValue={$form.technical_committee_id} error={errors.technical_committee_id} autocomplete="off" placeholder="Seleccione una mesta técnica de servicios tecnológicos" required />
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreatePrioritizedTopics || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Prioritized topics.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
