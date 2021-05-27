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
        search_programs: '',
    })
    let sending=false;
    let sended=false;

    function submit() {
        sending=true;
        sended=false;
        try {
            axios.post(route('calls.projects.participants.programs', {call:call.id, project: project.id}), $form )
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

    function linkProgram(id){
        Inertia.post(route('calls.projects.participants.programs.link', {
                    project: project.id,
                    call: call.id,
                }), {program_academic_id:id});
    }

    function disableProgram(id){
        Inertia.post(route('calls.projects.participants.programs.unlink', {
                    project: project.id,
                    call: call.id,
                }), {program_academic_id:id, _method:'DELETE'});
    }
</script>

<h1 class="text-4xl text-center title">Programas de formación</h1>
<p class="text-center w-1/3 m-auto mt-8">
    Realiza la búsqueda de programas de formación
</p>

<form on:submit|preventDefault={submit} on:input={()=>sended=false}>
    <div class="p-8">
        <div class="mt-4 flex flex-row">
            <Input
                id="search_programs"
                type="search"
                placeholder="Escriba el ID o el nombre completo del programa de formación"
                class="mt-1 m-auto block flex-1"
                bind:value={$form.search_programs}
                minlength="4"
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
                >Código</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Nombre</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Tipo</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Centro de formación</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Regional</th
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
                        {rs.code}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.study_mode}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.academic_centre.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.academic_centre.regional.name}
                    </p>
                </td>
                <td class="border-t td-actions">
                    <ResourceMenu>
                        <Item
                            on:SMUI:action={() =>
                                linkProgram(rs.id)}
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
    <div slot="title">Programas de formación asignados</div>

    <thead slot="thead">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Código</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Nombre</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Tipo</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Centro de formación</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Regional</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Acciones</th
            >
        </tr>
    </thead>
    <tbody slot="tbody">
        {#each project.academic_programs as ap (ap.id)}
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    <p
                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                    >
                        {ap.code}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {ap.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {ap.study_mode}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {ap.academic_centre.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {ap.academic_centre.regional.name}
                    </p>
                </td>
                <td class="border-t td-actions">
                    <ResourceMenu>
                        <Item
                            on:SMUI:action={() =>
                                disableProgram(ap.id)}
                        >
                            <Text>{$_('Remove')}</Text>
                        </Item>
                    </ResourceMenu>
                </td>
            </tr>
        {/each}

        {#if project.academic_programs.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4"
                    >{$_('No data recorded')}</td
                >
            </tr>
        {/if}
    </tbody>
</DataTable>