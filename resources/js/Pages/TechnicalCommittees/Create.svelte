<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Technical committees.singular').toLowerCase()

    let authUser = $page.props.auth.user
    let isSuperAdmin                 = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexTechnicalCommittees  = authUser.can.find(element => element == 'technical-committees.index') == 'technical-committees.index'
    let canShowTechnicalCommittees   = authUser.can.find(element => element == 'technical-committees.show') == 'technical-committees.show'
    let canCreateTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.create') == 'technical-committees.create'
    let canEditTechnicalCommittees   = authUser.can.find(element => element == 'technical-committees.edit') == 'technical-committees.edit'
    let canDeleteTechnicalCommittees = authUser.can.find(element => element == 'technical-committees.delete') == 'technical-committees.delete'

    let sending = false
    let form = useForm({
        name: '',
    })

    function submit() {
        if (canCreateTechnicalCommittees || isSuperAdmin) {
                Inertia.post(route('technical-committees.store'), $form, {
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
                    {#if canIndexTechnicalCommittees || canCreateTechnicalCommittees || isSuperAdmin}
                        <a use:inertia href={route('technical-committees.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Technical committees.plural')}
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
            <fieldset class="p-8" disabled={canCreateTechnicalCommittees || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} error={errors.name} required  />
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateTechnicalCommittees || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Technical committees.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
