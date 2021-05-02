<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, page, useForm } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@/Components/Checkbox'
    import Textarea from '@/Components/Textarea'
    import Input from '@/Components/Input'
    import Switch from '@/Components/Switch'
    import File from '@/Components/File'
    import FilterSelect from '@/Components/FilterSelect'

    export let errors
    export let call
    export let rdi
    export let partnerOrganization
    export let activities
    export let activityPartnerOrganizations
    export let activitySpecificObjective

    let researchGroup   = partnerOrganization.research_group != null ? true : false
    let agreement       = partnerOrganization.agreement_description != null ? true : false

    $: $title = partnerOrganization ? partnerOrganization.name : null

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexPartnerOrganizations    = authUser.can.find(element => element == 'partner-organizations.index') == 'partner-organizations.index'
    let canShowPartnerOrganizations     = authUser.can.find(element => element == 'partner-organizations.show') == 'partner-organizations.show'
    let canCreatePartnerOrganizations   = authUser.can.find(element => element == 'partner-organizations.create') == 'partner-organizations.create'
    let canEditPartnerOrganizations     = authUser.can.find(element => element == 'partner-organizations.edit') == 'partner-organizations.edit'
    let canDeletePartnerOrganizations   = authUser.can.find(element => element == 'partner-organizations.delete') == 'partner-organizations.delete'

    let canCreatePartnerOrganizationMembers = authUser.can.find(element => element == 'partner-organization-members.create') == 'partner-organization-members.create'
    let canEditPartnerOrganizationMembers   = authUser.can.find(element => element == 'partner-organization-members.edit') == 'partner-organization-members.edit'

    let modal_open = false
    let sending = false
    let form = useForm({
        _method: 'put',
        partner_organization_type: partnerOrganization.partner_organization_type,
        name: partnerOrganization.name,
        legal_status: partnerOrganization.legal_status,
        company_type: partnerOrganization.company_type,
        nit: partnerOrganization.nit,
        agreement_description: partnerOrganization.agreement_description || '',
        research_group: partnerOrganization.research_group || '',
        gruplac_code: partnerOrganization.gruplac_code || '',
        gruplac_link: partnerOrganization.gruplac_link || '',
        knowledge_transfer_activities: partnerOrganization.knowledge_transfer_activities,
        in_kind: partnerOrganization.in_kind,
        in_kind_description: partnerOrganization.in_kind_description,
        funds: partnerOrganization.funds,
        funds_description: partnerOrganization.funds_description,
        letter_of_intent: '',
        intellectual_property: '',
        activity_id: activityPartnerOrganizations
    })

    let partnerOrganizationTypes = [{'value': 1, 'label': 'Empresa'}, {'value': 2, 'label': 'Universidad'}, {'value': 3, 'label': 'Entidades sin ánimo de lucro'}, {'value': 4, 'label': 'Centro de formación SENA'}, {'value': 5, 'label': 'Otra'}]
    let legalStatus = [{'value': 1, 'label': 'Pública'}, {'value': 2, 'label': 'Privado'}, {'value': 3, 'label': 'Mixta'}, {'value': 4, 'label': 'ONG'}]
    let companyTypes = [{'value': 1, 'label': 'Microempresa'}, {'value': 2, 'label': 'Pequeña'}, {'value': 3, 'label': 'Mediana'}, {'value': 4, 'label': 'Grande'}]

    function submit() {
        if (canEditPartnerOrganizations || isSuperAdmin) {
            let formData = new FormData()
            formData.append('_method', 'put')
            formData.append('partner_organization_type', $form.partner_organization_type)
            formData.append('name', $form.name)
            formData.append('legal_status', $form.legal_status)
            formData.append('company_type', $form.company_type)
            formData.append('nit', $form.nit)
            if (agreement) formData.append('agreement_description', $form.agreement_description)
            if (researchGroup) formData.append('research_group', $form.research_group)
            if (researchGroup) formData.append('gruplac_code', $form.gruplac_code)
            if (researchGroup) formData.append('gruplac_link', $form.gruplac_link)
            formData.append('knowledge_transfer_activities', $form.knowledge_transfer_activities)
            formData.append('in_kind', $form.in_kind)
            formData.append('in_kind_description', $form.in_kind_description)
            formData.append('funds', $form.funds)
            formData.append('funds_description', $form.funds_description)
            formData.append('letter_of_intent', $form.letter_of_intent)
            formData.append('intellectual_property', $form.intellectual_property)
            formData.append('activity_id', JSON.stringify($form.activity_id))

            Inertia.post(route('calls.rdi.partner-organizations.update', [call.id, rdi.id, partnerOrganization.id]), formData, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeletePartnerOrganizations || isSuperAdmin) {
            Inertia.delete(route('calls.rdi.partner-organizations.destroy', [call.id, rdi.id, partnerOrganization.id]))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexPartnerOrganizations || canEditPartnerOrganizations || isSuperAdmin}
                        <a use:inertia href={route('calls.rdi.partner-organizations.index', [call.id, rdi.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Partner organizations.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {partnerOrganization.name}
                </h1>
            </div>
        </div>
    </header>

    <div class="flex">

        <div class="bg-white rounded shadow max-w-3xl">
            <form on:submit|preventDefault={submit}>
                <div class="p-8">
                    <div class="mt-4">
                        <Label required class="mb-4" id="partner_organization_type" value="Tipo de entidad aliada" />
                        <FilterSelect items={partnerOrganizationTypes} selectedValue={partnerOrganization.partner_organization_type} bind:value={$form.partner_organization_type} error={errors.partner_organization_type ? true : false} autocomplete="off" placeholder="Seleccione el nivel del riesgo" id="partner_organization_type" />
                        <InputError message={errors.partner_organization_type} />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="name" value="Nombre de la entidad aliada/Centro de formación" />
                        <Textarea id="name" error={errors.name} bind:value={$form.name} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="legal_status" value="Naturaleza de la entidad" />
                        <FilterSelect items={legalStatus} selectedValue={partnerOrganization.legal_status} bind:value={$form.legal_status} error={errors.legal_status ? true : false} autocomplete="off" placeholder="Seleccione el tipo de riesgo" id="legal_status" />
                        <InputError message={errors.legal_status} />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="company_type" value="Tipo de empresa" />
                        <FilterSelect items={companyTypes} selectedValue={partnerOrganization.company_type} bind:value={$form.company_type} error={errors.company_type ? true : false} autocomplete="off" placeholder="Seleccione la probabilidad" id="company_type" />
                        <InputError message={errors.company_type} />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="nit" value="NIT" />
                        <Input id="nit" type="text" class="mt-1 block w-full" bind:value={$form.nit} error={errors.nit} required />
                    </div>

                    <div class="mt-4">
                        <p>¿Hay convenio?</p>
                        <Switch bind:checked={agreement} />
                        <span class="ml-2">{#if agreement} Si {:else} No {/if}</span>
                    </div>
                    {#if agreement}
                        <div class="mt-4">
                            <Label required class="mb-4" id="agreement_description" value="Descipción del convenio" />
                            <Textarea id="agreement_description" error={errors.agreement_description} bind:value={$form.agreement_description} required />
                        </div>
                    {/if}

                    <div class="mt-4">
                        <p>¿La entidad aliada tiene grupo de investigación?</p>
                        <Switch bind:checked={researchGroup} />
                        <span class="ml-2">{#if researchGroup} Si {:else} No {/if}</span>
                    </div>
                    {#if researchGroup}
                        <div class="mt-4">
                            <Label required class="mb-4" id="research_group" value="Grupo de investigación" />
                            <Textarea id="research_group" error={errors.research_group} bind:value={$form.research_group} required />
                        </div>

                        <div class="mt-4">
                            <Label required class="mb-4" id="gruplac_code" value="Código del GrupLAC" />
                            <Input id="gruplac_code" type="text" class="mt-1 block w-full" error={errors.gruplac_code} placeholder="Ejemplo: COL0000000" bind:value={$form.gruplac_code} required={!researchGroup ? undefined : 'required'} />
                        </div>

                        <div class="mt-4">
                            <Label required class="mb-4" id="gruplac_link" value="Enlace del GrupLAC" />
                            <Input id="gruplac_link" type="url" class="mt-1 block w-full" error={errors.gruplac_link} placeholder="Ejemplo: https://scienti.minciencias.gov.co/gruplac/jsp/Medicion/graficas/verPerfiles.jsp?id_convocatoria=0nroIdGrupo=0000000" bind:value={$form.gruplac_link} required={!researchGroup ? undefined : 'required'} />
                        </div>
                    {/if}

                    <div class="mt-4">
                        <Label required class="mb-4" id="in_kind" value="Recursos en especie entidad aliada ($COP)" />
                        <Input id="in_kind" type="number" min="0" class="mt-1 block w-full" error={errors.in_kind} placeholder="COP" bind:value={$form.in_kind} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="in_kind_description" value="Descripción de los recursos en especie aportados" />
                        <Textarea id="in_kind_description" error={errors.in_kind_description} bind:value={$form.in_kind_description} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="funds" value="Recursos en especie entidad aliada ($COP)" />
                        <Input id="funds" type="number" min="0" class="mt-1 block w-full" error={errors.funds} placeholder="COP" bind:value={$form.funds} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="funds_description" value="Descripción de la destinación del dinero aportado" />
                        <Textarea id="funds_description" error={errors.funds_description} bind:value={$form.funds_description} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="knowledge_transfer_activities" value="Metodología o actividades de transferencia al centro de formación" />
                        <Textarea id="knowledge_transfer_activities" error={errors.knowledge_transfer_activities} bind:value={$form.knowledge_transfer_activities} required />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="letter_of_intent" value="ANEXO 7. Carta de intención o acta que soporta el trabajo articulado con entidades aliadas (diferentes al SENA)" />
                        <File id="letter_of_intent" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.letter_of_intent} error={errors.letter_of_intent} />
                    </div>

                    <div class="mt-4">
                        <Label required class="mb-4" id="intellectual_property" value="ANEXO 8. Propiedad intelectual" />
                        <File id="intellectual_property" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.intellectual_property} error={errors.intellectual_property} />
                    </div>

                    <h6 class="mt-20 mb-12 text-2xl" id="activities">{$_('Activities.plural')}</h6>
                    <div class="bg-white rounded shadow overflow-hidden">
                        <div class="grid grid-cols-2">
                            {#each activities as {id, description}, i}
                                <div class="p-3 border-t border-b flex items-center text-sm">{description}</div>

                                <div class="pt-8 pb-8 border-t border-b flex flex-col-reverse items-center justify-between">
                                    <Checkbox id={id} checked={activityPartnerOrganizations.includes(id)} bind:group={$form.activity_id} value={id}/>
                                </div>
                            {/each}
                        </div>
                    </div>

                    {#if $form.progress}
                        <progress value={$form.progress.percentage} max="100">
                        {$form.progress.percentage}%
                        </progress>
                    {/if}
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                    {#if canDeletePartnerOrganizations || isSuperAdmin}
                        <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                            {$_('Delete')} {$_('Partner organizations.singular').toLowerCase()}
                        </button>
                    {/if}
                    {#if canEditPartnerOrganizations || isSuperAdmin}
                        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                            {$_('Update')} {$_('Partner organizations.singular')}
                        </LoadingButton>
                    {/if}
                </div>
            </form>

            <Modal bind:open={modal_open}>
                <Card>
                    <div class="p-4">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150 bg-red-500 hover:bg-red-400 ml-auto" type="button" on:click={destroy}>
                            {$_('Confirm')}
                        </button>
                        <button on:click={event => modal_open = false} type="button">{$_('Cancel')}</button>
                    </div>
                </Card>
            </Modal>
        </div>
        <div class="px-4">
            <h1 class="mb-4">Enlaces de interés</h1>
            <ul>
                <li>
                    <a class="bg-indigo-100 hover:bg-indigo-200 mb-4 px-6 py-2 rounded-3xl text-center text-indigo-400" href="#partner-organization-members">{$_('Partner organization members.plural')}</a>
                </li>
                <li class="mt-6">
                    <a class="bg-indigo-100 hover:bg-indigo-200 mb-4 px-6 py-2 rounded-3xl text-center text-indigo-400" href="#specific-objectives">{$_('Specific objectives.plural')} relacionados</a>
                </li>
            </ul>
        </div>
    </div>

    <h1 class="mt-20 mb-12 text-2xl" id="partner-organization-members">{$_('Partner organization members.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreatePartnerOrganizationMembers || isSuperAdmin}
            <a use:inertia href={route('calls.rdi.partner-organizations.partner-organization-members.create', [call.id, rdi.id, partnerOrganization.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Partner organization members.singular')}</span>
                </div>
            </a>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl">Nombre</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl">Correo electrónico</th>
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl">Número de celular</th>
                </tr>
            </thead>
            <tbody>
                {#each partnerOrganization.partner_organization_members as partnerOrganizationMember (partnerOrganizationMember.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditPartnerOrganizationMembers || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.rdi.partner-organizations.partner-organization-members.edit', [call.id, rdi.id, partnerOrganization.id, partnerOrganizationMember.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganizationMember.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganizationMember.name}
                                </p>
                            {/if}
                        </td>

                        <td class="border-t">
                            {#if canEditPartnerOrganizationMembers || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.rdi.partner-organizations.partner-organization-members.edit', [call.id, rdi.id, partnerOrganization.id, partnerOrganizationMember.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganizationMember.email}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganizationMember.email}
                                </p>
                            {/if}
                        </td>

                        <td class="border-t">
                            {#if canEditPartnerOrganizationMembers || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.rdi.partner-organizations.partner-organization-members.edit', [call.id, rdi.id, partnerOrganization.id, partnerOrganizationMember.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganizationMember.cellphone_number}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganizationMember.cellphone_number}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if partnerOrganization.partner_organization_members.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>

    <h1 class="mt-20 mb-12 text-2xl" id="specific-objectives">{$_('Specific objectives.plural')}</h1>
    <p class="mb-6">A continuación, se listan los objetivos específicos relacionados con la entidad aliada. Si dice 'Sin información registrada' por favor diríjase a las <a href="#activities" class="text-indigo-400">actividades</a> y relacione alguna.</p>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 bg-white shadow-xl">Descripción</th>
                </tr>
            </thead>
            <tbody>
                {#each activitySpecificObjective as {id, description}}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                {description}
                            </p>
                        </td>
                    </tr>
                {/each}

                {#if activitySpecificObjective.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
</AuthenticatedLayout>
