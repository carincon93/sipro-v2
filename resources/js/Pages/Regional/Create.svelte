<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import DynamicList from '@/Dropdowns/DynamicList'

    export let errors

    $: $title = $_('Create') + ' ' + $_('Regional.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canIndexRegional =
        authUser.can.find((element) => element == 'regional.index') ==
        'regional.index'
    let canShowRegional =
        authUser.can.find((element) => element == 'regional.show') ==
        'regional.show'
    let canCreateRegional =
        authUser.can.find((element) => element == 'regional.create') ==
        'regional.create'
    let canEditRegional =
        authUser.can.find((element) => element == 'regional.edit') ==
        'regional.edit'
    let canDeleteRegional =
        authUser.can.find((element) => element == 'regional.delete') ==
        'regional.delete'

    let sending = false
    let form = useForm({
        name: '',
        code: '',
        region_id: null,
        regional_director_id: null,
    })

    function submit() {
        if (canCreateRegional || isSuperAdmin) {
            $form.post(route('regional.store'), {
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
                    {#if canIndexRegional || canCreateRegional || isSuperAdmin}
                        <a
                            use:inertia
                            href={route('regional.index')}
                            class="text-indigo-400 hover:text-indigo-600"
                        >
                            {$_('Regional.plural')}
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
                disabled={canCreateRegional || isSuperAdmin ? undefined : true}
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

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="code"
                        value="Código"
                    />
                    <Input
                        id="code"
                        type="number"
                        min="0"
                        class="mt-1 block w-full"
                        bind:value={$form.code}
                        error={errors.code}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="region_id"
                        value="Región"
                    />
                    <DynamicList
                        id="region_id"
                        bind:value={$form.region_id}
                        routeWebApi={route('web-api.region')}
                        placeholder="Busque por el nombre de la región"
                        message={errors.region_id}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="regional_director_id"
                        value="Director(a) Regional"
                    />
                    <DynamicList
                        id="regional_director_id"
                        bind:value={$form.regional_director_id}
                        routeWebApi={route('web-api.regional-directors')}
                        placeholder="Busque por el nombre del director"
                        message={errors.regional_director_id}
                        required
                    />
                </div>
            </fieldset>
            <div
                class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0"
            >
                {#if canCreateRegional || isSuperAdmin}
                    <LoadingButton
                        loading={sending}
                        class="btn-indigo ml-auto"
                        type="submit"
                    >
                        {$_('Create')}
                        {$_('Regional.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
