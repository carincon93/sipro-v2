<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message
    export let formResearchLine

    let researchLines           = []
    let researchLineFiltered    = null

    onMount(() => {
        getResearchLines()
	})

    async function getResearchLines() {
        let res       = await axios.get(route('web-api.research-lines'))
        researchLines = res.data
        selectResearchLine()
    }

    function handleResearchLine(event) {
        formResearchLine = event.detail.value
    }

    function selectResearchLine() {
        if (formResearchLine) {
            let filterItem = researchLines.filter(function(researchLine) {
                return researchLine.value == formResearchLine;
            })
            researchLineFiltered = filterItem[0]
        }
    }
</script>

<style>
    :global(.research-lines .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.research-lines .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={researchLineFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la línea de investigación, centro de formación, grupo de investigación o regional" containerClasses="research-lines {classes}" items={researchLines} on:select={handleResearchLine} />
<InputError {message} />
