<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message
    export let formKnowledgeNetwork

    let knowledgeNetworks           = []
    let knowledgeNetworkFiltered    = null

    onMount(() => {
        getKnowledgeNetworks()
	})

    async function getKnowledgeNetworks() {
        let res       = await axios.get(route('web-api.knowledge-networks'))
        knowledgeNetworks = res.data
        selectKnowledgeNetwork()
    }

    function handleKnowledgeNetwork(event) {
        formKnowledgeNetwork = event.detail.value
    }

    function selectKnowledgeNetwork() {
        if (formKnowledgeNetwork) {
            let filterItem = knowledgeNetworks.filter(function(knowledgeNetwork) {
                return knowledgeNetwork.value == formKnowledgeNetwork;
            })
            knowledgeNetworkFiltered = filterItem[0]
        }
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

<Select selectedValue={knowledgeNetworkFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la red de conocimiento sectorial" containerClasses="knowledge-networks {classes}" items={knowledgeNetworks} on:select={handleKnowledgeNetwork} />
<InputError {message} />
