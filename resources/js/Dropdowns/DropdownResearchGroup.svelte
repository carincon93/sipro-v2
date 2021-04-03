<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes  = ''
    export let id       = ''
    export let message
    export let formResearchGroup

    let researchGroups            = []
    let researchGroupFiltered    = null

    onMount(() => {
        getProgrammaticLine()
	})

    async function getProgrammaticLine() {
        let res   = await axios.get(route('web-api.research-groups'))
        researchGroups = res.data
        selectResearchGroup()
    }

    function handleResearchGroup(event) {
        formResearchGroup = event.detail.value
    }

    function selectResearchGroup() {
        if (formResearchGroup) {
            let filterItem = researchGroups.filter(function(researchGroup) {
                return researchGroup.value == formResearchGroup;
            })
            researchGroupFiltered = filterItem[0]
        }
    }

</script>

<style>
    :global(.research-groups .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.research-groups .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={researchGroupFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre del grupo de investigación, acrónimo, centro de formación o regional" containerClasses="research-groups {classes}" items={researchGroups} on:select={handleResearchGroup} />
<InputError {message} />
