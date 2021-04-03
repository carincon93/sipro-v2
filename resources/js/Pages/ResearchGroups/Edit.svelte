<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre'

    export let errors
    export let researchGroup
    export let mincienciasCategories
    export let selectedMincienciasCategory

    $: $title = researchGroup ? researchGroup.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexResearchGroups  = authUser.can.find(element => element == 'research-groups.index') == 'research-groups.index'
    let canShowResearchGroups   = authUser.can.find(element => element == 'research-groups.show') == 'research-groups.show'
    let canCreateResearchGroups = authUser.can.find(element => element == 'research-groups.create') == 'research-groups.create'
    let canEditResearchGroups   = authUser.can.find(element => element == 'research-groups.edit') == 'research-groups.edit'
    let canDeleteResearchGroups = authUser.can.find(element => element == 'research-groups.delete') == 'research-groups.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   researchGroup.name,
        acronym: researchGroup.acronym,
        email: researchGroup.email,
        gruplac_link: researchGroup.gruplac_link,
        minciencias_code: researchGroup.minciencias_code,
        minciencias_category: selectedMincienciasCategory,
        academic_centre: researchGroup.academic_centre_id,

    })

    function submit() {
        if (canEditResearchGroups || isSuperAdmin) {
            Inertia.put(route('research-groups.update', researchGroup.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteResearchGroups || isSuperAdmin) {
            Inertia.delete(route('research-groups.destroy', researchGroup.id))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexResearchGroups || canEditResearchGroups || isSuperAdmin}
                        <a use:inertia href={route('research-groups.index')} class="text-indigo-400 hover:text-indigo-600">
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
            <div class="p-8">
                <div class="mt-4">
                    <Label id="name" value="Nombre" />
                    <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                    <InputError message={errors.name} />
                </div>

                <div class="mt-4">
                    <Label id="acronym" value="Acrónimo" />
                    <Input id="acronym" type="text" class="mt-1 block w-full" bind:value={$form.acronym} required autofocus />
                    <InputError message={errors.acronym} />
                </div>

                <div class="mt-4">
                    <Label id="email" value="Correo electrónico" />
                    <Input id="email" type="email" class="mt-1 block w-full" bind:value={$form.email} required autofocus />
                    <InputError message={errors.email} />
                </div>

                <div class="mt-4">
                    <Label id="gruplac_link" value="Enlace GrupLac" />
                    <Input id="gruplac_link" type="url" class="mt-1 block w-full" bind:value={$form.gruplac_link} required autofocus />
                    <InputError message={errors.gruplac_link} />
                </div>

                <div class="mt-4">
                    <Label id="minciencias_code" value="Código Minciencias" />
                    <Input id="minciencias_code" type="text" class="mt-1 block w-full" bind:value={$form.minciencias_code} required autofocus />
                    <InputError message={errors.minciencias_code} />
                </div>

                <div class="mt-4">
                    <Label id="minciencias_category" value="Categoría Minciencias" />
                    <Select items={mincienciasCategories} bind:selectedValue={$form.minciencias_category} autocomplete="off" placeholder="Seleccione una categoría Minciencias"/>
                    <InputError message={errors.minciencias_category} />
                </div>

                <div class="mt-4">
                    <Label id="academic_centre" value="Centro de formación" />
                    <DropdownAcademicCentre id="academic_centre" bind:formAcademicCentre={$form.academic_centre} message={errors.academic_centre} />
                    <InputError message={errors.academic_centre} />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
                {#if canDeleteResearchGroups || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Research groups.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditResearchGroups || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Research groups.singular')}
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

