<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { useForm } from '@inertiajs/inertia-svelte'
    import { afterUpdate, onMount } from 'svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Dialog, { Title, Content } from '@smui/dialog'
    import Button, { Label as LabelMUI } from '@smui/button'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Textarea from '@/Components/Textarea'
    import Select from '@/Components/Select'
    import Stepper from '@/Components/Stepper'

    import { createPopper } from '@popperjs/core'

    export let errors
    export let call
    export let project
    export let directEffects
    export let directCauses

    let formID
    let sending = false
    let open    = false
    let dialogTitle
    let code

    const types = [
        {value: 'Generación del conocimiento (GNC)', label: 'Generación del conocimiento (GNC)'},
        {value: 'Desarrollo tecnólogico (DT)', label: 'Desarrollo tecnólogico (DT)'},
        {value: 'Apropiación social del conocimiento (ASC)', label: 'Apropiación social del conocimiento (ASC)'},
        {value: 'Formación de recurso humano (FRH)', label: 'Formación de recurso humano (FRH)'},
    ]

    $: $title = $_('Objectives tree')

    /**
     * Mensaje para ítems bloqueados
     */
    let generalInfoType = 0
    let showGeneralInfo = false
    function showGeneralInfoDialog(type) {
        dialogTitle                 = 'Información general'
        showPrimaryObjectiveForm    = false
        showSpecificObjectiveForm   = false
        showActivityForm            = false
        showResultForm              = false
        showImpactForm              = false
        open                        = true

        generalInfoType = type
        showGeneralInfo = true
    }

    /**
     * Impactos
     */
    let formImpact = useForm({
        id: 0,
        indirect_effect_id: 0,
        description: '',
        result_id: ''
    })

    let showImpactForm  = false
    function showImpactDialog(impact, indirectEffectID, resultID) {
        code                                = impact.id != null ? 'RES-' + resultID + '-IMP-' + impact.id: ''
        dialogTitle                         = 'Impacto'
        showPrimaryObjectiveForm            = false
        showSpecificObjectiveForm           = false
        showActivityForm                    = false
        showResultForm                      = false
        showGeneralInfo                     = false
        open                                = true
        showImpactForm                      = true
        formID                              = 'impact-form'

        if(impact != null){
            $formImpact.id                  = impact.id
            $formImpact.description         = impact.description
            $formImpact.indirect_effect_id  = impact.indirectEffectID
            $formImpact.result_id           = resultID
        } else {
            $formImpact.id                  = null
            $formImpact.indirect_effect_id  = indirectEffectID
            $formImpact.result_id           = ''
        }
    }

    function submitImpact() {
        Inertia.post(route('projects.impact', {project:project.id, impact: $formImpact.id}), $formImpact, {
            onStart: ()     =>  { sending = true},
            onSuccess: ()   =>  { closeDialog() },
            onFinish: ()    =>  { sending = false},
            preserveScroll: true
        })
    }

    /**
     * Resultados
     */
    let formResult = useForm({
        description: '',
        type: '',
        trl: 1,
        indicator: '',
        means_of_verification: '',
        specificObjective: ''
    })

    let showResultForm  = false
    let specificObjectiveDescription = []
    $: directCauses
    function showResultDialog(result) {
        let specificObjective               = directCauses.find(directCause => directCause.specific_objective.id == result.specific_objective_id)
        specificObjectiveDescription        = {description: specificObjective.specific_objective?.description ? specificObjective.specific_objective?.description : $_('No data recorded'), number: specificObjective.specific_objective?.number }
        code                                = 'RES-' + result.id
        dialogTitle                         = 'Resultado'
        showPrimaryObjectiveForm            = false
        showSpecificObjectiveForm           = false
        showActivityForm                    = false
        showImpactForm                      = false
        showGeneralInfo                     = false
        open                                = true
        showResultForm                      = true
        formID                              = 'result-form'
        $formResult.id                      = result.id
        $formResult.description             = result.description
        $formResult.type                    = result.type
        $formResult.trl                     = result.trl
        $formResult.indicator               = result.indicator
        $formResult.means_of_verification   = result.means_of_verification
    }

    function submitResult() {
        Inertia.post(route('projects.project_result', {project:project.id, project_result: $formResult.id}), $formResult, {
            onStart: ()     =>  { sending = true},
            onSuccess: ()   =>  { closeDialog() },
            onFinish: ()    =>  { sending = false},
            preserveScroll: true
        })
    }

    /**
     * Objetivo general
     */
    let formPrimaryObjective = useForm({
        primary_objective: project.primary_objective
    })

    let showPrimaryObjectiveForm = false
    function showPrimaryObjectiveDialog() {
        dialogTitle                             = 'Objetivo general'
        showSpecificObjectiveForm               = false
        showActivityForm                        = false
        showResultForm                          = false
        showImpactForm                          = false
        showGeneralInfo                         = false
        open                                    = true
        showPrimaryObjectiveForm                = true
        formID                                  = 'primary-objective-form'
        $formPrimaryObjective.primary_objective = project.primary_objective
    };

    function submitGeneralObjetive() {
        Inertia.post(route('projects.primary_objective', project.id), $formPrimaryObjective, {
            onStart: ()     =>  { sending = true },
            onSuccess: ()   =>  { closeDialog() },
            onFinish: ()    =>  { sending = false },
            preserveScroll: true
        })
    }

    /**
     * Objetivos específicos
     */
     let formSpecificObjective = useForm({
        id: 0,
        description: '',
        number: 0
    })

    let showSpecificObjectiveForm  = false
    function showSpecificObjectiveDialog(specificObjective, number) {
        code                                = 'OBJ-ESP-' + specificObjective.id
        dialogTitle                         = specificObjective.number
        showPrimaryObjectiveForm            = false
        showActivityForm                    = false
        showResultForm                      = false
        showImpactForm                      = false
        showGeneralInfo                     = false
        open                                = true
        showSpecificObjectiveForm           = true
        formID                              = 'specific-objective-form'
        $formSpecificObjective.id           = specificObjective.id;
        $formSpecificObjective.description  = specificObjective.description;
        $formSpecificObjective.number       = number
    };

    function submitSpecificObjective() {
        Inertia.post(route('projects.specific_objective', {project: project.id, specific_objective: $formSpecificObjective.id}), $formSpecificObjective, {
            onStart: ()     => { sending = true },
            onSuccess: ()   => { closeDialog() },
            onFinish: ()    => { sending = false },
            preserveScroll: true
        })
    }

    /**
     * Actividades
     */
     let formActivity = useForm({
        id: 0,
        indirect_cause_id: 0,
        specific_objective_id: 0,
        description: '',
        start_date: '',
        end_date: ''
    })

    let showActivityForm = false
    function showActivityDialog(activity, specificObjective) {
        code                                    = activity.id != null ? 'OBJ-ESP-' + specificObjective + '-ACT-' + activity.id : ''
        dialogTitle                             = 'Actividad'
        showPrimaryObjectiveForm                = false
        showSpecificObjectiveForm               = false
        showResultForm                          = false
        showImpactForm                          = false
        showGeneralInfo                         = false
        open                                    = true
        showActivityForm                        = true
        formID                                  = 'form-activity'
        $formActivity.id                        = activity.id;
        $formActivity.indirect_cause_id         = activity.indirect_cause_id;
        $formActivity.specific_objective_id     = specificObjective;
        $formActivity.description               = activity.description;
        $formActivity.start_date                = activity.start_date;
        $formActivity.end_date                  = activity.end_date;
    }

    function submitActivity() {
        Inertia.post(route('projects.activity', {call: call.id, project: project.id, activity: $formActivity.id}), $formActivity, {
            onStart: ()     => { sending = true },
            onSuccess: ()   => { closeDialog() },
            onFinish: ()    => { sending = false },
            preserveScroll: true
        })
    }

    function closeDialog() {
        dialogTitle = ''
        $formPrimaryObjective.reset()
        $formActivity.reset()
        $formSpecificObjective.reset()
        $formResult.reset()
        $formImpact.reset()
        open = false
        formID = ''
    }

    onMount(() => {

        const impact                        = document.querySelector('#impact-tooltip-placement')
        const impactTooltip                 = document.querySelector('#impact-tooltip')
        const arrowImpact                   = document.querySelector('#arrow-impact')

        const result                        = document.querySelector('#result-tooltip-placement')
        const resultTooltip                 = document.querySelector('#result-tooltip')
        const arrowResult                   = document.querySelector('#arrow-result')

        const primaryObjective              = document.querySelector('#primary-objective-tooltip-placement')
        const primaryObjectiveTooltip       = document.querySelector('#primary-objective-tooltip')
        const arrowPrimaryObjective         = document.querySelector('#arrow-primary-objective')

        const specificObjective             = document.querySelector('#specific-objective-tooltip-placement')
        const specificObjectiveTooltip      = document.querySelector('#specific-objective-tooltip')
        const arrowSpecificObjective        = document.querySelector('#arrow-specific-objective')

        const activity                      = document.querySelector('#activity-tooltip-placement')
        const activityTooltip               = document.querySelector('#activity-tooltip')
        const arrowActivity                 = document.querySelector('#arrow-activity')

        let tooltips = [{'element': {'target': impact, 'tooltip': impactTooltip, 'arrow': arrowImpact}}, {'element': {'target': result, 'tooltip': resultTooltip, 'arrow': arrowResult}}, {'element': {'target': primaryObjective, 'tooltip': primaryObjectiveTooltip, 'arrow': arrowPrimaryObjective}}, {'element': {'target': specificObjective, 'tooltip': specificObjectiveTooltip, 'arrow': arrowSpecificObjective}}, {'element': {'target': activity, 'tooltip': activityTooltip, 'arrow': arrowActivity}}]

        tooltips.map(function(tooltip) {
            createPopper(tooltip.element.target, tooltip.element.tooltip, {
                placement: 'left',
                modifiers: [
                    {
                        name: 'arrow',
                        options: {
                            element: tooltip.element.arrow,
                        },
                    },
                ],
            })
        })
	})
</script>

<style>
    .results.relative.flex-1:before {
        content: "";
        bottom: -40%;
        position: absolute;
        right: 50%;
        width: 2px;
        height: 57px;
        background: #ff906e;
    }

    .specific-objectives.relative.flex-1:before {
        content: "";
        top: -38%;
        position: absolute;
        right: 50%;
        width: 2px;
        height: 55px;
        background: #ff906e;
    }


    .line-height-1 {
        line-height: 1.2;
    }

    .tooltip {
        background-color: #2196f3;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
        position: relative;
        z-index: 9999;
    }

    .arrow,
    .arrow::before {
        position: absolute;
        background-color: #2196f3;
        width: 8px;
        height: 8px;
        background: inherit;
    }

    .arrow {
        visibility: hidden;
    }

    .arrow::before {
        visibility: visible;
        content: '';
        transform: rotate(45deg);
    }

    .tooltip[data-popper-placement^='left'] > .arrow {
        right: -4px;
    }

    :global(.mdc-dialog__surface) {
        width: 750px;
        max-width: calc(100vw - 32px) !important;
    }

    :global(.mdc-dialog__content) {
        padding-top: 40px !important;
    }

    :global(.mdc-dialog__title) {
        border-bottom: 1px solid rgba(0,0,0,.12);
        margin-bottom: 0;
    }

</style>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <div class="py-12">
        <h1 class="text-4xl text-center">Árbol de objetivos</h1>
        <p class="text-center">Debe generar el árbol de objetivos iniciando desde el objetivo general, los respectivos objetivos específicos, resultados, actividades e impactos.</p>

        <div class="mt-16">
            <div class="flex mb-14">
                {#each directEffects as directEffect, i}
                    <div class="flex-1">
                        <!-- Impactos -->
                        {#if i == 0}
                            <div id="impact-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                                <small>Impactos</small>
                                <div id="arrow-impact" class="arrow" data-popper-arrow></div>
                            </div>
                        {/if}
                        <div class="flex mb-14" id="{i==0?'impact-tooltip-placement' : ''}" aria-describedby="{i == 0 ? 'tooltip' : ''}">
                            {#each directEffect.indirect_effects as indirectEffect}
                                <div class="flex-1 results relative">
                                    <div on:click={showImpactDialog(indirectEffect.impact, indirectEffect.id, directEffect.project_result.id)} class="bg-orangered-light hover:bg-orangered-dark tree-label h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                        <p class="h-32 overflow-y-hidden p-2.5 text-sm text-white">
                                            {#if indirectEffect.impact}
                                                <small class="title block font-bold mb-2 line-height-1">RES-{directEffect.project_result.id}-IMP-{indirectEffect.impact.id}</small>
                                                {#if indirectEffect.impact.description != null && indirectEffect.impact.description.length>0}
                                                    {indirectEffect.impact.description}
                                                {/if}
                                            {/if}
                                        </p>
                                    </div>
                                </div>
                            {/each}
                            {#each {length: (3-directEffect.indirect_effects.length)} as _empty}
                                <div on:click={() => showGeneralInfoDialog(1)} class="flex-1 results relative">
                                    <div class="h-36 bg-gray-300 rounded shadow-lg hover:bg-gray-400 cursor-pointer mr-1.5">
                                        <p class="h-32 overflow-y-hidden p-2.5 text-sm text-white">
                                        </p>
                                    </div>
                                </div>
                            {/each}
                        </div>
                        <!-- Resultado -->
                        {#if i==0}
                            <div id="result-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                                <small>Resultados</small>
                                <div id="arrow-result" class="arrow" data-popper-arrow></div>
                            </div>
                        {/if}
                        <div class="results relative flex-1" id="{i == 0 ? 'result-tooltip-placement' : ''}" aria-describedby="{i == 0 ? 'tooltip' : ''}">
                            <div on:click={showResultDialog(directEffect.project_result)} class="bg-orangered-light hover:bg-orangered-dark tree-label h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                <p class="h-32 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                    <small class="title block font-bold mb-2 line-height-1">RES-{directEffect.project_result.id}</small>
                                    {#if directEffect.project_result.description != null && directEffect.project_result.description.length > 0}
                                        {directEffect.project_result.description}
                                    {/if}
                                </p>
                            </div>
                        </div>
                    </div>
                {/each}
            </div>

            <!-- Objetivo general -->
            <div id="primary-objective-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                <small>Objetivo general</small>
                <div id="arrow-primary-objective" class="arrow" data-popper-arrow></div>
            </div>
            <div class="primary-objective relative" id="primary-objective-tooltip-placement" aria-describedby="tooltip">
                <div on:click={showPrimaryObjectiveDialog} class="bg-orangered-light hover:bg-orangered-dark tree-label h-36 rounded shadow-lg cursor-pointer mr-1.5">
                    {#if project.primary_objective != null && project.primary_objective.length>0}
                        <p class="h-32 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            {project.primary_objective}
                        </p>
                    {/if}
                </div>
            </div>

            <div class="flex mt-14">
                {#each directCauses as directCause, i}
                    <div class="flex-1">
                        <!-- Objetivo específico -->
                        {#if i == 0}
                            <div id="specific-objective-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                                <small class="block line-height-1">Objetivos <br> específicos</small>
                                <div id="arrow-specific-objective" class="arrow" data-popper-arrow></div>
                            </div>
                        {/if}
                        <div class="specific-objectives relative flex-1" id="{i == 0 ? 'specific-objective-tooltip-placement' : ''}" aria-describedby="{i == 0 ? 'tooltip' : ''}">
                            <div on:click={showSpecificObjectiveDialog(directCause.specific_objective, (i + 1))} class="bg-orangered-light hover:bg-orangered-dark tree-label h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                <p class="h-32 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                    <small class="title block font-bold mb-2 line-height-1">OBJ-ESP-{directCause.specific_objective.id}</small>
                                    {#if directCause.specific_objective.description != null && directCause.specific_objective.description.length > 0}
                                        {directCause.specific_objective.description}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        <!-- Actividades -->
                        {#if i == 0}
                            <div id="activity-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                                <small>Actividades</small>
                                <div id="arrow-activity" class="arrow" data-popper-arrow></div>
                            </div>
                        {/if}
                        <div class="flex mt-14" id="{i == 0 ? 'activity-tooltip-placement' : ''}" aria-describedby="{i == 0 ? 'tooltip' : ''}">
                            {#each directCause.indirect_causes as indirectCause}
                                <div class="specific-objectives relative flex-1">
                                    <div on:click={showActivityDialog(indirectCause.activity, directCause.specific_objective.id)} class="bg-orangered-light hover:bg-orangered-dark tree-label h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                        <p class="h-32 overflow-y-hidden p-2.5 text-sm text-white">
                                            {#if indirectCause.activity}
                                                <small class="title block font-bold mb-2 line-height-1">OBJ-ESP-{directCause.specific_objective.id}-ACT-{indirectCause.activity.id}</small>
                                                {#if indirectCause.activity.description != null && indirectCause.activity.description.length > 0}
                                                    {indirectCause.activity.description}
                                                {/if}
                                            {/if}
                                        </p>
                                    </div>
                                </div>
                            {/each}
                            {#each {length: (3-directCause.indirect_causes.length)} as _empty,j}
                                <div id="{j}_empty_activity" on:click={() => showGeneralInfoDialog(2)} class="specific-objectives relative flex-1">
                                    <div class="h-36 bg-gray-300 rounded shadow-lg hover:bg-gray-400 cursor-pointer mr-1.5">
                                        <p class="h-32 overflow-y-hidden p-2.5 text-sm text-white"></p>
                                    </div>
                                </div>
                            {/each}
                        </div>
                    </div>
                {/each}
            </div>
        </div>
    </div>

    <!-- Dialog -->
    <Dialog
        bind:open
        scrimClickAction=""
        escapeKeyAction=""
        aria-labelledby="mandatory-title"
        aria-describedby="mandatory-content"
    >
        <Title id="mandatory-title">
            <div class="mb-10 text-center">
                <div class="text-primary">
                    {dialogTitle}
                </div>
                {#if code}
                    <small class="block text-primary-light">
                        Código: {code}
                    </small>
                {/if}
            </div>
            {#if formID}
                <div class="flex justify-end">
                    <div>
                        <Button on:click={closeDialog} type="button">
                            <LabelMUI>{$_('Cancel')}</LabelMUI>
                        </Button>

                        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit" form={formID}>
                            {$_('Save')}
                        </LoadingButton>
                    </div>
                </div>
            {/if}
        </Title>
        <Content id="mandatory-content">
            {#if showActivityForm}
                <form on:submit|preventDefault={submitActivity} id="form-activity">
                    <p class="mt-1 text-center">Fecha de ejecución</p>
                    <div class="mt-1 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" bind:value={$formActivity.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label id="end_date" class="ml-4 {errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" bind:value={$formActivity.end_date} required />
                            </div>
                        </div>
                    </div>
                    <div>
                        <InputError classes="text-center" message={errors.start_date} />
                        <InputError classes="text-center" message={errors.end_date} />
                    </div>
                    <div class="mt-4">
                        <Label id="description" value="Descripción" />
                        <Textarea id="description" error={errors.description} bind:value={$formActivity.description} required />
                    </div>
                </form>
            {:else if showSpecificObjectiveForm}
                <form on:submit|preventDefault={submitSpecificObjective} id="specific-objective-form">
                    <div class="mt-4">
                        <Label id="description" value="Descripción" />
                        <Textarea id="description" error={errors.description} bind:value={$formSpecificObjective.description} required />
                    </div>
                </form>
            {:else if showPrimaryObjectiveForm}
                <form on:submit|preventDefault={submitGeneralObjetive} id="primary-objective-form">
                    <div class="mt-4">
                        <Label for="primary_objective" value="Objetivo general" />
                        <Textarea id="primary_objective" error={errors.primary_objective} bind:value={$formPrimaryObjective.primary_objective} required />
                    </div>
                </form>
            {:else if showResultForm}
                <form on:submit|preventDefault={submitResult} id="result-form">
                    <p class="mt-4">
                        <strong>{specificObjectiveDescription.number}</strong>
                        <br>
                        {specificObjectiveDescription.description}
                    </p>
                    <div class="mt-4">
                        <Label for="type" value="Tipo" />
                        <Select id="type" items={types} bind:value={$formResult.type} selectedValue={$formResult.type} autocomplete="off" error={errors.type} placeholder="Seleccione un tipo" required />
                    </div>
                    <div class="mt-4">
                        <Label for="description" value="Descripción" />
                        <Textarea id="description" maxlength="200" rows="4" error={errors.description} bind:value={$formResult.description} required />
                    </div>
                    <div class="mt-4">
                        <Label for="trl" value="TRL" />
                        <Input id="trl" type="number" max="9" min="1" class="block w-full" error={errors.trl} bind:value={$formResult.trl} required />
                    </div>
                    <div class="mt-4">
                        <Label for="indicator" value="Indicador" />
                        <Textarea id="indicator" maxlength="200" rows="4" error={errors.indicator} bind:value={$formResult.indicator} required />
                    </div>
                    <div class="mt-4">
                        <Label for="means_of_verification" value="Medio de verificación" />
                        <Textarea id="means_of_verification" maxlength="200" rows="4" error={errors.means_of_verification} bind:value={$formResult.means_of_verification} required />
                        <InputError message={errors.means_of_verification} />
                    </div>
                </form>
            {:else if showImpactForm}
                <form on:submit|preventDefault={submitImpact} id="impact-form">
                    <div class="mt-4">
                        <Label id="description" value="Descripción" />
                        <Textarea id="description" error={errors.description} bind:value={$formImpact.description} required />
                    </div>
                </form>
            {:else if showGeneralInfo}
                {#if generalInfoType == 1}
                    <p>Para poder editar este impacto, primero debe generar el efecto indirecto en el árbol de problemas.</p>
                {/if}
                {#if generalInfoType == 2}
                    <p>Para poder editar esta actividad, primero debe generar la causa indirecta en el árbol de problemas.</p>
                {/if}

                <div class="mt-8">
                    <Button on:click={closeDialog} type="button">
                        <LabelMUI>{$_('Cancel')}</LabelMUI>
                    </Button>
                </div>
            {/if}
        </Content>
    </Dialog>
</AuthenticatedLayout>
