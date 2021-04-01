<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message

    let strategicThematics = []

    onMount(() => {
        getStrategicThematics()
	})

    async function getStrategicThematics() {
        let res       = await axios.get(route('web-api.strategic-thematics'))
        strategicThematics = res.data
    }

    function handleStrategicThematic(event) {
        console.log(event.detail)
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

<Select inputAttributes={{'id': id}} placeholder="Busque por el nombre de la temática estrategica SENA" containerClasses="strategic-thematics {classes}" items={strategicThematics} on:select={handleStrategicThematic} />
<InputError {message} />
