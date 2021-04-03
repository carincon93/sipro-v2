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
    import Select from 'svelte-select'

    export let errors
    export let productiveSectors
    export let technicalCommittees

    $: $title = $_('Create') + ' ' + $_('Prioritized topics.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexPrioritizedTopics   = authUser.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'
    let canShowPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.show') == 'prioritized-topics.show'
    let canCreatePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.create') == 'prioritized-topics.create'
    let canEditPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.edit') == 'prioritized-topics.edit'
    let canDeletePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.delete') == 'prioritized-topics.delete'

    let sending = false
    let form = remember({
        name: '',
        technical_committee: '',
        productive_sector: ''
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
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexPrioritizedTopics || canCreatePrioritizedTopics || isSuperAdmin}
            <a use:inertia href={route('prioritized-topics.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Prioritized topics.plural')}
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
                    <Label id="productive_sector" value="Sector productivo" />
                    <Select items={productiveSectors} bind:selectedValue={$form.productive_sector} autocomplete="off" placeholder="Seleccione un sector productivo"/>
                    <InputError message={errors.productive_sector} />
                </div>

                <div class="mt-4">
                    <Label id="technical_committee" value="Mesa técnica de servicios tecnológicos" />
                    <Select items={technicalCommittees} bind:selectedValue={$form.technical_committee} autocomplete="off" placeholder="Seleccione una mesta técnica de servicios tecnológicos"/>
                    <InputError message={errors.technical_committee} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreatePrioritizedTopics || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Prioritized topics.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
