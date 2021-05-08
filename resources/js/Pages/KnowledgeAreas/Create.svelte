<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'

    export let errors

    $: $title =
        $_('Create') + ' ' + $_('Knowledge areas.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canIndexKnowledgeAreas =
        authUser.can.find((element) => element == 'knowledge-areas.index') ==
        'knowledge-areas.index'
    let canShowKnowledgeAreas =
        authUser.can.find((element) => element == 'knowledge-areas.show') ==
        'knowledge-areas.show'
    let canCreateKnowledgeAreas =
        authUser.can.find((element) => element == 'knowledge-areas.create') ==
        'knowledge-areas.create'
    let canEditKnowledgeAreas =
        authUser.can.find((element) => element == 'knowledge-areas.edit') ==
        'knowledge-areas.edit'
    let canDeleteKnowledgeAreas =
        authUser.can.find((element) => element == 'knowledge-areas.delete') ==
        'knowledge-areas.delete'

    let sending = false
    let form = useForm({
        name: '',
    })

    function submit() {
        if (canCreateKnowledgeAreas || isSuperAdmin) {
            $form.post(route('knowledge-areas.store'), {
                onStart: () => (sending = true),
                onFinish: () => (sending = false),
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div
            class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6"
        >
            <div>
                <h1>
                    {#if canIndexKnowledgeAreas || canCreateKnowledgeAreas || isSuperAdmin}
                        <a
                            use:inertia
                            href={route('knowledge-areas.index')}
                            class="text-indigo-400 hover:text-indigo-600"
                        >
                            {$_('Knowledge areas.plural')}
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
            <fieldset
                class="p-8"
                disabled={canCreateKnowledgeAreas || isSuperAdmin
                    ? undefined
                    : true}
            >
                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="name"
                        value="Nombre"
                    />
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$form.name}
                        error={errors.name}
                        required
                    />
                </div>
            </fieldset>
            <div
                class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0"
            >
                {#if canCreateKnowledgeAreas || isSuperAdmin}
                    <LoadingButton
                        loading={sending}
                        class="btn-indigo ml-auto"
                        type="submit"
                    >
                        {$_('Create')}
                        {$_('Knowledge areas.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
