<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Stepper from '@/Components/Stepper.svelte'
    import Gantt from '@/Components/Gantt.svelte';

    export let call
    export let project
    export let activities

    $title = $_('Activities.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin            = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexActivities      = authUser.can.find(element => element == 'activities.index') == 'activities.index'
    let canShowActivities       = authUser.can.find(element => element == 'activities.show') == 'activities.show'
    let canCreateActivities     = authUser.can.find(element => element == 'activities.create') == 'activities.create'
    let canEditActivities       = authUser.can.find(element => element == 'activities.edit') == 'activities.edit'
    let canDeleteActivities     = authUser.can.find(element => element == 'activities.delete') == 'activities.delete'

    let filters = {}

</script>

<AuthenticatedLayout>
    <Stepper {call} {project} />

    <h1 class="font-bold text-3xl m-24 text-center">{$_('Activities.plural')}</h1>
    <div class="mb-6 flex justify-between items-center"></div>

    <Gantt items={activities.data} request={canEditActivities || isSuperAdmin ? {'uri': 'calls.projects.activities.edit', 'params': [call.id, project.id]} : null} />
</AuthenticatedLayout>

