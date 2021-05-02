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
    import Textarea from '@/Components/Textarea'

    export let errors
    export let projectCategories

    $: $title = $_('Create') + ' ' + $_('Programmatic lines.singular').toLowerCase()

    // Permisos
    let authUser    = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProgrammaticLines   = authUser.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'
    let canShowProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.show') == 'programmatic-lines.show'
    let canCreateProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.create') == 'programmatic-lines.create'
    let canEditProgrammaticLines    = authUser.can.find(element => element == 'programmatic-lines.edit') == 'programmatic-lines.edit'
    let canDeleteProgrammaticLines  = authUser.can.find(element => element == 'programmatic-lines.delete') == 'programmatic-lines.delete'

    let sending = false
    let form = remember({
        name: '',
        description: '',
        code: '',
        project_category: ''
    })

    function submit() {
        if (canCreateProgrammaticLines || isSuperAdmin) {
            Inertia.post(route('programmatic-lines.store'), $form, {
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
                    {#if canIndexProgrammaticLines || canCreateProgrammaticLines || isSuperAdmin}
                        <a use:inertia href={route('programmatic-lines.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Programmatic lines.plural')}
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
                    <Label required class="mb-4" id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="code" value="Código" />
                    <Input id="code" type="text" class="mt-1 block w-full" bind:value={$form.code} required />
                    <InputError message={errors.code} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="project_category" value="Categoría" />
                    <Select items={projectCategories} bind:selectedValue={$form.project_category} autocomplete="off" placeholder="Seleccione una categoría"/>
                    <InputError message={errors.project_category} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                    <InputError message={errors.description} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateProgrammaticLines || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Programmatic lines.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
