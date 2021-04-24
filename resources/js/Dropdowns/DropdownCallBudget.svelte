<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import InputError from '@/Components/InputError'
    import Label from '@/Components/Label'

    export let classes  = ''
    export let message
    export let sennovaBudget
    export let selectedBudgetUsage
    export let required
    export let enabled

    let selectedSecondBudgetInfoID
    let selectedThirdBudgetInfoID

    let secondBudgetInfo    = []
    let thirdBudgetInfo     = []
    let budgetUsages        = []

    onMount(() => {
        getSecondBudgetInfo()
        sennovaBudget?.call_budget?.sennova_budget?.second_budget_info_id ? getThirdBudgetInfo(sennovaBudget?.call_budget?.sennova_budget?.second_budget_info_id) : null
        sennovaBudget?.call_budget?.sennova_budget?.third_budget_info_id ? getBudgetUsages(sennovaBudget?.call_budget?.sennova_budget?.second_budget_info_id, sennovaBudget?.call_budget?.sennova_budget?.third_budget_info_id) : null
	})

    async function getSecondBudgetInfo() {
        let res   = await axios.get(route('web-api.second-budget-info'))
        secondBudgetInfo = res.data
    }

    function handleSecondBudgetInfo(e) {
        selectedSecondBudgetInfoID = e.target.value
        getThirdBudgetInfo(selectedSecondBudgetInfoID)
    }

    async function getThirdBudgetInfo(secondBudgetInfoID) {
        thirdBudgetInfo     = []
        budgetUsages        = []
        let res   = await axios.get(route('web-api.third-budget-info', [secondBudgetInfoID]))
        thirdBudgetInfo = res.data
    }

    function handleThirdBudgetInfo(e) {
        selectedThirdBudgetInfoID = e.target.value
        getBudgetUsages(selectedSecondBudgetInfoID, selectedThirdBudgetInfoID)
    }

    async function getBudgetUsages(secondBudgetInfoID, thirdBudgetInfoID) {
        let res   = await axios.get(route('web-api.budget-usages', [secondBudgetInfoID, thirdBudgetInfoID]))
        budgetUsages = res.data
    }

    async function checkIfBudgetRequiresMarketResearch(e) {
        let res = await axios.get(route('web-api.budget-requires-market-research', [e.target.value]))
        enabled = res.data.requires_market_research
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
    <Label id="second_budget_info_id" value="Concepto interno SENA" {required} />
    <!-- svelte-ignore a11y-no-onchange -->
    <select id="second_budget_info_id" class="budget-info w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-200 focus:ring-indigo-200 {classes}" on:change={(e) => handleSecondBudgetInfo(e)}>
        <option value="">Seleccione el concepto interno SENA</option>
        {#each secondBudgetInfo as {value, label}}
            <option value={value} selected={sennovaBudget?.call_budget?.sennova_budget?.second_budget_info_id == value ? true : false}>{label}</option>
        {/each}
    </select>
</div>

<div class="mt-4">
    <Label id="third_budget_info_id" value="Rubro" {required} />
    <!-- svelte-ignore a11y-no-onchange -->
    <select id="third_budget_info_id" disabled={!(thirdBudgetInfo.length > 0)} class="budget-info w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-200 focus:ring-indigo-200 {classes}" on:change={(e) => handleThirdBudgetInfo(e)}>
        <option value="">Seleccione el rubro</option>
        {#each thirdBudgetInfo as {value, label}}
            <option class="shadow p-8 hover:bg-gray-100" value={value} selected={sennovaBudget?.call_budget?.sennova_budget?.third_budget_info_id == value ? true : false}>{label}</option>
        {/each}
    </select>
</div>

<div class="mt-4">
    <Label id="budget_usage_id" value="Uso presupuestal" {required} />
    <!-- svelte-ignore a11y-no-onchange -->
    <select id="budget_usage_id" disabled={!(budgetUsages.length > 0)} class="budget-info w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:border-indigo-200 focus:ring-indigo-200 {classes}" bind:value={selectedBudgetUsage} on:change={(e) => checkIfBudgetRequiresMarketResearch(e)}>
        <option value="">Seleccione el uso presupuestal</option>
        {#each budgetUsages as {value, label}}
            <option class="shadow p-8 hover:bg-gray-100" value={value} selected={sennovaBudget?.call_budget?.id == value ? true : false}>{label}</option>
        {/each}
    </select>
    <InputError {message} />
</div>

