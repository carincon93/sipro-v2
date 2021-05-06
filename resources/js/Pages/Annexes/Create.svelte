<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Textarea from '@/Components/Textarea'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@smui/checkbox'
    import FormField from '@smui/form-field'

    export let errors
    export let programmaticLines

    $: $title = $_('Create') + ' ' + $_('Annexes.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexAnnexes    = authUser.can.find(element => element == 'annexes.index') == 'annexes.index'
    let canShowAnnexes     = authUser.can.find(element => element == 'annexes.show') == 'annexes.show'
    let canCreateAnnexes   = authUser.can.find(element => element == 'annexes.create') == 'annexes.create'
    let canEditAnnexes     = authUser.can.find(element => element == 'annexes.edit') == 'annexes.edit'
    let canDeleteAnnexes   = authUser.can.find(element => element == 'annexes.delete') == 'annexes.delete'

    let sending = false
    let form = useForm({
        name:  '',
        description: '',
        programmatic_line_id: [],
    })

    function submit() {
        if (canCreateAnnexes || isSuperAdmin) {
            Inertia.post(route('annexes.store'), $form, {
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
                    {#if canIndexAnnexes || canCreateAnnexes || isSuperAdmin}
                        <a use:inertia href={route('annexes.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Annexes.plural')}
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
            <fieldset class="p-8" disabled={canCreateAnnexes || isSuperAdmin ? undefined : true}>
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre del anexo" />
                    <Textarea rows="4" id="name" error={errors.name} bind:value={$form.name} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="description" value="Descripción" />
                    <Textarea rows="4" id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="bg-white rounded shadow overflow-hidden mt-20">
                    <div class="grid grid-cols-2">
                        {#each programmaticLines as {id, name, code}, i}
                            <FormField>
                                <Checkbox
                                    bind:group={$form.programmatic_line_id}
                                    value={id}
                                />
                                    <span slot="label">{name} ({code})</span>
                            </FormField>
                        {/each}
                    </div>
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateAnnexes || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Annexes.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>

