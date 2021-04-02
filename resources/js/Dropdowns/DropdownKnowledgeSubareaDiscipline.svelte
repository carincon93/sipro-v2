<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message
    export let formKnowledgeSubareaDiscipline

    let knowledgeSubareaDisciplines         = []
    let knowledgeSubareaDisciplineFiltered  = null

    onMount(() => {
        getKnowledgeSubareaDisciplines()
	})

    async function getKnowledgeSubareaDisciplines() {
        let res       = await axios.get(route('web-api.knowledge-subarea-disciplines'))
        knowledgeSubareaDisciplines = res.data
        selectKnowledgeSubareaDiscipline()
    }

    function handleKnowledgeSubareaDiscipline(event) {
        formKnowledgeSubareaDiscipline = event.detail.value
    }

    function selectKnowledgeSubareaDiscipline() {
        if (formKnowledgeSubareaDiscipline) {
            let filterItem = knowledgeSubareaDisciplines.filter(function(knowledgeSubareaDiscipline) {
                return knowledgeSubareaDiscipline.value == formKnowledgeSubareaDiscipline;
            })
            knowledgeSubareaDisciplineFiltered = filterItem[0]
        }
    }
</script>

<style>
    :global(.knowledge-subarea-disciplines .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.knowledge-subarea-disciplines .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={knowledgeSubareaDisciplineFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la disciplina de subáreas de conocimiento" containerClasses="knowledge-subarea-disciplines {classes}" items={knowledgeSubareaDisciplines} on:select={handleKnowledgeSubareaDiscipline} />
<InputError {message} />
