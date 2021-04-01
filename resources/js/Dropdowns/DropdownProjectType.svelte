<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message

    let projectTypes = []

    onMount(() => {
        getProjectTypes()
	})

    async function getProjectTypes() {
        let res       = await axios.get(route('web-api.project-types'))
        projectTypes = res.data
    }

    function handleProjectType(event) {
        console.log(event.detail)
    }
</script>

<style>
    :global(.project-types .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.project-types .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select inputAttributes={{'id': id}} placeholder="Busque por el nombre del tipo de proyecto, línea programática" containerClasses="project-types {classes}" items={projectTypes} on:select={handleProjectType} />
<InputError {message} />
