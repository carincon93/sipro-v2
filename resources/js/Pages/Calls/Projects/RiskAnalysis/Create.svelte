<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'
    import Textarea from '@/Components/Textarea'

    export let call
    export let project
    export let errors

    $: $title = $_('Create') + ' ' + $_('Risk analysis.singular').toLowerCase()

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin           = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexRiskAnalysis   = authUser.can.find(element => element == 'risk-analysis.index') == 'risk-analysis.index'
    let canShowRiskAnalysis    = authUser.can.find(element => element == 'risk-analysis.show') == 'risk-analysis.show'
    let canCreateRiskAnalysis  = authUser.can.find(element => element == 'risk-analysis.create') == 'risk-analysis.create'
    let canEditRiskAnalysis    = authUser.can.find(element => element == 'risk-analysis.edit') == 'risk-analysis.edit'
    let canDeleteRiskAnalysis  = authUser.can.find(element => element == 'risk-analysis.delete') == 'risk-analysis.delete'

    let sending = false
    let form = useForm({
        level:  '',
        type:  '',
        description:  '',
        impact:  '',
        probability:  '',
        effects:  '',
        mitigation_measures: ''

    })

    let riskLevels = [{'value': 1, 'label': 'A nivel del objetivo general'}, {'value': 2, 'label': 'A nivel de productos'}, {'value': 3, 'label': 'A nivel de actividades'}]
    let types = [{'value': 1, 'label': 'Mercado'}, {'value': 2, 'label': 'Operacionales'}, {'value': 3, 'label': 'Legales'}, {'value': 4, 'label': 'Administrativos'}]
    let probabilities = [{'value': 1, 'label': 'Posible'}, {'value': 2, 'label': 'Probable'}]
    let impacts = [{'value': 1, 'label': 'Alto'}, {'value': 2, 'label': 'Moderado'}, {'value': 2, 'label': 'Leve'}]

    function submit() {
        if (canCreateRiskAnalysis || isSuperAdmin) {
            Inertia.post(route('calls.projects.risk-analysis.store', [call.id, project.id]), $form, {
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
                    {#if canIndexRiskAnalysis || canCreateRiskAnalysis || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.risk-analysis.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Risk analysis.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Create')}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <div class="p-8">
                <div class="mt-4">
                    <Label required class="mb-4" labelFor="level" value="Nivel de riesgo" />
                    <Select items={riskLevels} bind:selectedValue={$form.level} autocomplete="off"  placeholder="Seleccione el nivel del riesgo" inputAttributes={{'id': 'level'}} />
                    <InputError message={errors.level} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="type" value="Tipo de riesgo" />
                    <Select items={types} bind:selectedValue={$form.type} autocomplete="off"  placeholder="Seleccione el tipo de riesgo" inputAttributes={{'id': 'type'}} />
                    <InputError message={errors.type} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="description" value="Descripción" />
                    <Textarea rows="4" id="description" error={errors.description} bind:value={$form.description} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="probability" value="Probabilidad" />
                    <Select items={probabilities} bind:selectedValue={$form.probability} autocomplete="off"  placeholder="Seleccione la probabilidad" inputAttributes={{'id': 'probability'}} />
                    <InputError message={errors.probability} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="impact" value="Impactos" />
                    <Select items={impacts} bind:selectedValue={$form.impact} autocomplete="off"  placeholder="Seleccione la probabilidad" inputAttributes={{'id': 'impact'}} />
                    <InputError message={errors.impact} />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="effects" value="Efectos" />
                    <Textarea rows="4" id="effects" error={errors.effects} bind:value={$form.effects} required />
                </div>

                <div class="mt-4">
                    <Label required class="mb-4" labelFor="mitigation_measures" value="Medidas de mitigación" />
                    <Textarea rows="4" id="mitigation_measures" error={errors.mitigation_measures} bind:value={$form.mitigation_measures} required />
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canCreateRiskAnalysis || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Create')} {$_('Risk analysis.singular')}
                    </LoadingButton>
                {/if}
            </div>
        </form>
    </div>
</AuthenticatedLayout>
