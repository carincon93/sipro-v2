<script>
    import Button, { Label } from '@smui/button'
    import { Inertia } from '@inertiajs/inertia'

    export let variant = 'raised'
    export let href

    function visit() {
        if (href) {
            Inertia.visit(href)
        }
    }

    $: props = {
        ...$$restProps,
        class: `${$$restProps.class || ''}`,
    }
</script>

<Button {...props} variant={variant} on:click={visit}>
    <Label>
        <slot />
    </Label>
</Button>
