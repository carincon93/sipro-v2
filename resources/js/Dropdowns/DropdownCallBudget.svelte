<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import InputError from '@/Components/InputError'
    import Label from '@/Components/Label'

    export let classes  = ''
    export let id       = ''
    export let message
    export let selectedBudgetUsage

    let selectedSecondBudgetInfo
    let selectedThirdBudgetInfo

    let secondBudgetInfo    = []
    let thirdBudgetInfo     = []
    let budgetUsages        = []

    onMount(() => {
        getSecondBudgetInfo()
	})

    async function getSecondBudgetInfo() {
        let res   = await axios.get(route('web-api.second-budget-info'))
        secondBudgetInfo = res.data
    }

    async function handleSecondBudgetInfo(e) {
        thirdBudgetInfo     = []
        budgetUsages        = []
        selectedSecondBudgetInfo = e.target.value
        let res   = await axios.get(route('web-api.third-budget-info', [selectedSecondBudgetInfo]))
        thirdBudgetInfo = res.data
    }

    async function handleThirdBudgetInfo(e) {
        selectedThirdBudgetInfo = e.target.value
        let res   = await axios.get(route('web-api.budget-usages', [selectedSecondBudgetInfo, selectedThirdBudgetInfo]))
        budgetUsages = res.data
    }

</script>

<style>
    :global(.budget-info .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.budget-info .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<div class="mt-4">
    <Label id="second_budget_info_id" value="Concepto interno SENA" />
    <!-- svelte-ignore a11y-no-onchange -->
    <select id="second_budget_info_id" class="budget-info w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-200 focus:ring-indigo-200 {classes}" on:change={(e) => handleSecondBudgetInfo(e)}>
        <option value="">Seleccione el concepto interno SENA</option>
        {#each secondBudgetInfo as {value, label}}
            <option value={value}>{label}</option>
        {/each}
    </select>
</div>

<div class="mt-4">
    <Label id="third_budget_info_id" value="Rubro" />
    <!-- svelte-ignore a11y-no-onchange -->
    <select id="third_budget_info_id" disabled={!(thirdBudgetInfo.length > 0)} class="budget-info w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-200 focus:ring-indigo-200 {classes}" on:change={(e) => handleThirdBudgetInfo(e)}>
        <option value="">Seleccione el rubro</option>
        {#each thirdBudgetInfo as {value, label}}
            <option class="shadow p-8 hover:bg-gray-100" value={value}>{label}</option>
        {/each}
    </select>
</div>

<div class="mt-4">
    <Label id="budget_usage_id" value="Uso presupuestal" />
    <select id="budget_usage_id" disabled={!(budgetUsages.length > 0)} class="budget-info w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-200 focus:ring-indigo-200 {classes}" bind:value={selectedBudgetUsage}>
        <option value="">Seleccione el uso presupuestal</option>
        {#each budgetUsages as {value, label}}
            <option class="shadow p-8 hover:bg-gray-100" value={value}>{label}</option>
        {/each}
    </select>
    <InputError {message} />
</div>

