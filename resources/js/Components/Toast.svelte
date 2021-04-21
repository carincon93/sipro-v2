<script>
    import { page } from '@inertiajs/inertia-svelte'
    import { _ } from 'svelte-i18n'
    import { toast } from '@zerodevx/svelte-toast'
    import { SvelteToast } from "@zerodevx/svelte-toast"
    import { afterUpdate } from 'svelte'

    let flashMessage

    afterUpdate(() => {
        if ($page.props.flash.success) {
            flashMessage = $_($page.props.flash.success)
        }

        let errorsLength = Object.keys($page.props.errors).length
        if (errorsLength === 1) {
            flashMessage = $_("There is one form error.")
        } else if(errorsLength > 0) {
            flashMessage = $_('There are form errors.', { values: { count: errorsLength }})
        }

        if (flashMessage) {
            toast.push(flashMessage, {
                theme: {
                '--toastBackground': 'rgba(31, 41, 55, var(--tw-bg-opacity))',
                '--toastColor': 'white',
                '--toastWidth': '100%',
                }
            })
        }
    })

</script>

<SvelteToast />
