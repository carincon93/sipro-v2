<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'
    import Stepper from '@/Components/Stepper.svelte'
    import Gantt from '@/Components/Gantt.svelte';

    export let call
    export let project
    export let activities

    $title = 'Actividades'

    let filters = {}

</script>

<Stepper {call} {project} />

<h1 class="mb-8 font-bold text-3xl">{$_("Activities.plural")}</h1>
<div class="mb-6 flex justify-between items-center">

</div>

<Gantt items={activities.data} />
