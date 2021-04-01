<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message

    let knowledgeSubareaDisciplines = []

    onMount(() => {
        getKnowledgeSubareaDisciplines()
	})

    async function getKnowledgeSubareaDisciplines() {
        let res       = await axios.get(route('web-api.knowledge-subarea-disciplines'))
        knowledgeSubareaDisciplines = res.data
    }

    function handleKnowledgeSubareaDiscipline(event) {
        console.log(event.detail)
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

<Select inputAttributes={{'id': id}} placeholder="Busque por el nombre de la disciplina de subáreas de conocimiento" containerClasses="knowledge-subarea-disciplines {classes}" items={knowledgeSubareaDisciplines} on:select={handleKnowledgeSubareaDiscipline} />
<InputError {message} />
