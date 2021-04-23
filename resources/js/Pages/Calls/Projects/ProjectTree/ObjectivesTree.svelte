<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
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
    import Textarea from '@/Components/Textarea'
    import Select from 'svelte-select'
    import fitTextarea from 'fit-textarea'
    import Stepper from '@/Components/Stepper'

    import { createPopper } from '@popperjs/core'

    export let errors
    export let call
    export let project
    export let directEffects
    export let directCauses;
    let specific_objectives = [];
    const types = [
        {label:'Generación del conocimiento (GNC)', value:'GNC'},
        {label:'Desarrollo tecnólogico (DT)', value:'DT'},
        {label:'Apropiación social del conocimiento (ASC)', value:'ASC'},
        {label:'Formación de recurso humano (FRH)', value:'FRH'}
    ];

    $: $title = project ? project.title : null

    let modal_general_open = false;
    let modal_general_type = 0;
    function modal_general_show(type){
        console.log(type);
        modal_general_type = type;
        modal_general_open = true;
    };

    let sending     = false;

    let formIMP = remember({
        id:0,
        indirect_effect_id:0,
        description:'',
        result_id:''
    })
    let modal_open_imp  = false
    function modal_show_imp(IMP, indirect_effect_id, result_id){

        if(IMP!=null){
            formIMP.description=IMP.description; formIMP.id=IMP.id; formIMP.indirect_effect_id=IMP.indirect_effect_id; formIMP.result_id=result_id;
        }else{
            formIMP.id=null;formIMP.indirect_effect_id=indirect_effect_id;; formIMP.result_id='';
        }
        modal_open_imp = true;
    };
    function modal_hide_imp() {formIMP.description='';formIMP.id=0;formIMP.indirect_effect_id=0;modal_open_imp = false};

    function submitImpact() {
        Inertia.post(route('projects.impact', {project:project.id, impact:formIMP.id}), formIMP, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hide_imp(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    let formRES = remember({
        id:0,
        specific_objective_id:0,
        description:'',
        type:'',
        trl:1,
        indicator:'',
        means_of_verification:''
    })
    let modal_openRES  = false;
    function modal_showRES(RES){

        formRES.id=RES.id;
        formRES.specific_objective_id= specific_objectives.find(item => item.value == RES.specific_objective_id );//RES.specific_objective_id;
        formRES.description=RES.description;
        formRES.type= types.find(item => item.value == RES.type );//RES.type;
        formRES.trl=RES.trl;
        formRES.indicator=RES.indicator;
        formRES.means_of_verification=RES.means_of_verification;
        modal_openRES = true;
        console.log(formRES);
    };
    function modal_hideRES() {
        formRES = remember({
            id:0,
            specific_objective_id:0,
            description:'',
            type:'',
            trl:1,
            indicator:'',
            means_of_verification:''
        });
        modal_openRES = false;
    };

    function submitResult() {
        console.log(formRES);
        Inertia.post(route('projects.research_result', {project:project.id, research_result:formRES.id}), formRES, {
            onStart: ()     =>  {sending = true;},
            onSuccess: ()   =>  modal_hideRES(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    let formOG = remember({
        primary_objective:   project.primary_objective
    })
    let modal_openOG  = false
    const modal_showOG = event => modal_openOG = true;
    const modal_hideOG = event => modal_openOG = false;

    function submitGeneralObjetive() {
        Inertia.post(route('projects.primary_objective', project.id), formOG, {
            onStart: ()     =>{ sending = true;},
            onSuccess: ()   =>  modal_openOG = false,
            onFinish: ()    => {sending = false;},
        })
    }

    let formOS = remember({
        id:0,
        description:'',
        number:0
    })
    let modal_openOS  = false;
    function modal_showOS(OS){formOS.description=OS.description;formOS.id=OS.id;formOS.number=OS.number;modal_openOS = true;};
    function modal_hideOS(){formOS.description='';formOS.id=0;formOS.number=0;modal_openOS = false};

    function submitSpecificObjective() {
        Inertia.post(route('projects.specific_objective', {project:project.id, specific_objective:formOS.id}), formOS, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hideOS(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    let formAC = remember({
        id:0,
        indirect_cause_id:0,
        specific_objective_id:0,
        description:'',
        start_date:'',
        end_date:''
    })
    let modal_openAC  = false
    function modal_showAC(AC, specific_objective_id){
        formAC.description=AC.description;formAC.indirect_cause_id=AC.indirect_cause_id;formAC.id=AC.id;formAC.specific_objective_id=specific_objective_id;
        modal_openAC = true;
    };
    function modal_hideAC() {formAC.description='';formAC.indirect_cause_id=0;formAC.id=0;formAC.specific_objective_id=0;modal_openAC = false};

    function submitActivity() {
        Inertia.post(route('projects.activity', {call:call.id, project:project.id, activity:formAC.id}), formAC, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hideAC(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    onMount(() => {
        directCauses.forEach(effect => {
            specific_objectives.push({value:effect.specific_objective.id, label:'OBJ-ESP-'+effect.specific_objective.id});
        });

		const textareas = document.querySelectorAll('textarea')
        fitTextarea.watch(textareas)

        const impacto           = document.querySelector('#impacto')
        const impactoTooltip    = document.querySelector('#impacto-tooltip')
        const arrowImpacto      = document.querySelector('#arrow-impacto')

        const resultado           = document.querySelector('#resultado')
        const resultadoTooltip    = document.querySelector('#resultado-tooltip')
        const arrowResultado      = document.querySelector('#arrow-resultado')

        const objetivoGeneral           = document.querySelector('#objetivo-general')
        const objetivoGeneralTooltip    = document.querySelector('#objetivo-general-tooltip')
        const arrowObjetivoGeneral      = document.querySelector('#arrow-objetivo-general')

        const objetivoEspecifico           = document.querySelector('#objetivo-especifico')
        const objetivoEspecificoTooltip    = document.querySelector('#objetivo-especifico-tooltip')
        const arrowObjetivoEspecifico      = document.querySelector('#arrow-objetivo-especifico')

        const actividad           = document.querySelector('#actividad')
        const actividadTooltip    = document.querySelector('#actividad-tooltip')
        const arrowActividad      = document.querySelector('#arrow-actividad')

        let tooltips = [{'element': {'target': impacto, 'tooltip': impactoTooltip, 'arrow': arrowImpacto}}, {'element': {'target': resultado, 'tooltip': resultadoTooltip, 'arrow': arrowResultado}}, {'element': {'target': objetivoGeneral, 'tooltip': objetivoGeneralTooltip, 'arrow': arrowObjetivoGeneral}}, {'element': {'target': objetivoEspecifico, 'tooltip': objetivoEspecificoTooltip, 'arrow': arrowObjetivoEspecifico}}, {'element': {'target': actividad, 'tooltip': actividadTooltip, 'arrow': arrowActividad}}]

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
    .resultados.relative.flex-1:before {
        content: "";
        bottom: -40%;
        position: absolute;
        right: 50%;
        width: 2px;
        height: 57px;
        background: #b1e0b3;
    }

    .objetivos-especificos.relative.flex-1:before {
        content: "";
        top: -38%;
        position: absolute;
        right: 50%;
        width: 2px;
        height: 55px;
        background: #b1e0b3;
    }


    .line-height-1 {
        line-height: 1;
    }

    .tooltip {
        background-color: #ff46b2;
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
        background-color: #ff46b2;
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
</style>

<AuthenticatedLayout>

    <Stepper {call} {project} />

    <div class="py-12">
        <h1 class="text-4xl text-center">Árbol de objetivos</h1>
        <p class="text-center">Debe generar el árbol de objetivos desde el objetivo general, objetivos específicos e impactos.</p>

        <div class="mt-16">
            <div class="flex mb-14">
                {#each directEffects as efect, i}
                <div class="flex-1">
                    <!-- Impactos -->
                    {#if i==0}
                    <div id="impacto-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Impactos</small>
                        <div id="arrow-impacto" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <div class="flex mb-14" id="{i==0?'impacto':''}" aria-describedby="{i==0?'tooltip':''}">
                        {#each efect.indirect_effects as indirect_efect}
                        <div class="flex-1 resultados relative">
                            <div on:click={modal_show_imp(indirect_efect.impact, indirect_efect.id, efect.research_result.id)} class="{indirect_efect.impact && indirect_efect.impact.description!=null?'bg-green-500 hover:bg-green-600':'bg-green-400 hover:bg-green-500'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    {#if indirect_efect.impact}
                                        <small class="title">Cod: RES-{efect.research_result.id}-IMP-{indirect_efect.impact.id}</small><br><br>
                                        {#if indirect_efect.impact.description != null && indirect_efect.impact.description.length>0}
                                        {indirect_efect.impact.description}
                                        {/if}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        {/each}
                        {#each {length: (3-efect.indirect_effects.length)} as _empty}
                        <div on:click={event => modal_general_show(1)} class="flex-1 resultados relative">
                            <div class="h-36 bg-gray-300 rounded shadow-lg hover:bg-gray-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                </p>
                            </div>
                        </div>
                        {/each}
                    </div>
                    <!-- Resultado -->
                    {#if i==0}
                    <div id="resultado-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Resultados</small>
                        <div id="arrow-resultado" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <div class="resultados relative flex-1" id="{i==0?'resultado':''}" aria-describedby="{i==0?'tooltip':''}">
                        <div on:click={modal_showRES(efect.research_result)} class="{efect.research_result.description!=null?'bg-green-500 hover:bg-green-600':'bg-green-400 hover:bg-green-500'} tree-label h-36 rounded shadow-lg cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                <small class="title">Cod: RES-{efect.research_result.id}</small><br><br>
                                {#if efect.research_result.description != null && efect.research_result.description.length>0}
                                {efect.research_result.description}
                                {/if}
                            </p>
                        </div>
                    </div>
                </div>
                {/each}
            </div>

            <!-- Objetivo general -->
            <div id="objetivo-general-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                <small>Objetivo general</small>
                <div id="arrow-objetivo-general" class="arrow" data-popper-arrow></div>
            </div>
            <div class="objetivo-general relative" id="objetivo-general" aria-describedby="tooltip">
                <div on:click={modal_showOG} class="{project.primary_objective!=null?'bg-green-500 hover:bg-green-600':'bg-green-400 hover:bg-green-500'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                    {#if project.primary_objective != null && project.primary_objective.length>0}
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            {project.primary_objective}
                        </p>
                    {/if}
                </div>
            </div>

            <div class="flex mt-14">
                {#each directCauses as cause, i}
                <div class="flex-1">
                    <!-- Objetivo específico -->
                    {#if i==0}
                    <div id="objetivo-especifico-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Objetivos <br> específicos</small>
                        <div id="arrow-objetivo-especifico" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <div class="objetivos-especificos relative flex-1" id="{i==0?'objetivo-especifico':''}" aria-describedby="{i==0?'tooltip':''}">
                        <div on:click={modal_showOS(cause.specific_objective)} class="{cause.specific_objective.description!=null?'bg-green-500 hover:bg-green-600':'bg-green-400 hover:bg-green-500'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                <small class="title">Cod: OBJ-ESP-{cause.specific_objective.id}</small><br><br>
                                {#if cause.specific_objective.description != null && cause.specific_objective.description.length>0}
                                {cause.specific_objective.description}
                                {/if}
                            </p>
                        </div>
                    </div>
                    <!-- Actividades -->
                    {#if i==0}
                    <div id="actividad-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Actividades</small>
                        <div id="arrow-actividad" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <div class="flex mt-14" id="{i==0?'actividad':''}" aria-describedby="{i==0?'tooltip':''}">
                        {#each cause.indirect_causes as indirect_cause}
                        <div class="objetivos-especificos relative flex-1">
                            <div on:click={modal_showAC(indirect_cause.activity, cause.specific_objective.id)} class="{indirect_cause.activity && indirect_cause.activity.description!=null?'bg-green-500 hover:bg-green-600':'bg-green-400 hover:bg-green-500'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    {#if indirect_cause.activity}
                                        <small class="title">Cod: OBJ-ESP-{cause.specific_objective.id}-ACT-{indirect_cause.activity.id}</small><br><br>
                                        {#if indirect_cause.activity.description != null && indirect_cause.activity.description.length>0}
                                        {indirect_cause.activity.description}
                                        {/if}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        {/each}
                        {#each {length: (3-cause.indirect_causes.length)} as _empty,j}
                        <div id="{j}_empty_activity" on:click={event => modal_general_show(2)} class="objetivos-especificos relative flex-1">
                            <div class="h-36 bg-gray-300 rounded shadow-lg hover:bg-gray-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                </p>
                            </div>
                        </div>
                        {/each}
                    </div>
                </div>
                {/each}
            </div>
        </div>
    </div>
    
    <!-- Modal seccion no definida -->
    <Modal bind:open={modal_general_open} >
        <Card>
            <div class="p-4">
                {#if modal_general_type==1}
                <h2>Para poder editar este impacto, primero debe generar el efecto indirecto en el arbol de problemas.</h2>
                {/if}
                {#if modal_general_type==2}
                <h2>Para poder editar esta actividad, primero debe generar la causa indirecta en el arbol de problemas.</h2>
                {/if}
            </div>
        </Card>
    </Modal>
    <!-- Modal editar impacto -->
    <Modal bind:open={modal_open_imp}>
        <Card>
            <form on:submit|preventDefault={submitImpact} class="p-4">
                <h2>
                    Describa el impacto Cod. <b>{formIMP.id!=null?'RES-'+formIMP.result_id+'-IMP-'+formIMP.id:''}</b>:
                </h2>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formIMP.description} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={()=>modal_hide_imp()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar resultado -->
    <Modal bind:open={modal_openRES}>
        <Card>
            <form on:submit|preventDefault={submitResult} class="p-4">
                <h2>
                    Describa el resultado Cod. <b>RES-{formRES.id}</b>:
                </h2>
                <div class="mt-4">
                    <Label id="specific_objective_id" value="Objetivo especifico" />
                    <Select items={specific_objectives} bind:selectedValue={formRES.specific_objective_id} autocomplete="off" placeholder="Relacione un objetivo especifico"/>
                    <InputError message={errors.specific_objective_id} />
                </div>
                <div class="mt-4">
                    <Label for="type" value="Tipo" />
                    <Select id="type" items={types} bind:selectedValue={formRES.type} autocomplete="off" placeholder="Seleccione un tipo"/>
                    <InputError message={errors.type} />
                </div>
                <div class="mt-4">
                    <Label for="description" value="Descripción" />
                    <Textarea id="description" maxlength="200" rows="4" error={errors.description} bind:value={formRES.description} required />
                    <InputError message={errors.description} />
                </div>
                <div class="mt-4">
                    <Label for="trl" value="TRL" />
                    <Input id="trl" type="number" max="9" min="1" class="block w-full" bind:value={formRES.trl} required />
                    <InputError message={errors.trl} />
                </div>
                <div class="mt-4">
                    <Label for="indicator" value="Indicador" />
                    <Textarea id="indicator" maxlength="200" rows="4" error={errors.indicator} bind:value={formRES.indicator} required />
                    <InputError message={errors.indicator} />
                </div>
                <div class="mt-4">
                    <Label for="means_of_verification" value="Medio de verificación" />
                    <Textarea id="means_of_verification" maxlength="200" rows="4" error={errors.means_of_verification} bind:value={formRES.means_of_verification} required />
                    <InputError message={errors.means_of_verification} />
                </div>
                <div class="is-right">
                    <button  on:click={()=>modal_hideRES()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar objetivo general -->
    <Modal bind:open={modal_openOG}>
        <Card>
            <form on:submit|preventDefault={submitGeneralObjetive} class="p-4">
                <h2>
                    Describa el objetivo general del proyecto:
                </h2>
                <div class="mt-4">
                    <Label for="primary_objective" value="Problema central" />
                    <Textarea id="primary_objective" error={errors.primary_objective} bind:value={formOG.primary_objective} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={modal_hideOG} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar Objetivo especifico -->
    <Modal bind:open={modal_openOS}>
        <Card>
            <form on:submit|preventDefault={submitSpecificObjective} class="p-4">
                <h2>Describa el objetivo específico Cod. <b>OBJ-ESP-{formOS.id}</b>:</h2>
                <div class="mt-4">
                    <Label for="number" value="Número" />
                    <Input id="number" type="number" class="block w-full" bind:value={formOS.number} required />
                    <InputError message={errors.number} />
                </div>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formOS.description} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={()=>modal_hideOS()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar actividad -->
    <Modal bind:open={modal_openAC}>
        <Card>
            <form on:submit|preventDefault={submitActivity} class="p-4">
                <h2>
                    Describa la actividad Cod. <b>{formAC.id!=null?'OBJ-ESP-'+formAC.specific_objective_id+'-ACT-'+formAC.id:''}</b>:
                </h2>
                <p class="mt-1 text-center">Fecha de ejecución</p>
                <div class="mt-1 flex items-start justify-around">
                    <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                        <Label id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                        <div class="ml-4">
                            <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={formAC.start_date} required />
                        </div>
                    </div>
                    <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                        <Label id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                        <div class="ml-4">
                            <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={formAC.end_date} required />
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formAC.description} required />
                </div>
                <div class="is-right">
                    <button  on:click={()=>modal_hideAC()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
</AuthenticatedLayout>
