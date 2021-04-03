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
    import Select from 'svelte-select'

    export let errors
    export let prioritizedTopic
    export let productiveSectors
    export let selectedProductiveSector
    export let technicalCommittees
    export let selectedTechnicalCommittee

    $: $title = prioritizedTopic ? prioritizedTopic.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexPrioritizedTopics   = authUser.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'
    let canShowPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.show') == 'prioritized-topics.show'
    let canCreatePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.create') == 'prioritized-topics.create'
    let canEditPrioritizedTopics    = authUser.can.find(element => element == 'prioritized-topics.edit') == 'prioritized-topics.edit'
    let canDeletePrioritizedTopics  = authUser.can.find(element => element == 'prioritized-topics.delete') == 'prioritized-topics.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   prioritizedTopic.name,
        productive_sector: selectedProductiveSector,
        technical_committee: selectedTechnicalCommittee,
    })

    function submit() {
        if (canEditPrioritizedTopics ||isSuperAdmin) {
            Inertia.put(route('prioritized-topics.update', prioritizedTopic.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeletePrioritizedTopics ||isSuperAdmin) {
            Inertia.delete(route('prioritized-topics.destroy', prioritizedTopic.id))
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexPrioritizedTopics || canEditPrioritizedTopics || isSuperAdmin}
            <a use:inertia href={route('prioritized-topics.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Prioritized topics.plural')}
            </a>
        {/if}
        <span class="text-indigo-400 font-medium">/</span>
        {prioritizedTopic.name}
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
                {#if canDeletePrioritizedTopics ||isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Prioritized topics.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canDeletePrioritizedTopics ||isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Prioritized topics.singular')}
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
