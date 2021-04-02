<script>
    export let message
    export let classes
</script>

{#if message}
    <div>
        <p class="text-red-400 mt-2 {classes}">
            { message }
        </p>
    </div>
{/if}
