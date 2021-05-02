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
    import DropdownResearchGroup from '@/Dropdowns/DropdownResearchGroup'

    export let errors
    export let researchLine

    $: $title = researchLine ? researchLine.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchLines   = authUser.can.find(element => element == 'research-lines.index') == 'research-lines.index'
    let canShowResearchLines    = authUser.can.find(element => element == 'research-lines.show') == 'research-lines.show'
    let canCreateResearchLines  = authUser.can.find(element => element == 'research-lines.create') == 'research-lines.create'
    let canEditResearchLines    = authUser.can.find(element => element == 'research-lines.edit') == 'research-lines.edit'
    let canDeleteResearchLines  = authUser.can.find(element => element == 'research-lines.delete') == 'research-lines.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   researchLine.name,
        research_group_id: researchLine.research_group_id,

    })

    function submit() {
        if (canEditResearchLines || isSuperAdmin) {
            Inertia.put(route('research-lines.update', researchLine.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteResearchLines || isSuperAdmin) {
            Inertia.delete(route('research-lines.destroy', researchLine.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexResearchLines || canEditResearchLines || isSuperAdmin}
                        <a use:inertia href={route('research-lines.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Research lines.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {researchLine.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="research_group_id" value="Grupo de investigación" />
                    <DropdownResearchGroup id="research_group_id" bind:formResearchGroup={$form.research_group_id} message={errors.research_group_id} />
                    <InputError message={errors.research_group_id} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteResearchLines || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Research lines.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditResearchLines || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Research lines.singular')}
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
