<script>
    import Button, { Label } from '@smui/button'

    export let variant = 'raised'
    export let href

    $: props = {
        ...$$restProps,
        class: `${$$restProps.class || ''}`,
    }
</script>

<style>
    :global(.mdc-button) {
        height: auto;
        min-height: 36px;
    }
</style>

<Button {...props} {href} variant={variant} height="100px" action={null} on:click>
    <Label>
        <slot />
    </Label>
</Button>
