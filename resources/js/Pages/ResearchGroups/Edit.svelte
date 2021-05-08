<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import Button from '@/Components/Button'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from '@/Components/Select'
    import DynamicList from '@/Dropdowns/DynamicList'
    import Dialog from '@/Components/Dialog'

    export let errors
    export let researchGroup
    export let mincienciasCategories

    $: $title = researchGroup ? researchGroup.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canIndexResearchGroups =
        authUser.can.find((element) => element == 'research-groups.index') ==
        'research-groups.index'
    let canShowResearchGroups =
        authUser.can.find((element) => element == 'research-groups.show') ==
        'research-groups.show'
    let canCreateResearchGroups =
        authUser.can.find((element) => element == 'research-groups.create') ==
        'research-groups.create'
    let canEditResearchGroups =
        authUser.can.find((element) => element == 'research-groups.edit') ==
        'research-groups.edit'
    let canDeleteResearchGroups =
        authUser.can.find((element) => element == 'research-groups.delete') ==
        'research-groups.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        name: researchGroup.name,
        acronym: researchGroup.acronym,
        email: researchGroup.email,
        gruplac_link: researchGroup.gruplac_link,
        minciencias_code: researchGroup.minciencias_code,
        minciencias_category: {
            value: researchGroup.minciencias_category,
            label: mincienciasCategories.find(
                (item) => item.value == researchGroup.minciencias_category,
            )?.label,
        },
        academic_centre_id: researchGroup.academic_centre_id,
    })

    function submit() {
        if (canEditResearchGroups || isSuperAdmin) {
            $form.put(route('research-groups.update', researchGroup.id), {
                onStart: () => (sending = true),
                onFinish: () => (sending = false),
                preserveScroll: true,
            })
        }
    }

    function destroy() {
        if (canDeleteResearchGroups || isSuperAdmin) {
            $form.delete(route('research-groups.destroy', researchGroup.id))
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
                    {#if canShowResearchGroups || canEditResearchGroups || canDeleteResearchGroups || isSuperAdmin}
                        <a
                            use:inertia
                            href={route('research-groups.index')}
                            class="text-indigo-400 hover:text-indigo-600"
                        >
                            {$_('Research groups.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {researchGroup.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset
                class="p-8"
                disabled={canEditResearchGroups || isSuperAdmin
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
                        labelFor="acronym"
                        value="Acrónimo"
                    />
                    <Input
                        id="acronym"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$form.acronym}
                        error={errors.acronym}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="email"
                        value="Correo electrónico"
                    />
                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        bind:value={$form.email}
                        error={errors.email}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="gruplac_link"
                        value="Enlace GrupLac"
                    />
                    <Input
                        id="gruplac_link"
                        type="url"
                        class="mt-1 block w-full"
                        bind:value={$form.gruplac_link}
                        error={errors.gruplac_link}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="minciencias_code"
                        value="Código Minciencias"
                    />
                    <Input
                        id="minciencias_code"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$form.minciencias_code}
                        error={errors.minciencias_code}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="minciencias_category"
                        value="Categoría Minciencias"
                    />
                    <Select
                        id="minciencias_category"
                        items={mincienciasCategories}
                        bind:selectedValue={$form.minciencias_category}
                        error={errors.minciencias_category}
                        autocomplete="off"
                        placeholder="Seleccione una categoría Minciencias"
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="academic_centre_id"
                        value="Centro de formación"
                    />
                    <DynamicList
                        id="academic_centre_id"
                        bind:value={$form.academic_centre_id}
                        routeWebApi={route('web-api.academic-centres')}
                        placeholder="Busque por el nombre del centro de formación"
                        message={errors.academic_centre_id}
                        required
                    />
                </div>
            </fieldset>
            <div
                class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0"
            >
                {#if canDeleteResearchGroups || isSuperAdmin}
                    <button
                        class="text-red-600 hover:underline text-left"
                        tabindex="-1"
                        type="button"
                        on:click={(event) => (dialog_open = true)}
                    >
                        {$_('Delete')}
                        {$_('Research groups.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditResearchGroups || isSuperAdmin}
                    <LoadingButton
                        loading={sending}
                        class="btn-indigo ml-auto"
                        type="submit"
                    >
                        {$_('Update')}
                        {$_('Research groups.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
    <Dialog bind:open={dialog_open}>
        <div slot="title" class="flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 mr-2 text-red-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
            </svg>
            Eliminar recurso
        </div>
        <div slot="content">
            <p>
                ¿Está seguro(a) que desea eliminar este recurso?
                <br />
                Todos los datos se eliminarán de forma permanente.
                <br />
                Está acción no se puede deshacer.
            </p>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button
                    on:click={(event) => (dialog_open = false)}
                    variant={null}>{$_('Cancel')}</Button
                >
                <Button variant="raised" on:click={destroy}>
                    {$_('Confirm')}
                </Button>
            </div>
        </div>
    </Dialog>
</AuthenticatedLayout>
