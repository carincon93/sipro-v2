<script>
    export let id
    export let value

    $: props = {
      ...$$restProps,
      class: `fblock font-medium text-sm text-gray-700 ${$$restProps.class || ''}`,
    }
</script>

{#if value}
    <label {...props} for={id}>{value}</label>
{/if}
