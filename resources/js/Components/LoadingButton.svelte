<script>
    export let loading = false

    $: props = {
        ...$$restProps,
        class: `inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 ${$$restProps.class || ''}`,
    }
</script>

<button {...props} disabled={loading}>
    {#if loading}
        <div class="btn-spinner mr-2" />
    {/if}

    <slot />
</button>
