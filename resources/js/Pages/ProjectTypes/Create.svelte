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
    import Select from 'svelte-select'

    export let errors
    export let programmaticLines

    $: $title = $_('Create') + ' ' + $_('Project types.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectTypes    = authUser.can.find(element => element == 'project-types.index') == 'project-types.index'
    let canShowProjectTypes     = authUser.can.find(element => element == 'project-types.show') == 'project-types.show'
    let canCreateProjectTypes   = authUser.can.find(element => element == 'project-types.create') == 'project-types.create'
    let canEditProjectTypes     = authUser.can.find(element => element == 'project-types.edit') == 'project-types.edit'
    let canDeleteProjectTypes   = authUser.can.find(element => element == 'project-types.delete') == 'project-types.delete'

    let sending = false
    let form = remember({
        name: '',
        maximum_value: '',
        programmatic_line: '',
    })

    function submit() {
        Inertia.post(route('project-types.store'), $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProjectTypes || canCreateProjectTypes || isSuperAdmin}
                        <a use:inertia href={route('project-types.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project types.plural')}
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
            <div class="p-8">
                <div class="mt-4">
                    <Label required id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required id="maximum_value" value="Valor máximo" />
                    <Input id="maximum_value" type="number" min="0" class="mt-1 block w-full" bind:value={$form.maximum_value} required autofocus />
                    <InputError message={errors.maximum_value} />
                </div>

                <div class="mt-4">
                    <Label required id="programmatic_line" value="Línea programática" />
                    <Select items={programmaticLines} bind:selectedValue={$form.programmatic_line} autocomplete="off" placeholder="Seleccione una línea programática"/>
                    <InputError message={errors.programmatic_line} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateProjectTypes || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Project types.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
