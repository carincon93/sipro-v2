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

    export let errors
    export let strategicThematic = {}

    $: $title = strategicThematic ? strategicThematic.name : null

    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexStrategicThematics  = authUser.can.find(element => element == 'strategic-thematics.index') == 'strategic-thematics.index'
    let canShowStrategicThematics   = authUser.can.find(element => element == 'strategic-thematics.show') == 'strategic-thematics.show'
    let canCreateStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.create') == 'strategic-thematics.create'
    let canEditStrategicThematics   = authUser.can.find(element => element == 'strategic-thematics.edit') == 'strategic-thematics.edit'
    let canDeleteStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.destroy') == 'strategic-thematics.destroy'

    let modal_open = false
    let sending = false
    let form = remember({
        name: strategicThematic.name,
    })

    function submit() {
        if (canEditStrategicThematics || isSuperAdmin) {
            Inertia.put(route('strategic-thematics.update', strategicThematic.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteStrategicThematics || isSuperAdmin) {
            Inertia.delete(route('strategic-thematics.destroy', strategicThematic.id))
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexStrategicThematics || canEditStrategicThematics || isSuperAdmin}
            <a use:inertia href={route('strategic-thematics.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Strategic thematics.plural')}
            </a>
        {/if}
        <span class="text-indigo-400 font-medium">/</span>
        {strategicThematic.name}
    </h1>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteStrategicThematics || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Strategic thematics.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditStrategicThematics || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Strategic thematics.singular')}
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
