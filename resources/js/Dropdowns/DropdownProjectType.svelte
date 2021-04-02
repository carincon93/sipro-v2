<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message
    export let formProjectType

    let projectTypes        = []
    let projectTypeFiltered = null

    onMount(() => {
        getProjectTypes()
	})

    async function getProjectTypes() {
        let res         = await axios.get(route('web-api.project-types'))
        projectTypes    = res.data
        selectProjectType()
    }

    function handleProjectType(event) {
        formProjectType = event.detail.value
    }

    function selectProjectType() {
        if (formProjectType) {
            let filterItem = projectTypes.filter(function(projectType) {
                return projectType.value == formProjectType;
            })
            projectTypeFiltered = filterItem[0]
        }
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

<Select selectedValue={projectTypeFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre del tipo de proyecto, línea programática" containerClasses="project-types {classes}" items={projectTypes} on:select={handleProjectType} />
<InputError {message} />
