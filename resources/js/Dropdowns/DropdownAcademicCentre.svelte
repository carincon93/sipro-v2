<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes  = ''
    export let id       = ''
    export let message
    export let formAcademicCentre

    let academicCentres           = []
    let academmicCentreFiltered    = null

    onMount(() => {
        getAcademicCentres()
	})

    async function getAcademicCentres() {
        let res   = await axios.get(route('web-api.academic-centres'))
        academicCentres = res.data
        selectAcademicCentre()
    }

    function handleAcademicCentre(event) {
        formAcademicCentre = event.detail.value
    }

    function selectAcademicCentre() {
        if (formAcademicCentre) {
            let filterItem = academicCentres.filter(function(academicCentre) {
                return academicCentre.value == formAcademicCentre;
            })
            academmicCentreFiltered = filterItem[0]
        }
    }

</script>

<style>
    :global(.academic-centres .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.academic-centres .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={academmicCentreFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre del centro de formación" containerClasses="academic-centres {classes}" items={academicCentres} on:select={handleAcademicCentre} />
<InputError {message} />
