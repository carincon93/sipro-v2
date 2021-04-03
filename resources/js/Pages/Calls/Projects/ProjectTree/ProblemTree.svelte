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
                <div class="flex-1">
                    <!-- Efectos indirectos -->
                    <div id="efecto-indirecto-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Efectos indirectos</small>
                        <div id="arrow-efecto-indirecto" class="arrow" data-popper-arrow></div>
                    </div>
                    <div class="flex mb-14" id="efecto-indirecto" aria-describedby="tooltip">
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Efecto directo -->
                    <div id="efecto-directo-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Efectos directos</small>
                        <div id="arrow-efecto-directo" class="arrow" data-popper-arrow></div>
                    </div>
                    <div class="efectos-directos relative flex-1" id="efecto-directo" aria-describedby="tooltip">
                        <div class="tree-label h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Efectos -->
                <div class="flex-1">
                    <!-- Efectos indirectos -->
                    <div class="flex mb-14">
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Efecto directo -->
                    <div class="efectos-directos relative flex-1">
                        <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Efectos -->
                <div class="flex-1">
                    <!-- Efectos indirectos -->
                    <div class="flex mb-14">
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Efecto directo -->
                    <div class="efectos-directos relative flex-1">
                        <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Efectos -->
                <div class="flex-1">
                    <!-- Efectos indirectos -->
                    <div class="flex mb-14">
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="flex-1 efectos-directos relative">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Efecto directo -->
                    <div class="efectos-directos relative flex-1">
                        <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Problema central -->
            <div id="problema-central-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                <small>Problema central</small>
                <div id="arrow-problema-central" class="arrow" data-popper-arrow></div>
            </div>
            <div class="problema-central relative" id="problema-central" aria-describedby="tooltip">
                <div class="h-36 bg-indigo-500 rounded shadow-lg hover:bg-indigo-600 cursor-pointer mr-1.5">
                    <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis. Proin tincidunt volutpat nunc non congue. Fusce vel lacinia est, ac iaculis magna. Aliquam vestibulum, ex ut sodales blandit, mauris magna porttitor turpis, vitae vehicula sem erat eget risus. Cras sit amet neque commodo nisl hendrerit vulputate. Praesent varius urna a quam aliquet consequat...
                    </p>
                </div>
            </div>

            <!-- Causas -->
            <div class="flex mt-14">
                <div class="flex-1">
                    <!-- Causa directa -->
                    <div id="causa-directa-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                        <small>Causas directas</small>
                        <div id="arrow-causa-directa" class="arrow" data-popper-arrow></div>
                    </div>
                    <div class="causas-directas relative flex-1" id="causa-directa" aria-describedby="tooltip">
                        <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <!-- Causas indirectas -->
                    <div class="flex mt-14">
                        <div id="causa-indirecta-tooltip" class="tooltip" role="tooltip" data-popper-placement="left">
                            <small>Causas indirectas</small>
                            <div id="arrow-causa-indirecta" class="arrow" data-popper-arrow></div>
                        </div>
                        <div class="causas-directas relative flex-1" id="causa-indirecta" aria-describedby="tooltip">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Causas -->
                <div class="flex-1">
                    <!-- Causa directa -->
                    <div class="causas-directas relative flex-1">
                        <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <!-- Causas indirectas -->
                    <div class="flex mt-14">
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Causas -->
                <div class="flex-1">
                    <!-- Causa directa -->
                    <div class="causas-directas relative flex-1">
                        <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <!-- Causas indirectas -->
                    <div class="flex mt-14">
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-400 rounded shadow-lg hover:bg-indigo-500 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Causas -->
                <div class="flex-1">
                    <!-- Causa directa -->
                    <div class="causas-directas relative flex-1">
                        <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                            <p class="h-5/6 overflow-hidden text-white p-2.5 text-sm line-height-1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                            </p>
                        </div>
                    </div>
                    <!-- Causas indirectas -->
                    <div class="flex mt-14">
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
                                <p class="h-5/6 line-height-1 overflow-y-hidden p-2.5 text-sm text-white">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget est a dui molestie fringilla eu id magna. Morbi metus tellus, malesuada ut mi et, dapibus tristique felis...
                                </p>
                            </div>
                        </div>
                        <div class="causas-directas relative flex-1">
                            <div class="h-36 bg-indigo-300 rounded shadow-lg hover:bg-indigo-400 cursor-pointer mr-1.5">
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
</AuthenticatedLayout>

