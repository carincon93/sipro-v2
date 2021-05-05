<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog from '@/Components/Dialog'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'

    export let errors
    export let projectType
    export let programmaticLines
    export let selectedProgrammaticLine

    $: $title = projectType ? projectType.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexProjectTypes    = authUser.can.find(element => element == 'project-types.index') == 'project-types.index'
    let canShowProjectTypes     = authUser.can.find(element => element == 'project-types.show') == 'project-types.show'
    let canCreateProjectTypes   = authUser.can.find(element => element == 'project-types.create') == 'project-types.create'
    let canEditProjectTypes     = authUser.can.find(element => element == 'project-types.edit') == 'project-types.edit'
    let canDeleteProjectTypes   = authUser.can.find(element => element == 'project-types.delete') == 'project-types.delete'

    let dialog_open = false
    let sending = false
    let form = useForm({
        name:   projectType.name,
        maximum_value:   projectType.maximum_value,
        programmatic_line: selectedProgrammaticLine
    })

    function submit() {
        if (canEditProjectTypes || isSuperAdmin) {
            Inertia.put(route('project-types.update', projectType.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteProjectTypes || isSuperAdmin) {
            Inertia.delete(route('project-types.destroy', projectType.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProjectTypes || canEditProjectTypes || isSuperAdmin}
                        <a use:inertia href={route('project-types.index')} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project types.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {projectType.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="maximum_value" value="Valor máximo" />
                    <Input id="maximum_value" type="number" min="0" class="mt-1 block w-full" bind:value={$form.maximum_value} required autofocus />
                    <InputError message={errors.maximum_value} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="programmatic_line" value="Línea programática" />
                    <Select items={programmaticLines} bind:selectedValue={$form.programmatic_line} autocomplete="off" placeholder="Seleccione una subárea de conocimiento"/>
                    <InputError message={errors.programmatic_line} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteProjectTypes || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => dialog_open = true}>
                        {$_('Delete')} {$_('Project types.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditProjectTypes || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Project types.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>

        <Dialog bind:open={dialog_open}>
        <div slot="title" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Eliminar recurso
        </div>
        <div slot="content">
            <p>
                ¿Está seguro(a) que desea eliminar este recurso?
                <br>
                Todos los datos se eliminarán de forma permanente.
                <br>
                Está acción no se puede deshacer.
            </p>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button on:click={event => dialog_open = false} variant={null}>{$_('Cancel')}</Button>
                <Button variant="raised" on:click={destroy}>
                    {$_('Confirm')}
                </Button>
            </div>
        </div>
    </Dialog>
    </div>
</AuthenticatedLayout>
