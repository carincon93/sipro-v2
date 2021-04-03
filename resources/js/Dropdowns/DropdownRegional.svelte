<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes  = ''
    export let id       = ''
    export let message
    export let formRegional

    let regional           = []
    let regionalFiltered    = null

    onMount(() => {
        getRegional()
	})

    async function getRegional() {
        let res   = await axios.get(route('web-api.regional'))
        regional = res.data
        selectRegional()
    }

    function handleRegional(event) {
        formRegional = event.detail.value
    }

    function selectRegional() {
        if (formRegional) {
            let filterItem = regional.filter(function(regional) {
                return regional.value == formRegional;
            })
            regionalFiltered = filterItem[0]
        }
    }

</script>

<style>
    :global(.regional .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.regional .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={regionalFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre de la regional" containerClasses="regional {classes}" items={regional} on:select={handleRegional} />
<InputError {message} />
