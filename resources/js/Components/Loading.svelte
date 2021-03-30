<script>
    import { Jumper } from 'svelte-loading-spinners'

    export let loading = true
    export let bg = 'white'
</script>

{#if !loading}
    <div class="absolute left-0 right-0 w-full flex items-center justify-center bg-{bg} top-0 bottom-0">
        <Jumper size="60" color="#FF3E00" unit="px" duration="1s" />
    </div>
{/if}
