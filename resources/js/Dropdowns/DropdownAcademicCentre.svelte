<script>
    import { afterUpdate, onMount } from 'svelte'
    import axios from 'axios'
    import { _ } from 'svelte-i18n'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes  = ''
    export let id       = ''
    export let message
    export let formAcademicCentre
    export let required

    let academicCentres           = []
    let academmicCentreFiltered   = null
    let select                    = null

    onMount(() => {
        getAcademicCentres()
        select = document.getElementById(id)
	})

    afterUpdate(() => {
        if (required) {
            formAcademicCentre != null && select != null ? select.setCustomValidity('') : select.setCustomValidity($_('Please fill out this field.'))
        }
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
