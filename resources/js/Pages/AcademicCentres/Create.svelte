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

    $: $title =
        $_('Create') + ' ' + $_('Academic centres.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canIndexAcademicCentres =
        authUser.can.find((element) => element == 'academic-centres.index') ==
        'academic-centres.index'
    let canShowAcademicCentres =
        authUser.can.find((element) => element == 'academic-centres.show') ==
        'academic-centres.show'
    let canCreateAcademicCentres =
        authUser.can.find((element) => element == 'academic-centres.create') ==
        'academic-centres.create'
    let canEditAcademicCentres =
        authUser.can.find((element) => element == 'academic-centres.edit') ==
        'academic-centres.edit'
    let canDeleteAcademicCentres =
        authUser.can.find((element) => element == 'academic-centres.delete') ==
        'academic-centres.delete'

    let sending = false
    let form = useForm({
        name: '',
        code: '',
        regional_id: null,
    })

    function submit() {
        if (canCreateAcademicCentres || isSuperAdmin) {
            $form.post(route('academic-centres.store'), {
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
                    {#if canIndexAcademicCentres || canCreateAcademicCentres || isSuperAdmin}
                        <a
                            use:inertia
                            href={route('academic-centres.index')}
                            class="text-indigo-400 hover:text-indigo-600"
                        >
                            {$_('Academic centres.plural')}
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
                disabled={canCreateAcademicCentres || isSuperAdmin
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
                        labelFor="regional_id"
                        value="Regional"
                    />
                    <DynamicList
                        id="regional_id"
                        bind:value={$form.regional_id}
                        routeWebApi={route('web-api.regional')}
                        placeholder="Busque por el nombre del centro de formación"
                        message={errors.regional_id}
                        required
                    />
                </div>
            </fieldset>
            <div
                class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0"
            >
                {#if canCreateAcademicCentres || isSuperAdmin}
                    <LoadingButton
                        loading={sending}
                        class="btn-indigo ml-auto"
                        type="submit"
                    >
                        {$_('Create')}
                        {$_('Academic centres.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
