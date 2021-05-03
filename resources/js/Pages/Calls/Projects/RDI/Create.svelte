<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import DynamicList from '@/Dropdowns/DynamicList'
    import DropdownAcademicCentre from '@/Dropdowns/DropdownAcademicCentre'
    import Textarea from '@/Components/Textarea'

    export let errors
    export let call

    $: $title = $_('Create') + ' ' + $_('RDI.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexRDI  = authUser.can.find(element => element == 'rdi.index') == 'rdi.index'
    let canShowRDI   = authUser.can.find(element => element == 'rdi.show') == 'rdi.show'
    let canCreateRDI = authUser.can.find(element => element == 'rdi.create') == 'rdi.create'
    let canEditRDI   = authUser.can.find(element => element == 'rdi.edit') == 'rdi.edit'
    let canDeleteRDI = authUser.can.find(element => element == 'rdi.delete') == 'calls.delete'

    let sending = false
    let form = useForm({
        academic_centre_id:                 '',
        research_line_id:                   '',
        knowledge_subarea_discipline_id:    '',
        strategic_thematic_id:              '',
        knowledge_network_id:               '',
        project_type_id:                    '',
        ciiu_code_id:                       '',
        title:                              'Escriba aquí el título del proyecto. No mayor a 20 palabras.',
        start_date:                         '',
        end_date:                           '',
    })

    function submit() {
        if (canCreateRDI || isSuperAdmin) {
            Inertia.post(route('calls.rdi.store', [call.id]), $form, {
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
                    {#if canIndexRDI || canCreateRDI || isSuperAdmin}
                        <a use:inertia href={route('calls.rdi.index', [call.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('RDI.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Create')}
                </h1>
            </div>
        </div>
    </header>

    <form on:submit|preventDefault={submit}>
        <fieldset  class="p-8">
            <div class="mt-28">
                <Label required id="title" class="font-medium inline-block mb-10 text-center text-gray-700 text-sm w-full" value="Descripción llamativa que orienta el enfoque del proyecto, indica el cómo y el para qué." />
                <Textarea id="title" rows="3" error={errors.title} bind:value={$form.title} classes="bg-transparent block border-0 {errors.title ? '' : 'outline-none-important'} mt-1 outline-none text-4xl text-center w-full" required />
            </div>

            <div class="mt-44">
                <p class="text-center">Fecha de ejecución</p>
                <small class="text-red-400 block text-center">* Campo obligatorio</small>
                <div class="mt-4 flex items-start justify-around">
                    <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                        <Label id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                        <div class="ml-4">
                            <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={$form.start_date} required />
                        </div>
                    </div>
                    <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                        <Label id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                        <div class="ml-4">
                            <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={$form.end_date} required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="academic_centre_id" value="Centro de formación" />
                    <small>Nota: El Centro de Formación relacionado es el ejecutor del proyecto</small>
                </div>
                <div>
                    <DropdownAcademicCentre id="academic_centre_id" bind:formAcademicCentre={$form.academic_centre_id} message={errors.academic_centre_id} />
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="research_line_id" value="Línea de investigación" />
                </div>
                <div>
                    <DynamicList id="research_line_id" bind:value={$form.research_line_id} routeWebApi={route('web-api.research-lines')} placeholder="Busque por el nombre de la línea de investigación, centro de formación, grupo de investigación o regional" message={errors.research_line_id} required/>
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="project_type_id" value="Tipo de proyecto" />
                </div>
                <div>
                    <DynamicList id="project_type_id" bind:value={$form.project_type_id} routeWebApi={route('web-api.project-types')} placeholder="Busque por el nombre del tipo de proyecto, línea programática" message={errors.project_type_id} required />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="knowledge_network_id" value="Red de conocimiento sectorial" />
                </div>
                <div>
                    <DynamicList id="knowledge_network_id" bind:value={$form.knowledge_network_id} routeWebApi={route('web-api.knowledge-networks')} placeholder="Busque por el nombre de la red de conocimiento sectorial" message={errors.knowledge_network_id} required />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="knowledge_subarea_discipline_id" value="Disciplina de la subárea de conocimiento" />
                </div>
                <div>
                    <DynamicList id="knowledge_subarea_discipline_id" bind:value={$form.knowledge_subarea_discipline_id} routeWebApi={route('web-api.knowledge-subarea-disciplines')} placeholder="Busque por el nombre de la disciplina de subáreas de conocimiento" message={errors.knowledge_subarea_discipline_id} required />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="ciiu_code_id" value="¿En cuál de estas actividades económicas se puede aplicar el proyecto de investigación?" />
                </div>
                <div>
                    <DynamicList id="ciiu_code_id" bind:value={$form.ciiu_code_id} routeWebApi={route('web-api.ciiu-codes')} placeholder="Busque por el nombre del código CIIU" message={errors.ciiu_code_id} required />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label required class="mb-4" id="strategic_thematic_id" value="Temática estratégica SENA" />
                </div>
                <div>
                    <DynamicList id="strategic_thematic_id" bind:value={$form.strategic_thematic_id} routeWebApi={route('web-api.strategic-thematics')} placeholder="Busque por el nombre de la temática estrategica SENA" message={errors.strategic_thematic_id} required />
                </div>
            </div>
        </fieldset>

        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
            {#if canCreateRDI || isSuperAdmin}
                <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                    {$_('Continue')}
                </LoadingButton>
            {/if}
        </div>
    </form>
</AuthenticatedLayout>
