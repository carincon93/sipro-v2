<script>
    import { page } from '@inertiajs/inertia-svelte'
    import { _ } from 'svelte-i18n'
    import { SvelteToast, toast } from "@zerodevx/svelte-toast"
    import { afterUpdate } from 'svelte';

    let flashMessage

    afterUpdate(() => {

        let errorsLength = Object.keys($page.props.errors).length

        if ($page.props.flash.success) {
            flashMessage = $_($page.props.flash.success)
        } else if ($page.props.flash.error) {
            flashMessage = $page.props.flash.error
        } else if (errorsLength === 1) {
            flashMessage = $_("There is one form error.")
        } else if(errorsLength > 0) {
            flashMessage = $_('There are form errors.', { values: { count: errorsLength }})
        }
        if (flashMessage) {
            toast.pop()
            toast.push(flashMessage, {
                duration: 10000,
                theme: {
                '--toastBackground': 'rgba(31, 41, 55, var(--tw-bg-opacity))',
                '--toastColor': 'white',
                '--toastWidth': '100%',
                }
            })
        }

        // console.log($page.props.errors)
    })

</script>

<SvelteToast />
