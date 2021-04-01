<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message

    let knowledgeNetworks = []

    onMount(() => {
        getKnowledgeNetworks()
	})

    async function getKnowledgeNetworks() {
        let res       = await axios.get(route('web-api.knowledge-networks'))
        knowledgeNetworks = res.data
    }

    function handleKnowledgeNetwork(event) {
        console.log(event.detail)
    }
</script>

<style>
    :global(.knowledge-networks .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.knowledge-networks .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select inputAttributes={{'id': id}} placeholder="Busque por el nombre de la red de conocimiento sectorial" containerClasses="knowledge-networks {classes}" items={knowledgeNetworks} on:select={handleKnowledgeNetwork} />
<InputError {message} />
