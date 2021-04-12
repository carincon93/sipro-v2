<script>
    import { onMount } from 'svelte'
    import axios from 'axios'
    import Select from 'svelte-select'
    import InputError from '@/Components/InputError'

    export let classes  = ''
    export let id       = ''
    export let message
    export let formProjectSennovaRole
    export let call
    export let programmaticLine
    export let qtyMonths
    export let qtyRoles
    export let qtyMonthsByDefault
    export let qtyRolesByDefault

    let projectSennovaRoles           = []
    let projectSennovaRoleFiltered    = null

    onMount(() => {
        getProjectSennovaRoles()
	})

    async function getProjectSennovaRoles() {
        let res   = await axios.get(route('web-api.calls.project-sennova-roles', [call.id, programmaticLine]))
        projectSennovaRoles = res.data
        selectProjectSennovaRole()
    }

    function handleProjectSennovaRole(event) {
        formProjectSennovaRole  = event.detail.value
        qtyMonthsByDefault      = event.detail.qtyMonthsByDefault
        qtyRolesByDefault       = event.detail.qtyRolesByDefault
        qtyMonths               = event.detail.qty_months
        qtyRoles                = event.detail.qty_roles
    }

    function selectProjectSennovaRole() {
        if (formProjectSennovaRole) {
            let filterItem = projectSennovaRoles.filter(function(projectSennovaRole) {
                return projectSennovaRole.value == formProjectSennovaRole;
            })
            projectSennovaRoleFiltered = filterItem[0]
        }
    }

</script>

<style>
    :global(.project-sennova-roles .listItem) {
        border-bottom: 1px solid #ccc;
    }

    :global(.project-sennova-roles .item) {
        height: auto !important;
        line-height: 1.6 !important;
        text-overflow: initial!important;
        overflow: initial !important;
        white-space: break-spaces !important;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>

<Select selectedValue={projectSennovaRoleFiltered} inputAttributes={{'id': id}} placeholder="Busque por el nombre del rol" containerClasses="project-sennova-roles {classes}" items={projectSennovaRoles} on:select={handleProjectSennovaRole} />
<InputError {message} />
