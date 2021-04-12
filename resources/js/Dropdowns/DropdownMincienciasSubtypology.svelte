<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message
    export let formMincienciasSubtypology

    let mincienciasSubtypologies         = []
    let mincienciasSubtypologyFiltered   = null

    onMount(() => {
        getMincienciasSubtypologies()
	})

    async function getMincienciasSubtypologies() {
        let res       = await axios.get(route('web-api.minciencias-subtypologies'))
        mincienciasSubtypologies = res.data
        selectResearchLine()
    }

    function handleMincienciasSubtypology(event) {
        formMincienciasSubtypology = event.detail.value
    }

    function selectResearchLine() {
        if (formMincienciasSubtypology) {
            let filterItem = mincienciasSubtypologies.filter(function(mincienciasSubtypology) {
                return mincienciasSubtypology.value == formMincienciasSubtypology;
            })
            mincienciasSubtypologyFiltered = filterItem[0]
        }
    }
</script>

<style>
    :global(.minciencias-subtypologies .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.minciencias-subtypologies .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={mincienciasSubtypologyFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la subtipología Minciencias" containerClasses="minciencias-subtypologies {classes}" items={mincienciasSubtypologies} on:select={handleMincienciasSubtypology} />
<InputError {message} />
