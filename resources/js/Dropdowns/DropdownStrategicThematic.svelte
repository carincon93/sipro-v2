<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message
    export let formStrategicThematic

    let strategicThematics          = []
    let strategicThematicFiltered   = null

    onMount(() => {
        getStrategicThematics()
	})

    async function getStrategicThematics() {
        let res       = await axios.get(route('web-api.strategic-thematics'))
        strategicThematics = res.data
        selectResearchLine()
    }

    function handleStrategicThematic(event) {
        formStrategicThematic = event.detail.value
    }

    function selectResearchLine() {
        if (formStrategicThematic) {
            let filterItem = strategicThematics.filter(function(strategicThematic) {
                return strategicThematic.value == formStrategicThematic;
            })
            strategicThematicFiltered = filterItem[0]
        }
    }
</script>

<style>
    :global(.strategic-thematics .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.strategic-thematics .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={strategicThematicFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la temática estrategica SENA" containerClasses="strategic-thematics {classes}" items={strategicThematics} on:select={handleStrategicThematic} />
<InputError {message} />
