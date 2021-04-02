<script>
    export let id
    export let value

    $: props = {
      ...$$restProps,
      class: `block font-medium text-sm text-gray-700 ${$$restProps.class || ''}`,
    }
</script>

{#if value}
    <label {...props} for={id}>{value}</label>
{/if}
