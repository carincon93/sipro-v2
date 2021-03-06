<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Stepper from '@/Components/Stepper.svelte'
    import DropdownResearchLine from '@/Dropdowns/DropdownResearchLine.svelte'
    import DropdownProjectType from '@/Dropdowns/DropdownProjectType.svelte'
    import DropdownKnowledgeNetwork from '@/Dropdowns/DropdownKnowledgeNetwork.svelte'
    import DropdownKnowledgeSubareaDiscipline from '@/Dropdowns/DropdownKnowledgeSubareaDiscipline.svelte'
    import DropdownCIIUCode from '@/Dropdowns/DropdownCIIUCode.svelte'
    import DropdownStrategicThematic from '@/Dropdowns/DropdownStrategicThematic.svelte'
    import Switch from '@/Components/Switch'
    import Textarea from '@/Components/Textarea'

    export let errors
    export let call
    export let rdi

    $: $title = rdi ? rdi.title : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexRDI     = authUser.can.find(element => element == 'rdi.index') == 'rdi.index'
    let canCreateRDI    = authUser.can.find(element => element == 'rdi.create') == 'rdi.create'
    let canShowRDI      = authUser.can.find(element => element == 'rdi.show') == 'rdi.show'
    let canEditRDI      = authUser.can.find(element => element == 'rdi.edit') == 'rdi.edit'
    let canDeleteRDI    = authUser.can.find(element => element == 'rdi.delete') == 'rdi.delete'

    let modal_open  = errors.password != undefined ? true : false
    let sending     = false

    let video                               = rdi.video != null
    let industry_4_justification            = rdi.industry_4_justification != null
    let orange_economy_justification        = rdi.orange_economy_justification != null
    let people_disabilities_justification   = rdi.people_disabilities_justification != null

    let form = remember({
        research_line_id:                   rdi.research_line_id,
        knowledge_subarea_discipline_id:    rdi.knowledge_subarea_discipline_id,
        strategic_thematic_id:              rdi.strategic_thematic_id,
        knowledge_network_id:               rdi.knowledge_network_id,
        project_type_id:                    rdi.project.project_type_id,
        ciiu_code_id:                       rdi.ciiu_code_id,
        title:                              rdi.title,
        start_date:                         rdi.start_date,
        end_date:                           rdi.end_date,
        video:                              rdi.video,
        industry_4_justification:           rdi.industry_4_justification,
        orange_economy_justification:       rdi.orange_economy_justification,
        people_disabilities_justification:  rdi.people_disabilities_justification,
        abstract:                           rdi.abstract,
        project_background:                 rdi.project_background,
        conceptual_framework:               rdi.conceptual_framework,
        project_methodology:                rdi.project_methodology,
        sustainability_proposal:            rdi.sustainability_proposal,
        bibliography:                       rdi.bibliography,
        students:                           rdi.students,
        states:                             rdi.states,
        states_impact:                      rdi.states_impact
    })

    function submit() {
        if (canEditRDI || isSuperAdmin) {
            Inertia.put(route('calls.rdi.update', [call.id, rdi.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    let values = {
        password: ''
    }

    function destroy() {
        if (canDeleteRDI || isSuperAdmin) {
            Inertia.visit(route('calls.rdi.destroy', [call.id, rdi.id]), {
                method: 'DELETE',
                data: values,
            })
        }
    }
</script>

<style>

</style>

<AuthenticatedLayout>
    <Stepper call={call} project={rdi} />

    <form on:submit|preventDefault={submit} novalidate>
        <div class="p-8">
            <div class="mt-28">
                <Label id="title" class="font-medium inline-block mb-10 text-center text-gray-700 text-sm w-full" value="Descripción llamativa que orienta el enfoque del proyecto, indica el cómo y el para qué." />
                <Textarea id="title" rows="3" error={errors.title} bind:value={$form.title} classes="bg-transparent block border-0 {errors.title ? '' : 'outline-none-important'} mt-1 outline-none text-4xl text-center w-full" required />
            </div>

            <div class="mt-44">
                <p class="text-center">Fecha de ejecución</p>
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
                    <Label id="research_line_id" value="Línea de investigación" />
                </div>
                <div>
                    <DropdownResearchLine id="research_line_id" bind:formResearchLine={$form.research_line_id} message={errors.research_line_id} />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="project_type_id" value="Tipo de proyecto" />
                </div>
                <div>
                    <DropdownProjectType id="project_type_id" bind:formProjectType={$form.project_type_id} message={errors.project_type_id} />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="knowledge_network_id" value="Red de conocimiento sectorial" />
                </div>
                <div>
                    <DropdownKnowledgeNetwork id="knowledge_network_id" bind:formKnowledgeNetwork={$form.knowledge_network_id} message={errors.knowledge_network_id} />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="knowledge_subarea_discipline_id" value="Disciplina de la subárea de conocimiento" />
                </div>
                <div>
                    <DropdownKnowledgeSubareaDiscipline id="knowledge_subarea_discipline_id" bind:formKnowledgeSubareaDiscipline={$form.knowledge_subarea_discipline_id} message={errors.knowledge_subarea_discipline_id} />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="ciiu_code_id" value="¿En cuál de estas actividades económicas se puede aplicar el proyecto de investigación?" />
                </div>
                <div>
                    <DropdownCIIUCode id="ciiu_code_id" bind:formCiiuCode={$form.ciiu_code_id} message={errors.ciiu_code_id} />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="strategic_thematic_id" value="Temática estratégica SENA" />
                </div>
                <div>
                    <DropdownStrategicThematic id="strategic_thematic_id" bind:formStrategicThematic={$form.strategic_thematic_id} message={errors.strategic_thematic_id} />
                </div>
            </div>
            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="video" value="¿El proyecto tiene video?" />
                </div>
                <div>
                    <div class="flex items-center mb-14">
                        <Switch bind:checked={video} />
                        <span class="ml-2">{#if video} Si {:else} No {/if}</span>
                    </div>
                    {#if video}
                        <Input id="video" type="url" class="mt-1 block w-full" error={errors.video} placeholder="Link del video del proyecto https://www.youtube.com/watch?v=gmc4tk" bind:value={$form.video} required={!video ? undefined : 'required'} />
                        <div class="bg-indigo-100 p-5 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>
                                Video de 3 minutos, en donde se presente de manera sencilla y dinámica la justificación del proyecto, la problemática, el objetivo general, los objetivos específicos, las actividades, los productos y su impacto en el marco del mecanismo de participación seleccionado como regional.
                            </p>
                        </div>
                    {/if}
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="industry_4_justification" value="¿El proyecto está relacionado con la industria 4.0?" />
                </div>
                <div>
                    <div class="flex items-center mb-14">
                        <Switch bind:checked={industry_4_justification} />
                        <span class="ml-2">{#if industry_4_justification} Si {:else} No {/if}</span>
                    </div>
                    {#if industry_4_justification}
                        <Textarea id="industry_4_justification" error={errors.industry_4_justification} bind:value={$form.industry_4_justification} required={!industry_4_justification ? undefined : 'required'} />
                        <div class="bg-indigo-100 p-5 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>
                                Si el proyecto está relacionado con la industria 4.0 por favor realice la justificación.
                            </p>
                        </div>
                    {/if}
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="orange_economy_justification" value="¿El proyecto está relacionado con la economía naranja?" />
                </div>
                <div>
                    <div class="flex items-center mb-14">
                        <Switch bind:checked={orange_economy_justification} />
                        <span class="ml-2">{#if orange_economy_justification} Si {:else} No {/if}</span>
                    </div>
                    {#if orange_economy_justification}
                        <Textarea id="orange_economy_justification" error={errors.orange_economy_justification} bind:value={$form.orange_economy_justification} required={!orange_economy_justification ? undefined : 'required'} />
                        <div class="bg-indigo-100 p-5 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>
                                Si el proyecto está relacionado con la economía naranja por favor realice la justificación. (Ver documento de apoyo: Guía Rápida SENA es NARANJA.)
                            </p>
                        </div>
                    {/if}
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="people_disabilities_justification" value="¿El proyecto aporta a la Política Institucional para Atención de las Personas con discapacidad?" />
                </div>
                <div>
                    <div class="flex items-center mb-14">
                        <Switch bind:checked={people_disabilities_justification} />
                        <span class="ml-2">{#if people_disabilities_justification} Si {:else} No {/if}</span>
                    </div>
                    {#if people_disabilities_justification}
                        <Textarea id="people_disabilities_justification" error={errors.people_disabilities_justification} bind:value={$form.people_disabilities_justification} required={!people_disabilities_justification ? undefined : 'required'} />
                        <div class="bg-indigo-100 p-5 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>
                                Si el proyecto aporta a la Política Institucional para Atención de las Personas con discapacidad por favor realice la justificación. RESOLUCIÓN 01726 DE 2014 - Por la cual se adopta la Política Institucional para Atención de las Personas con discapacidad.
                            </p>
                        </div>
                    {/if}
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="abstract" value="Resumen del proyecto" />
                </div>
                <div>
                    <Textarea id="abstract" error={errors.abstract} bind:value={$form.abstract} required />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Información necesaria para darle al lector una idea precisa de la pertinencia y calidad proyecto. Explique en qué consiste el problema o necesidad, cómo cree que lo resolverá, cuáles son las razones que justifican su ejecución y las herramientas que se utilizarán en el desarrollo del proyecto.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="project_background" value="Antedecentes" />
                </div>
                <div>
                    <Textarea id="project_background" error={errors.project_background} bind:value={$form.project_background} required />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Presenta las investigaciones, innovaciones o desarrollos tecnológicos que se han realizado a nivel internacional, nacional, departamental o municipal en el marco de la temática de la propuesta del proyecto; que muestran la pertinencia del proyecto, citar toda la información consignada utilizando normas APA sexta edición.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="conceptual_framework" value="Marco conceptual" />
                </div>
                <div>
                    <Textarea id="conceptual_framework" error={errors.conceptual_framework} bind:value={$form.conceptual_framework} required />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Descripción de los aspectos conceptuales y/o teóricos relacionados con el problema. Se hace la claridad que no es un listado de definiciones.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="project_methodology" value="Metodología" />
                </div>
                <div>
                    <Textarea id="project_methodology" error={errors.project_methodology} bind:value={$form.project_methodology} required />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Describir la (s) metodología (s) a utilizar en el desarrollo del proyecto.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="sustainability_proposal" value="Propuesta de sostenibilidad" />
                </div>
                <div>
                    <Textarea id="sustainability_proposal" error={errors.sustainability_proposal} bind:value={$form.sustainability_proposal} required />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Identificar los efectos que tiene el desarrollo del proyecto de investigación ya sea positivos o negativos. Se recomienda establecer las acciones pertinentes para mitigar los impactos negativos ambientales identificados y anexar el respectivo permiso ambiental cuando aplique. Tener en cuenta si aplica el decreto 1376 de 2013.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="bibliography" value="Bibliografía" />
                </div>
                <div>
                    <Textarea id="bibliography" error={errors.bibliography} bind:value={$form.bibliography} required />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Lista de las referencias utilizadas en cada apartado del proyecto. Utilizar normas APA- Sexta edición (http://biblioteca.sena.edu.co/images/PDF/InstructivoAPA.pdf).
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="students" value="Número de los aprendices que se beneficiarán en la ejecución del proyecto" />
                </div>
                <div>
                    <Input id="students" type="number" min="0" max="9999" class="mt-1 block w-full" error={errors.students} placeholder="Escriba el número de aprendices que se beneficiarán en la ejecución del proyecto" bind:value={$form.students} required />
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="states" value="Nombre de los municipios beneficiados" />
                </div>
                <div>
                    <Textarea id="states" error={errors.states} bind:value={$form.states} required />
                </div>
            </div>

            <div class="mt-44 grid grid-cols-2">
                <div>
                    <Label id="states_impact" value="Descripción del beneficio en los municipios" />
                </div>
                <div>
                    <Textarea id="states_impact" error={errors.states_impact} bind:value={$form.states_impact} required />
                </div>
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteRDI || isSuperAdmin}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')}
                </button>
            {/if}
            {#if canCreateRDI || isSuperAdmin}
                <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                    {$_('Save')}
                </LoadingButton>
            {/if}
        </div>
    </form>

    <Modal bind:open={modal_open} class="h-3/4 modal rounded-2xl">
        <Card class="flex flex-col h-full justify-around rounded-2xl bg-mistyrose">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-1/6 m-auto text-red-300 bg-white rounded-full p-4 shadow-md">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <div class="p-4">
                <p class="bg-red-300 max-w-md p-4 rounded text-center text-white">
                    {$_('Are you sure you want to delete this project? Once the project is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete this project.')}
                </p>
                <form on:submit|preventDefault={destroy} id="delete-rdi" class="mb-28">
                    <Input id="password" type="password" class="mt-1 block w-full" error={errors.password} placeholder="Escriba su contraseña" bind:value={values.password} required />
                </form>
                <div class="flex mt/">
                    <button on:click={event => modal_open = false} class="text-red-400" type="button">{$_('Cancel')}</button>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 bg-red-500 hover:bg-red-400 ml-auto shadow-md" form="delete-rdi">
                        {$_('Confirm')}
                    </button>
                </div>
            </div>
        </Card>
    </Modal>
</AuthenticatedLayout>

