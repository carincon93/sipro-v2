<script>
    import { Inertia } from '@inertiajs/inertia'
    import { useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import DataTable from '@/Components/DataTable'
    import LoadingButton from '@/Components/LoadingButton'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'

    export let errors
    export let call
    export let project
    let result = [];

    /**
     * Permisos
     */
     let authUser = $page.props.auth.user
    let isSuperAdmin =
        authUser.roles.filter(function (role) {
            return role.id == 1
        }).length > 0
    let canCreateRDI =
        authUser.can.find((element) => element == 'rdi.create') == 'rdi.create'
    let canEditRDI =
        authUser.can.find((element) => element == 'rdi.edit') == 'rdi.edit'

    let canCreateOrUpdate = isSuperAdmin
        ? undefined
        : canCreateRDI
        ? undefined
        : canEditRDI
        ? undefined
        : true

    /**
     * Buscar
     */

    let form = useForm({
        search_teams: '',
    })
    let sending=false;
    let sended=false;

    function submit() {
        sending=true;
        sended=false;
        try {
            axios.post(route('calls.projects.participants.teams', {call:call.id, project: project.id}), $form )
            .then(response => {
                result = response.data;
                sending=false;
                sended=true;
            })
            .catch(error=>{
                sending=false;
            });
        } catch (error) {
            sending=false;
        }
    }

    function linkTeam(id){
        Inertia.post(route('calls.projects.participants.teams.link', {
                    project: project.id,
                    call: call.id,
                }), {research_team_id:id});
    }

    function disableTeam(id){
        Inertia.post(route('calls.projects.participants.teams.unlink', {
                    project: project.id,
                    call: call.id,
                }), {research_team_id:id, _method:'DELETE'});
    }
</script>

<h1 class="text-4xl text-center">Semilleros de investigación</h1>
<p class="text-center w-1/3 m-auto mt-8">
    Realiza la búsqueda de semilleros de investigación
</p>

<form on:submit|preventDefault={submit} on:input={()=>sended=false}>
    <div class="p-8">
        <div class="mt-4 flex flex-row">
            <Input
                id="search_teams"
                type="search"
                placeholder="Escriba el nombre completo del semillero de investigación"
                class="mt-1 m-auto block flex-1"
                minlength="4"
                bind:value={$form.search_teams}
                required
            />
            <LoadingButton
                loading={sending}
                class="btn-indigo m-auto ml-1"
                type="submit"
            >
                {$_('Search')}
            </LoadingButton>
        </div>
    </div>
</form>
{#if sended}
<DataTable class="mt-10">
    <div slot="title">Resultados</div>

    <thead slot="thead">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Nombre</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Linea</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Grupo</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Acciones</th
            >
        </tr>
    </thead>
    <tbody slot="tbody">
        {#each result as rs (rs.id)}
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    <p
                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                    >
                        {rs.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.research_line.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.research_line.research_group.name} - {rs.research_line.research_group.acronym}
                    </p>
                </td>
                <td class="border-t td-actions">
                    <ResourceMenu>
                        <Item
                            on:SMUI:action={() =>
                                linkTeam(rs.id)}
                        >
                            <Text>{$_('Link up')}</Text>
                        </Item>
                    </ResourceMenu>
                </td>
            </tr>
        {/each}

        {#if result.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4"
                    >{$_('No data recorded')}</td
                >
            </tr>
        {/if}
    </tbody>
</DataTable>
{/if}
<DataTable class="mt-10">
    <div slot="title">Semilleros de investigación asignados</div>

    <thead slot="thead">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Nombre</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Linea</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Grupo</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Acciones</th
            >
        </tr>
    </thead>
    <tbody slot="tbody">
        {#each project.research_teams as rteam (rteam.id)}
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    <p
                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                    >
                        {rteam.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rteam.research_line.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rteam.research_line.research_group.name} - {rteam.research_line.research_group.acronym}
                    </p>
                </td>
                <td class="border-t td-actions">
                    <ResourceMenu>
                        <Item
                            on:SMUI:action={() =>
                                disableTeam(rteam.id)}
                        >
                            <Text>{$_('Disable')}</Text>
                        </Item>
                    </ResourceMenu>
                </td>
            </tr>
        {/each}

        {#if project.research_teams.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4"
                    >{$_('No data recorded')}</td
                >
            </tr>
        {/if}
    </tbody>
</DataTable>