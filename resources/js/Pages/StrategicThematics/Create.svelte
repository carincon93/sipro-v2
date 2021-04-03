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

    export let errors

    $: $title = $_('Create') + ' ' + ' ' + $_('Strategic thematics.singular').toLowerCase()

    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexStrategicThematics  = authUser.can.find(element => element == 'strategic-thematics.index') == 'strategic-thematics.index'
    let canShowStrategicThematics   = authUser.can.find(element => element == 'strategic-thematics.show') == 'strategic-thematics.show'
    let canCreateStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.create') == 'strategic-thematics.create'
    let canEditStrategicThematics   = authUser.can.find(element => element == 'strategic-thematics.edit') == 'strategic-thematics.edit'
    let canDeleteStrategicThematics = authUser.can.find(element => element == 'strategic-thematics.destroy') == 'strategic-thematics.destroy'

    let sending = false
    let form = remember({
        name:  '',
    })

    function submit() {
        if (canCreateStrategicThematics || isSuperAdmin) {
            Inertia.post(route('strategic-thematics.store'), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <h1 class="mb-8 font-bold text-3xl">
        {#if canIndexStrategicThematics || canCreateStrategicThematics || isSuperAdmin}
            <a use:inertia href={route('strategic-thematics.index')} class="text-indigo-400 hover:text-indigo-600">
                {$_('Strategic thematics.plural')}
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
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canCreateStrategicThematics}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Strategic thematics.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
