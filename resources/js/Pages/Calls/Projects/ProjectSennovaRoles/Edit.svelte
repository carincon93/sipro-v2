<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import {afterUpdate} from 'svelte'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Textarea from '@/Components/Textarea'
    import DropdownProjectSennovaRole from '@/Dropdowns/DropdownProjectSennovaRole'

    export let call
    export let project
    export let programmaticLine
    export let roleName
    export let projectSennovaRole   = {}
    export let errors

    let qty_months
    let qty_roles

    $: $title = roleName.name

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexProjectSennovaRoles     = authUser.can.find(element => element == 'project-sennova-roles.index') == 'project-sennova-roles.index'
    let canShowProjectSennovaRoles      = authUser.can.find(element => element == 'project-sennova-roles.show') == 'project-sennova-roles.show'
    let canCreateProjectSennovaRoles    = authUser.can.find(element => element == 'project-sennova-roles.create') == 'project-sennova-roles.create'
    let canEditProjectSennovaRoles      = authUser.can.find(element => element == 'project-sennova-roles.edit') == 'project-sennova-roles.edit'
    let canDeleteProjectSennovaRoles    = authUser.can.find(element => element == 'project-sennova-roles.delete') == 'project-sennova-roles.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        call_sennova_role_id: projectSennovaRole.call_sennova_role_id,
        qty_months: projectSennovaRole.qty_months,
        qty_roles: projectSennovaRole.qty_roles,
        description: projectSennovaRole.description,
    })

    function submit() {
        if (canEditProjectSennovaRoles || isSuperAdmin) {
            Inertia.put(route('calls.projects.project-sennova-roles.update', [call.id, project.id, projectSennovaRole.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteProjectSennovaRoles || isSuperAdmin) {
            Inertia.delete(route('calls.projects.project-sennova-roles.destroy', [call.id, project.id, projectSennovaRole.id]))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexProjectSennovaRoles || canEditProjectSennovaRoles || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.project-sennova-roles.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Project sennova roles.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {roleName.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" id="call_sennova_role_id" value="Rol SENNOVA" />
                    <DropdownProjectSennovaRole id="call_sennova_role_id" bind:qtyMonths={qty_months} bind:qtyRoles={qty_roles} {call} {programmaticLine} bind:formProjectSennovaRole={$form.call_sennova_role_id} message={errors.call_sennova_role_id} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                {#if qty_months}
                    <div class="mt-4">
                        <p class="block font-medium text-sm text-gray-700 ">Número de meses que requiere el apoyo:
                            <span class="block border-gray-300 p-4 rounded-md shadow-sm">
                                {qty_months}
                            </span>
                        </p>
                    </div>
                {:else}
                    <div class="mt-4">
                        <Label required class="mb-4" id="qty_months" value="Número de meses que requiere el apoyo" />
                        <Input id="qty_months" type="number" min="1" class="mt-1 block w-full" error={errors.qty_months} bind:value={$form.qty_months} required />
                    </div>
                {/if}

                {#if qty_roles}
                    <div class="mt-4">
                        <p class="block font-medium text-sm text-gray-700 ">Número de personas requeridas:
                            <span class="block border-gray-300 p-4 rounded-md shadow-sm">
                                {qty_roles}
                            </span>
                        </p>
                    </div>
                {:else}
                    <div class="mt-4">
                        <Label required class="mb-4" id="qty_roles" value="Número de personas requeridas" />
                        <Input id="qty_roles" type="number" min="1" class="mt-1 block w-full" error={errors.qty_roles} bind:value={$form.qty_roles} required />
                    </div>
                {/if}
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteProjectSennovaRoles || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Project sennova roles.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditProjectSennovaRoles || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Project sennova roles.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>

        <Modal bind:open={modal_open}>
            <Card>
                <div class="p-4">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 bg-red-500 hover:bg-red-400 ml-auto" type="button" on:click={destroy}>
                        {$_('Confirm')}
                    </button>
                    <button on:click={event => modal_open = false} type="button">{$_('Cancel')}</button>
                </div>
            </Card>
        </Modal>
    </div>
</AuthenticatedLayout>
