<script>
    import { Inertia } from '@inertiajs/inertia'
    import { useForm, page } from '@inertiajs/inertia-svelte'
    import axios from 'axios'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import InputError from '@/Components/InputError'
    import Label from '@/Components/Label'
    import Textarea from '@/Components/Textarea'
    import Select from '@/Components/Select'
    import DataTable from '@/Components/DataTable'
    import LoadingButton from '@/Components/LoadingButton'
    import ResourceMenu from '@/Components/ResourceMenu'
    import { Item, Text } from '@smui/list'
    import Dialog from '@/Components/Dialog'
    import Button from '@/Components/Button'
    import DynamicList from '@/Dropdowns/DynamicList'

    export let errors
    export let call
    export let project
    export let documentTypes
    export let participationTypes
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
        search_participants: '',
    })
    let formID
    let dialog_open = false
    let dialogTitle
    let sending=false;
    let sended=false;
    let authorTypes = [{label:'SI', value:1}, {label:'NO', value:0}];

    function submit() {
        sending=true;
        sended=false;
        try {
            axios.post(route('calls.projects.participants.users', {call:call.id, project: project.id}), $form )
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

    function disableParticipant(id){
        Inertia.post(route('calls.projects.participants.users.unlink', {
                    project: project.id,
                    call: call.id,
                }), {user_id:id, _method:'DELETE'});
    }

    
    /**
     * Participantes
     */
     let formParticipant = useForm({
        user_id: 0,
        is_author: 0,
        qty_months: 0,
        qty_hours: 0,
        _method:null
    })

    function showParticipant(user) {
        reset()
        dialogTitle = user.name
        dialog_open = true
        formID = 'participant-form'
        $formParticipant.user_id = user.id
        if(user.pivot && user.pivot){
            console.log((user.pivot.is_author)?1:0);
            $formParticipant._method = 'PUT';
            $formParticipant.is_author = (user.pivot.is_author)?1:0;
            $formParticipant.qty_months = user.pivot.qty_months;
            $formParticipant.qty_hours = user.pivot.qty_hours;
        }
    }

    function submitParticipant() {
        if (canCreateOrUpdate == undefined) {
            $formParticipant.post(
                route('calls.projects.participants.users.link', {
                    project: project.id,
                    call: call.id,
                }),
                {
                    onStart: () => {
                        sending = true
                    },
                    onSuccess: () => {
                        closeDialog()
                    },
                    onFinish: () => {
                        sending = false
                    },
                    preserveScroll: true,
                },
            )
        }
    }

    /**
     * Register Participantes
     */

    let formRegister = useForm({
        name: '',
        email: '',
        document_type: '',
        document_number: '',
        cellphone_number: '',
        participation_type: '',
        academic_centre_id: '',
        is_author: 0,
        qty_months: 0,
        qty_hours: 0
    })
    let formRegisterID
    let open_dialog_register = false

    function showRegister() {
        reset()
        open_dialog_register = true
        formRegisterID = 'participant-register-form'
    }

    function submitRegister() {
        $formRegister.post(route('calls.projects.participants.users.register', {call:call.id, project:project.id}),
        {
            onStart: () => {
                sending = true
            },
            onSuccess: () => {
                closeDialog()
            },
            onFinish: () => {
                sending = false
            },
            preserveScroll: true,
        })
    }

    function reset(){
        //participant form
        $formParticipant.user_id = 0
        $formParticipant.is_author = 0
        $formParticipant.qty_months = 0
        $formParticipant.qty_hours = 0
        $formParticipant._method = null
        //participant register form
        $formRegister.name = ''
        $formRegister.email = ''
        $formRegister.document_type = ''
        $formRegister.document_number = ''
        $formRegister.cellphone_number = ''
        $formRegister.participation_type = ''
        $formRegister.academic_centre_id = ''
        $formRegister.is_author = 0
        $formRegister.qty_months = 0
        $formRegister.qty_hours = 0
    }

    function closeDialog() {
        reset()
        dialog_open = false
        open_dialog_register = false
        sending = false
    }
    
</script>

<h1 class="text-4xl text-center">Proponentes</h1>
<p class="text-center w-1/3 m-auto mt-8">
    Realiza la búsqueda de proponentes por número de documento o correo
    electrónico institucional
</p>
<form on:submit|preventDefault={submit} on:input={()=>sended=false}>
    <div class="p-8">
        <div class="mt-4 flex flex-row">
            <Input
                id="search_participants"
                type="search"
                placeholder="Escriba el número de documento o el correo electrónico instiucional"
                class="mt-1 m-auto block flex-1"
                bind:value={$form.search_participants}
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
<DataTable class="mt-5">
    <div slot="title">Resultados</div>

    <thead slot="thead">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Nombre</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Email</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Documento</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Celular</th
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
                        {rs.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.email}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.document_number}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {rs.cellphone_number}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {(rs.academic_centre)?rs.academic_centre.name:''}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {(rs.academic_centre)?rs.academic_centre.regional.name:''}
                    </p>
                </td>
                <td class="border-t td-actions">
                    <ResourceMenu>
                        <Item
                            on:SMUI:action={() =>
                                showParticipant(rs)}
                        >
                            <Text>{$_('Link up')}</Text>
                        </Item>
                    </ResourceMenu>
                </td>
            </tr>
        {/each}

        {#if result.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4">
                    {$_('No data recorded')}
                    <Button on:click={()=>showRegister()} type="button" variant={null}>
                        {$_('Create participant')}
                    </Button>
                </td>
            </tr>
        {/if}
    </tbody>
</DataTable>
{/if}

<DataTable class="mt-10">
    <div slot="title">Proponentes Vinculados</div>

    <thead slot="thead">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Nombre</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Email</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Centro de formación</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Regional</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Es autor?</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Meses</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Horas</th
            >
            <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl"
                >Acciones</th
            >
        </tr>
    </thead>
    <tbody slot="tbody">
        {#each project.participants as part (part.id)}
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                    <p
                        class="px-6 py-4 flex items-center focus:text-indigo-500"
                    >
                        {part.name}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {part.email}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {(part.academic_centre)?part.academic_centre.name:''}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {(part.academic_centre)?part.academic_centre.regional.name:''}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {(part.pivot.is_author)?'Si':'No'}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {part.pivot.qty_months}
                    </p>
                </td>
                <td class="border-t">
                    <p class="px-6 py-4 flex items-center">
                        {part.pivot.qty_hours}
                    </p>
                </td>
                <td class="border-t td-actions">
                    <ResourceMenu>
                        <Item
                            on:SMUI:action={() =>
                                showParticipant(part)}
                        >
                            <Text>{$_('Edit')}</Text>
                        </Item>
                        <Item
                            on:SMUI:action={() =>
                                disableParticipant(part.id)}
                        >
                            <Text>{$_('Remove')}</Text>
                        </Item>
                    </ResourceMenu>
                </td>
            </tr>
        {/each}

        {#if project.participants.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4"
                    >{$_('No data recorded')}</td
                >
            </tr>
        {/if}
    </tbody>
</DataTable>

<!-- Dialog -->
<Dialog bind:open={dialog_open}>
    <div slot="title">
        <div class="mb-10 text-center">
            <div class="text-primary">
                {#if $formParticipant._method!=null}
                Editar vinculación proponente: {dialogTitle}
                {:else}
                Vincular proponente: {dialogTitle}
                {/if}
            </div>
        </div>
    </div>
    <div slot="content">
        <form
            on:submit|preventDefault={submitParticipant}
            id="participant-form"
        >
            <fieldset>
                <p class="block font-medium mb-2 text-gray-700 text-sm">
                    Por favor diligencie la siguiente información sobre la vinculación del proponente.
                </p>
                <div class="mb-2">
                    <Label
                        class="mb-4"
                        labelFor="qty_months"
                        value="Número de meses de vinculación*"
                    />
                    <Input
                        id="start_date"
                        type="number"
                        step="0.5"
                        min="1"
                        max="11.5"
                        class="mt-1 block w-full"
                        bind:value={$formParticipant.qty_months}
                        placeholder="Número de meses de vinculación*"
                        autocomplete="off"
                        required
                    />
                </div>
                <div class="mb-2">
                    <Label
                        class="mb-4"
                        labelFor="qty_hours"
                        value="Número de horas semanales dedicadas para el desarrollo del proyecto*"
                    />
                    <Input
                        id="start_date"
                        type="number"
                        step="1"
                        min="1"
                        class="mt-1 block w-full"
                        bind:value={$formParticipant.qty_hours}
                        placeholder="Número de horas semanales dedicadas para el desarrollo del proyecto*"
                        autocomplete="off"
                        required
                    />
                </div>
                <div class="mb-2">
                    <Label
                        class="mb-4"
                        labelFor="is_author"
                        value="¿Es autor?"
                    />
                    <Select
                        id="is_author"
                        items={authorTypes}
                        bind:selectedValue={$formParticipant.is_author}
                        error={errors.is_author}
                        autocomplete="off"
                        placeholder="¿Es autor?"
                        required
                    />
                </div>
            </fieldset>
        </form>
    </div>
    
    <div slot="actions" class="block flex w-full">
        <Button on:click={closeDialog} type="button" variant={null}>
            {$_('Cancel')}
        </Button>
            <LoadingButton
                loading={sending}
                class="btn-indigo ml-auto"
                type="submit"
                form={formID}
            >
                {$_('Save')}
            </LoadingButton>
    </div>
</Dialog>
<!-- Dialog Register -->
<Dialog bind:open={open_dialog_register}>
    <div slot="title">
        <div class="mb-10 text-center">
            <div class="text-primary">
                Registar nuevo proponente
            </div>
        </div>
    </div>
    <div slot="content">
        <form
            on:submit|preventDefault={submitRegister}
            id={formRegisterID}
        >
            <fieldset>
                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="name"
                        value="Nombre completo"
                    />
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        bind:value={$formRegister.name}
                        error={errors.name}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="email"
                        value="Correo electrónico"
                    />
                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        bind:value={$formRegister.email}
                        error={errors.email}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="document_type"
                        value="Tipo de documento"
                    />
                    <Select
                        id="document_type"
                        items={documentTypes}
                        bind:selectedValue={$formRegister.document_type}
                        error={errors.document_type}
                        autocomplete="off"
                        placeholder="Seleccione un tipo de documento"
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="document_number"
                        value="Número de documento"
                    />
                    <Input
                        id="document_number"
                        type="number"
                        min="0"
                        class="mt-1 block w-full"
                        bind:value={$formRegister.document_number}
                        error={errors.document_number}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="cellphone_number"
                        value="Número de celular"
                    />
                    <Input
                        id="cellphone_number"
                        type="number"
                        min="0"
                        class="mt-1 block w-full"
                        bind:value={$formRegister.cellphone_number}
                        error={errors.cellphone_number}
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="participation_type"
                        value="Tipo de participación"
                    />
                    <Select
                        id="participation_type"
                        items={participationTypes}
                        bind:selectedValue={$formRegister.participation_type}
                        error={errors.participation_type}
                        autocomplete="off"
                        placeholder="Seleccione el tipo de participación"
                        required
                    />
                </div>

                <div class="mt-4">
                    <Label
                        required
                        class="mb-4"
                        labelFor="academic_centre_id"
                        value="Centro de formación"
                    />
                    <DynamicList
                        id="academic_centre_id"
                        bind:value={$formRegister.academic_centre_id}
                        routeWebApi={route('web-api.academic-centres')}
                        placeholder="Busque por el nombre del centro de formación"
                        message={errors.academic_centre_id}
                        required
                    />
                </div>
                <p class="block font-medium mb-2 text-gray-700 text-sm">
                    Por favor diligencie la siguiente información sobre la vinculación del proponente.
                </p>
                <div class="mb-2">
                    <Label
                        class="mb-4"
                        labelFor="qty_months"
                        value="Número de meses de vinculación*"
                    />
                    <Input
                        id="start_date"
                        type="number"
                        step="0.5"
                        min="1"
                        max="11.5"
                        class="mt-1 block w-full"
                        bind:value={$formRegister.qty_months}
                        placeholder="Número de meses de vinculación*"
                        autocomplete="off"
                        required
                    />
                </div>
                <div class="mb-2">
                    <Label
                        class="mb-4"
                        labelFor="qty_hours"
                        value="Número de horas semanales dedicadas para el desarrollo del proyecto*"
                    />
                    <Input
                        id="start_date"
                        type="number"
                        step="1"
                        min="1"
                        class="mt-1 block w-full"
                        bind:value={$formRegister.qty_hours}
                        placeholder="Número de horas semanales dedicadas para el desarrollo del proyecto*"
                        autocomplete="off"
                        required
                    />
                </div>
                <div class="mb-2">
                    <Label
                        class="mb-4"
                        labelFor="is_author"
                        value="¿Es autor?"
                    />
                    <Select
                        id="is_author"
                        items={authorTypes}
                        bind:selectedValue={$formRegister.is_author}
                        error={errors.is_author}
                        autocomplete="off"
                        placeholder="¿Es autor?"
                        required
                    />
                </div>
            </fieldset>
        </form>
    </div>
    
    <div slot="actions" class="block flex w-full">
        <Button on:click={closeDialog} type="button" variant={null}>
            {$_('Cancel')}
        </Button>
            <LoadingButton
                loading={sending}
                class="btn-indigo ml-auto"
                type="submit"
                form={formRegisterID}
            >
                {$_('Save')}
            </LoadingButton>
    </div>
</Dialog>