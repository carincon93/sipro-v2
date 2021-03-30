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

    import { createPopper } from '@popperjs/core'

    export let errors
    export let call
    export let project

    $: $title = project ? project.title : null

    let modal_open  = false
    let sending     = false
    let form        = remember({
        title:          project.title,
        start_date:     project.start_date,
        end_date:       project.end_date,
    })

    onMount(() => {
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

<Stepper {call} {project} />

<div class="py-12">
    <h1 class="text-4xl text-center">Árbol de objetivos</h1>
    <p class="text-center">Debe generar el árbol de objetivos desde el objetivo general, objetivos específicos e impactos.</p>

    <div class="mt-16">
        <div class="flex mb-14">
            <div class="flex-1">
                <!-- Impactos -->
                <div id="impacto-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                    <small>Impactos</small>
                    <div id="arrow-impacto" class="arrow" data-popper-arrow></div>
                </div>
                <div class="flex mb-14" id="impacto" aria-describedby="tooltip">
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Resultado -->
                <div id="resultado-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                    <small>Resultados</small>
                    <div id="arrow-resultado" class="arrow" data-popper-arrow></div>
                </div>
                <div class="resultados relative flex-1" id="resultado" aria-describedby="tooltip">
                    <div class="tree-label h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Impactos -->
                <div class="flex mb-14">
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Resultado -->
                <div class="resultados relative flex-1">
                    <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Impactos -->
                <div class="flex mb-14">
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Resultado -->
                <div class="resultados relative flex-1">
                    <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Impactos -->
                <div class="flex mb-14">
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="flex-1 resultados relative">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Resultado -->
                <div class="resultados relative flex-1">
                    <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Objetivo general -->
        <div id="objetivo-general-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
            <small>Objetivo general</small>
            <div id="arrow-objetivo-general" class="arrow" data-popper-arrow></div>
        </div>
        <div class="objetivo-general relative" id="objetivo-general" aria-describedby="tooltip">
            <div class="h-36 bg-green-500 rounded shadow-lg hover:bg-green-600 cursor-pointer mr-1.5">
                <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis. Proin tincidunt volutpat nunc non congue. Fusce vel lacinia est, ac iaculis magna. Aliquam vestibulum, ex ut sodales blandit, mauris magna porttitor turpis, vitae vehicula sem erat eget risus. Cras sit amet neque commodo nisl hendrerit vulputate. Praesent varius urna a quam aliquet consequat...
                </p>
            </div>
        </div>

        <div class="flex mt-14">
            <div class="flex-1">
                <!-- Objetivo específico -->
                <div id="objetivo-especifico-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                    <small>Objetivos <br> específicos</small>
                    <div id="arrow-objetivo-especifico" class="arrow" data-popper-arrow></div>
                </div>
                <div class="objetivos-especificos relative flex-1" id="objetivo-especifico" aria-describedby="tooltip">
                    <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
                <!-- Actividades -->
                <div class="flex mt-14">
                    <div id="actividad-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Actividades</small>
                        <div id="arrow-actividad" class="arrow" data-popper-arrow></div>
                    </div>
                    <div class="objetivos-especificos relative flex-1" id="actividad" aria-describedby="tooltip">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Objetivo específico -->
                <div class="objetivos-especificos relative flex-1">
                    <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
                <!-- Actividades -->
                <div class="flex mt-14">
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Objetivo específico -->
                <div class="objetivos-especificos relative flex-1">
                    <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
                <!-- Actividades -->
                <div class="flex mt-14">
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-400 rounded shadow-lg hover:bg-green-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Objetivo específico -->
                <div class="objetivos-especificos relative flex-1">
                    <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                        <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                        </p>
                    </div>
                </div>
                <!-- Actividades -->
                <div class="flex mt-14">
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <div class="objetivos-especificos relative flex-1">
                        <div class="h-36 bg-green-300 rounded shadow-lg hover:bg-green-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
