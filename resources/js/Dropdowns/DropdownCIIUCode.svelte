<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes = ''
    export let id = ''
    export let message

    let ciiuCodes = []

    onMount(() => {
        getCIIUCodes()
	})

    async function getCIIUCodes() {
        let res       = await axios.get(route('web-api.ciiu-codes'))
        ciiuCodes = res.data
    }

    function handleCIIUCode(event) {
        console.log(event.detail)
    }
</script>

<style>
    :global(.ciiu-codes .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.ciiu-codes .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select inputAttributes={{'id': id}} placeholder="Busque por el nombre del código CIIU" containerClasses="ciiu-codes {classes}" items={ciiuCodes} on:select={handleCIIUCode} />
<InputError {message} />
