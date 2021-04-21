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
    import fitTextarea from 'fit-textarea'
    import Stepper from '@/Components/Stepper'

    import { createPopper } from '@popperjs/core'

    export let errors
    export let call
    export let project
    export let directEffects
    export let directCauses

    $: $title = project ? project.title : null
    let sending     = false;

    let formEI = remember({
        id:0,
        direct_effect_id:0,
        description:''
    })
    let modal_openEI  = false
    function modal_showEI(EI, direct_effect_id){
        if(EI!=null){
            formEI.description=EI.description;formEI.id=EI.id;formEI.direct_effect_id=EI.direct_effect_id;
        }else{
            formEI.id=null;formEI.direct_effect_id=direct_effect_id;
        }
        modal_openEI = true;
    };
    function modal_hideEI() {formEI.description='';formEI.id=0;formEI.direct_effect_id=0;modal_openEI = false};

    function submitIndirectEffect() {
        Inertia.post(route('projects.indirect_effect', {project:project.id, direct_effect:formEI.direct_effect_id}), formEI, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hideEI(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    let formED = remember({
        id:0,
        description:''
    })
    let modal_openED  = false;
    function modal_showED(ED){formED.description=ED.description;formED.id=ED.id;modal_openED = true;};
    function modal_hideED() {formED.description='';formED.id=0;modal_openED = false};

    function submitDirectEffect() {
        Inertia.post(route('projects.direct_effect', {project:project.id, direct_effect:formED.id}), formED, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hideED(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    let formRP = remember({
        research_problem:   project.research_problem
    })
    let modal_openRP  = false
    const modal_showRP = event => modal_openRP = true;
    const modal_hideRP = event => modal_openRP = false;

    function submitGeneralProblem() {
        Inertia.post(route('projects.research_problem', project.id), $formRP, {
            onStart: ()     =>{ sending = true;},
            onSuccess: ()   =>  modal_openRP = false,
            onFinish: ()    => {sending = false;},
        })
    }

    let formCD = remember({
        id:0,
        description:''
    })
    let modal_openCD  = false;
    function modal_showCD(CD){formCD.description=CD.description;formCD.id=CD.id;modal_openCD = true;};
    function modal_hideCD() {formCD.description='';formCD.id=0;modal_openCD = false};

    function submitDirectCause() {
        Inertia.post(route('projects.direct_cause', {project:project.id, direct_cause:formCD.id}), formCD, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hideCD(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    let formCI = remember({
        id:0,
        direct_cause_id:0,
        description:''
    })
    let modal_openCI  = false
    function modal_showCI(CI, direct_cause_id){
        if(CI!=null){
            formCI.description=CI.description;formCI.id=CI.id;formCI.direct_cause_id=CI.direct_cause_id;
        }else{
            formCI.id=null;formCI.direct_cause_id=direct_cause_id;
        }
        modal_openCI = true;
    };
    function modal_hideCI() {formCI.description='';formCI.id=0;formCI.direct_cause_id=0;modal_openCI = false};

    function submitIndirectCause() {
        Inertia.post(route('projects.indirect_cause', {project:project.id, direct_cause:formCI.direct_cause_id}), formCI, {
            onStart: ()     =>  { sending = true;},
            onSuccess: ()   =>  modal_hideCI(),
            onFinish: ()    =>  {sending = false;},
        })
    }

    onMount(() => {
		const textareas = document.querySelectorAll('textarea')
        fitTextarea.watch(textareas)

        const efectoIndirecto           = document.querySelector('#efecto-indirecto')
        const efectoIndirectoTooltip    = document.querySelector('#efecto-indirecto-tooltip')
        const arrowEfectoIndirecto      = document.querySelector('#arrow-efecto-indirecto')

        const efectoDirecto           = document.querySelector('#efecto-directo')
        const efectoDirectoTooltip    = document.querySelector('#efecto-directo-tooltip')
        const arrowEfectoDirecto      = document.querySelector('#arrow-efecto-directo')

        const problemaCentral           = document.querySelector('#problema-central')
        const problemaCentralTooltip    = document.querySelector('#problema-central-tooltip')
        const arrowProblemaCentral      = document.querySelector('#arrow-problema-central')

        const causaDirecta           = document.querySelector('#causa-directa')
        const causaDirectaTooltip    = document.querySelector('#causa-directa-tooltip')
        const arrowCausaDirecta      = document.querySelector('#arrow-causa-directa')

        const causaIndirecta           = document.querySelector('#causa-indirecta')
        const causaIndirectaTooltip    = document.querySelector('#causa-indirecta-tooltip')
        const arrowCausaIndirecta      = document.querySelector('#arrow-causa-indirecta')

        let tooltips = [{'element': {'target': efectoIndirecto, 'tooltip': efectoIndirectoTooltip, 'arrow': arrowEfectoIndirecto}}, {'element': {'target': efectoDirecto, 'tooltip': efectoDirectoTooltip, 'arrow': arrowEfectoDirecto}}, {'element': {'target': problemaCentral, 'tooltip': problemaCentralTooltip, 'arrow': arrowProblemaCentral}}, {'element': {'target': causaDirecta, 'tooltip': causaDirectaTooltip, 'arrow': arrowCausaDirecta}}, {'element': {'target': causaIndirecta, 'tooltip': causaIndirectaTooltip, 'arrow': arrowCausaIndirecta}}]

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
    .efectos-directos.relative.flex-1:before {
        content: "";
        bottom: -40%;
        position: absolute;
        right: 50%;
        width: 2px;
        height: 57px;
        background: #d2d6ff;
    }

    .causas-directas.relative.flex-1:before {
        content: "";
        top: -38%;
        position: absolute;
        right: 50%;
        width: 2px;
        height: 55px;
        background: #d2d6ff;
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
        <h1 class="text-4xl text-center">Árbol de problemas</h1>
        <p class="text-center">Debe generar el árbol de problemas desde la problemática central, relacionando sus causas y efectos.</p>

        <div class="mt-16">
            <!-- Efectos -->
            <div class="flex mb-14">
                {#each directEffects as efect, i}
                <div class="flex-1">
                    {#if i==0}
                    <!-- Efectos indirectos -->
                    <div id="efecto-indirecto-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Efectos indirectos</small>
                        <div id="arrow-efecto-indirecto" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <div class="flex mb-14" id="{i==0?'efecto-indirecto':''}" aria-describedby="{i==0?'tooltip':''}">
                        {#each efect.indirect_effects as indirect_efect}
                        <div class="flex-1 efectos-directos relative">
                            <div on:click={modal_showEI(indirect_efect, efect.id)} class="{indirect_efect.description!=null?'bg-indigo-500 hover:bg-indigo-600':'bg-indigo-300 hover:bg-indigo-400'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    <small class="title">Cod: EFE-{efect.id}-IND-{indirect_efect.id}</small><br><br>
                                    {#if indirect_efect.description != null && indirect_efect.description.length>0}
                                    {indirect_efect.description}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        {/each}
                        {#each {length: (3-efect.indirect_effects.length)} as _empty}
                        <div class="flex-1 efectos-directos relative" on:click={modal_showEI(null, efect.id)}>
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                </p>
                            </div>
                        </div>
                        {/each}
                    </div>
                    {#if i==0}
                    <!-- Efecto directo -->
                    <div id="efecto-directo-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Efectos directos</small>
                        <div id="arrow-efecto-directo" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <!-- Efecto directo -->
                    <div class="efectos-directos relative flex-1"  id="{i==0?'efecto-directo':''}" aria-describedby="{i==0?'tooltip':''}">
                        <div on:click={modal_showED(efect)} class="{efect.description!=null?'bg-indigo-500 hover:bg-indigo-600':'bg-indigo-300 hover:bg-indigo-400'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                <small class="title">Cod: EFE-{efect.id}</small><br><br>
                                {#if efect.description != null && efect.description.length>0}
                                {efect.description}
                                {/if}
                            </p>
                        </div>
                    </div>
                </div>
                {/each}
            </div>

            <!-- Problema central -->
            <div id="problema-central-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                <small>Problema central</small>
                <div id="arrow-problema-central" class="arrow" data-popper-arrow></div>
            </div>
            <div class="problema-central relative" id="problema-central" aria-describedby="tooltip">
                <div on:click={modal_showRP} class="h-36 {project.research_problem!=null?'bg-indigo-500 hover:bg-indigo-600':'bg-indigo-300 hover:bg-indigo-400'} rounded shadow-lg cursor-pointer mr-1.5">
                    {#if project.research_problem != null && project.research_problem.length>0}
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            {project.research_problem}
                        </p>
                    {/if}
                </div>
            </div>

            <!-- Causas -->
            <div class="flex mt-14">
                {#each directCauses as cause, i}
                <div class="flex-1">
                    <!-- Causa directa -->
                    {#if i==0}
                    <div id="causa-directa-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Causas directas</small>
                        <div id="arrow-causa-directa" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <div class="causas-directas relative flex-1"  id="{i==0?'causa-directa':''}" aria-describedby="{i==0?'tooltip':''}">
                        <div on:click={modal_showCD(cause)} class="{cause.description!=null?'bg-indigo-500 hover:bg-indigo-600':'bg-indigo-300 hover:bg-indigo-400'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                <small class="title">Cod: CAU-{cause.id}</small><br><br>
                                {#if cause.description != null && cause.description.length>0}
                                {cause.description}
                                {/if}
                            </p>
                        </div>
                    </div>
                    
                    {#if i==0}
                    <div id="causa-indirecta-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Causas indirectas</small>
                        <div id="arrow-causa-indirecta" class="arrow" data-popper-arrow></div>
                    </div>
                    {/if}
                    <!-- Causas indirectas -->
                    <div class="flex mt-14" id="{i==0?'causa-indirecta':''}" aria-describedby="{i==0?'tooltip':''}">
                        {#each cause.indirect_causes as indirect_cause}
                        <div class="causas-directas relative flex-1">
                            <div on:click={modal_showCI(indirect_cause, cause.id)} class="{indirect_cause.description!=null?'bg-indigo-500 hover:bg-indigo-600':'bg-indigo-300 hover:bg-indigo-400'} h-36 rounded shadow-lg cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    <small class="title">Cod: CAU-{cause.id}-IND-{indirect_cause.id}</small><br><br>
                                    {#if indirect_cause.description != null && indirect_cause.description.length>0}
                                    {indirect_cause.description}
                                    {/if}
                                </p>
                            </div>
                        </div>
                        {/each}
                        {#each {length: (3-cause.indirect_causes.length)} as _empty}
                        <div class="causas-directas relative flex-1">
                            <div on:click={modal_showCI(null, cause.id)} class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
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
    <!-- Modal editar problema central -->
    <Modal bind:open={modal_openRP}>
        <Card>
            <form on:submit|preventDefault={submitGeneralProblem} class="p-4">
                <h2>
                    Describa el problema central del proyecto:
                </h2>
                <div class="mt-4">
                    <Label id="research_problem" value="Problema central" />
                    <Textarea id="research_problem" error={errors.research_problem} bind:value={formRP.research_problem} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={modal_hideRP} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar Efecto directo -->
    <Modal bind:open={modal_openED}>
        <Card>
            <form on:submit|preventDefault={submitDirectEffect} class="p-4">
                <h2>
                    Describa el efecto directo <b>EFE-{formED.id}</b>:
                </h2>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formED.description} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={()=>modal_hideED()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar Efecto indirecto -->
    <Modal bind:open={modal_openEI}>
        <Card>
            <form on:submit|preventDefault={submitIndirectEffect} class="p-4">
                <h2>
                    Describa el efecto indirecto <b>{formEI.id!=null?'EFE-'+formEI.direct_effect_id+'-IND-'+formEI.id:''}</b>:
                </h2>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formEI.description} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={()=>modal_hideEI()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar Causa directa -->
    <Modal bind:open={modal_openCD}>
        <Card>
            <form on:submit|preventDefault={submitDirectCause} class="p-4">
                <h2>
                    Describa la causa directa <b>CAU-{formCD.id}</b>:
                </h2>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formCD.description} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={()=>modal_hideCD()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
    <!-- Modal editar causa indirecta -->
    <Modal bind:open={modal_openCI}>
        <Card>
            <form on:submit|preventDefault={submitIndirectCause} class="p-4">
                <h2>
                    Describa la causa indirecta <b>{formCI.id!=null?'CAU-'+formCI.direct_cause_id+'-IND-'+formCI.id:''}</b>:
                </h2>
                <div class="mt-4">
                    <Label id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={formCI.description} required />
                </div>
                <div class="is-right">
                    
                    <button  on:click={()=>modal_hideCI()} type="button">{$_('Cancel')}</button>
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Confirm')}
                    </LoadingButton>
                </div>
            </form>
        </Card>
    </Modal>
</AuthenticatedLayout>