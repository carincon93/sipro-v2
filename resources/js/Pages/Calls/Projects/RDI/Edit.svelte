<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { onMount } from 'svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import fitTextarea from 'fit-textarea'
    import Stepper from '@/Components/Stepper.svelte'
    import DropdownResearchLine from '@/Dropdowns/DropdownResearchLine.svelte'
    import DropdownProjectType from '@/Dropdowns/DropdownProjectType.svelte'
    import DropdownKnowledgeNetwork from '@/Dropdowns/DropdownKnowledgeNetwork.svelte'
    import DropdownKnowledgeSubareaDiscipline from '@/Dropdowns/DropdownKnowledgeSubareaDiscipline.svelte'
    import DropdownCIIUCode from '@/Dropdowns/DropdownCIIUCode.svelte'
    import DropdownStrategicThematic from '@/Dropdowns/DropdownStrategicThematic.svelte'
    import Switch from '@/Components/Switch'

    export let errors
    export let call
    export let rdi

    $: $title = rdi ? rdi.title : null

    let canUpdateRDI = $page.props.auth.user.can.find(element => element == 'rdi.edit')     == 'rdi.edit'
    let canDeleteRDI = $page.props.auth.user.can.find(element => element == 'rdi.delete')   == 'rdi.delete'

    let modal_open  = false
    let sending     = false
    let video       = rdi.video != null
    let industry_4_justification = rdi.industry_4_justification != null
    let orange_economy_justification = rdi.orange_economy_justification != null
    let people_disabilities_justification = rdi.people_disabilities_justification != null
    let form        = remember({
        title:              rdi.title,
        start_date:         rdi.start_date,
        end_date:           rdi.end_date,
        research_line_id:   rdi.research_line_id,
        video:              rdi.video,
        industry_4_justification:   rdi.industry_4_justification,
        orange_economy_justification:   rdi.orange_economy_justification,
        people_disabilities_justification: rdi.people_disabilities_justification,
        abstract: rdi.abstract,
        project_background: rdi.project_background,
        project_methodology: rdi.project_methodology,
        sustainability_proposal: rdi.sustainability_proposal,
        bibliography: rdi.bibliography,
        students: rdi.students,
        states: rdi.states,
        states_impact: rdi.states_impact
    })

    onMount(() => {
        // Convierte los textareas en fit-textareas
        fitTextareas()
	})

    function submit() {
        if (canUpdateRDI) {
            Inertia.put(route('calls.rdi.update', [call.id, rdi.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteRDI) {
            Inertia.delete(route('calls.rdi.destroy', [call.id, rdi.id]))
        }
    }

    function fitTextareas() {
        setTimeout(() => {
            const textareas = document.querySelectorAll('textarea')
            fitTextarea.watch(textareas)
        }, 1)
    }
</script>

<Stepper call={call} project={rdi} />

<form on:submit|preventDefault={submit}>
    <div class="p-8">
        <div class="mt-28">
            <Label id="title" class="font-medium inline-block mb-10 text-center text-gray-700 text-sm w-full" value="Descripción llamativa que orienta el enfoque del proyecto, indica el cómo y el para qué." />
            <textarea rows="3" id="title" class="bg-transparent block border-0 outline-none-important mt-1 outline-none text-4xl text-center w-full" required>{$form.title}</textarea>
            <InputError message={errors.title} />
        </div>

        <div class="mt-44">
            <p class="text-center">Fecha de ejecución</p>
            <div class="mt-4 flex items-center justify-around">
                <div class="mt-4 flex items-center">
                    <Label id="start_date" value="Del" />
                    <div class="ml-4">
                        <Input id="start_date" type="date" class="mt-1 block w-full" bind:value={$form.start_date} required />
                        <InputError message={errors.start_date} />
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <Label id="end_date" value="hasta" />
                    <div class="ml-4">
                        <Input id="end_date" type="date" class="mt-1 block w-full" bind:value={$form.end_date} required />
                        <InputError message={errors.end_date} />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="research_line_id" value="Línea de investigación" />
            </div>
            <div>
                <DropdownResearchLine id="research_line_id" message={errors.research_line_id} />
            </div>
        </div>
        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="project_type_id" value="Tipo de proyecto" />
            </div>
            <div>
                <DropdownProjectType id="project_type_id" message={errors.project_type_id} />
            </div>
        </div>
        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="knowledge_network_id" value="Red de conocimiento sectorial" />
            </div>
            <div>
                <DropdownKnowledgeNetwork id="knowledge_network_id" message={errors.knowledge_network_id} />
            </div>
        </div>
        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="knowledge_subarea_discipline_id" value="Disciplina de la subárea de conocimiento" />
            </div>
            <div>
                <DropdownKnowledgeSubareaDiscipline id="knowledge_subarea_discipline_id" message={errors.knowledge_subarea_discipline_id} />
            </div>
        </div>
        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="ciiu_code_id" value="¿En cuál de estas actividades económicas se puede aplicar el proyecto de investigación?" />
            </div>
            <div>
                <DropdownCIIUCode id="ciiu_code_id" message={errors.ciiu_code_id} />
            </div>
        </div>
        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="strategic_thematic_id" value="Temática estratégica SENA" />
            </div>
            <div>
                <DropdownStrategicThematic id="strategic_thematic_id" message={errors.strategic_thematic_id} />
            </div>
        </div>
        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="video" value="¿El proyecto tiene video?" />
            </div>
            <div>
                <div class="flex items-center">
                    <Switch bind:checked={video} />
                    <span class="ml-2">{#if video} Si {:else} No {/if}</span>
                </div>
                {#if video}
                    <Input id="video" type="url" class="mt-1 block w-full" placeholder="Link del video del proyecto https://www.youtube.com/watch?v=gmc4tk" bind:value={$form.video} required={!video ? undefined : 'required'} />
                    <InputError message={errors.video} />
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
                <div class="flex items-center">
                    <Switch bind:checked={industry_4_justification} click={fitTextareas} />
                    <span class="ml-2">{#if industry_4_justification} Si {:else} No {/if}</span>
                </div>
                {#if industry_4_justification}
                    <textarea rows="10" id="industry_4_justification" class="w-full border-gray-300" required={!industry_4_justification ? undefined : 'required'}>{$form.industry_4_justification}</textarea>
                    <InputError message={errors.industry_4_justification} />
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
                <div class="flex items-center">
                    <Switch bind:checked={orange_economy_justification} click={fitTextareas} />
                    <span class="ml-2">{#if orange_economy_justification} Si {:else} No {/if}</span>
                </div>
                {#if orange_economy_justification}
                    <textarea rows="10" id="orange_economy_justification" class="w-full border-gray-300" required={!orange_economy_justification ? undefined : 'required'}>{$form.orange_economy_justification}</textarea>
                    <InputError message={errors.orange_economy_justification} />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Si el proyecto está relacionado con la economía naranja por favor realice la justificación, de lo contrario no diligencie el campo. (Ver documento de apoyo: Guía Rápida SENA es NARANJA.)
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
                <div class="flex items-center">
                    <Switch bind:checked={people_disabilities_justification} click={fitTextareas} />
                    <span class="ml-2">{#if people_disabilities_justification} Si {:else} No {/if}</span>
                </div>
                {#if people_disabilities_justification}
                    <textarea rows="10" id="people_disabilities_justification" class="w-full border-gray-300" required={!people_disabilities_justification ? undefined : 'required'}>{$form.people_disabilities_justification}</textarea>
                    <InputError message={errors.people_disabilities_justification} />
                    <div class="bg-indigo-100 p-5 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5" style="transform: translateX(-50px)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Si el proyecto aporta a la Política Institucional para Atención de las Personas con discapacidad por favor realice la justificación, de lo contrario no diligencie el campo. RESOLUCIÓN 01726 DE 2014 - Por la cual se adopta la Política Institucional para Atención de las Personas con discapacidad.
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
                <textarea rows="10" id="abstract" class="w-full border-gray-300" required>{$form.abstract}</textarea>
                <InputError message={errors.abstract} />
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
                <textarea rows="10" id="project_background" class="w-full border-gray-300" required>{$form.project_background}</textarea>
                <InputError message={errors.project_background} />
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
                <Label id="project_methodology" value="Metodología" />
            </div>
            <div>
                <textarea rows="10" id="project_methodology" class="w-full border-gray-300" required>{$form.project_methodology}</textarea>
                <InputError message={errors.project_methodology} />
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
                <textarea rows="10" id="sustainability_proposal" class="w-full border-gray-300" required>{$form.sustainability_proposal}</textarea>
                <InputError message={errors.sustainability_proposal} />
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
                <textarea rows="10" id="bibliography" class="w-full border-gray-300" required>{$form.bibliography}</textarea>
                <InputError message={errors.bibliography} />
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
                <Input id="students" type="number" min="0" max="9999" class="mt-1 block w-full" placeholder="Escriba el número de aprendices que se beneficiarán en la ejecución del proyecto" bind:value={$form.students} required />
                <InputError message={errors.students} />
            </div>
        </div>

        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="states" value="Nombre de los municipios beneficiados" />
            </div>
            <div>
                <textarea rows="10" id="states" class="w-full border-gray-300" required>{$form.states}</textarea>
                <InputError message={errors.states} />
            </div>
        </div>

        <div class="mt-44 grid grid-cols-2">
            <div>
                <Label id="states_impact" value="Descripción del beneficio en los municipios" />
            </div>
            <div>
                <textarea rows="10" id="states_impact" class="w-full border-gray-300" required>{$form.states_impact}</textarea>
                <InputError message={errors.states_impact} />
            </div>
        </div>
    </div>
    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
        {#if canDeleteRDI}
            <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                {$_('Delete')}
            </button>
        {/if}
        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
            {$_('Save')}
        </LoadingButton>
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
