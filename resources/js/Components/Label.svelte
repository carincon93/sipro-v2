<script>
    export let id
    export let value
    export let required

    $: props = {
      ...$$restProps,
      class: `block font-medium text-sm text-gray-700 ${$$restProps.class || ''}`,
    }
</script>

{#if value}
    <label {...props} for={id}>{value} {#if required}<small class="text-red-400 block">* Campo obligatorio</small> {/if}</label>
{/if}
