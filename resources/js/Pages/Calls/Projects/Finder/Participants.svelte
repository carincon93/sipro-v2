<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import Stepper from '@/Components/Stepper.svelte'

    import AcademicProgramsFinder from './AcademicProgramsFinder.svelte'
    import ResearchTeamsFinder from './ResearchTeamsFinder.svelte'
    import UsersFinder from './UsersFinder.svelte'

    export let errors
    export let filters;
    export let call
    export let project
    export let documentTypes
    export let participationTypes

    $: $title = 'Participantes'
</script>

<AuthenticatedLayout>
    <Stepper {call} {project} />

    <div class="py-12">
        <div class="mt-16">
            <UsersFinder call={call} project={project} errors={errors} documentTypes={documentTypes} participationTypes={participationTypes} />
        </div>
        <hr class="my-16">
        <div>
            <ResearchTeamsFinder  call={call} project={project} errors={errors}/>
        </div>
        <hr class="my-16">
        <div>
            <AcademicProgramsFinder  call={call} project={project} errors={errors}/>
        </div>
    </div>
</AuthenticatedLayout>
