<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes  = ''
    export let id       = ''
    export let message
    export let formProgrammaticLine

    let programmaticLines           = []
    let programmaticLineFiltered    = null

    onMount(() => {
        getProgrammaticLine()
	})

    async function getProgrammaticLine() {
        let res   = await axios.get(route('web-api.programmatic-lines'))
        programmaticLines = res.data
        selectProgrammaticLine()
    }

    function handleProgrammaticLine(event) {
        formProgrammaticLine = event.detail.value
    }

    function selectProgrammaticLine() {
        if (formProgrammaticLine) {
            let filterItem = programmaticLines.filter(function(programmaticLine) {
                return programmaticLine.value == formProgrammaticLine;
            })
            programmaticLineFiltered = filterItem[0]
        }
    }

</script>

<style>
    :global(.programmatic-lines .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.programmatic-lines .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={programmaticLineFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la línea programática" containerClasses="programmatic-lines {classes}" items={programmaticLines} on:select={handleProgrammaticLine} />
<InputError {message} />
