<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'

    export let call
    export let rdi
    export let partnerOrganization
    export let partnerOrganizationMembers = []

    $title = $_('Partner organization members.plural')

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                        = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexPartnerOrganizationMembers  = authUser.can.find(element => element == 'partner-organization-members.index') == 'partner-organization-members.index'
    let canShowPartnerOrganizationMembers   = authUser.can.find(element => element == 'partner-organization-members.show') == 'partner-organization-members.show'
    let canCreatePartnerOrganizationMembers = authUser.can.find(element => element == 'partner-organization-members.create') == 'partner-organization-members.create'
    let canEditPartnerOrganizationMembers   = authUser.can.find(element => element == 'partner-organization-members.edit') == 'partner-organization-members.edit'
    let canDeletePartnerOrganizationMembers = authUser.can.find(element => element == 'partner-organization-members.delete') == 'partner-organization-members.delete'

    let canIndexPartnerOrganizations    = authUser.can.find(element => element == 'partner-organization.delete') == 'partner-organization.delete'
    let canEditPartnerOrganizations     = authUser.can.find(element => element == 'partner-organization.delete') == 'partner-organization-members.delete'

    let filters = {}
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
                    <span class="text-indigo-400 font-medium">/</span>
                    {$_('Partner organization members.plural')}
                </h1>
            </div>
        </div>
    </header>

    <h1 class="mb-8 font-bold text-3xl">{$_('Partner organization members.plural')}</h1>
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

                {#each partnerOrganizationMembers.data as partnerOrganizationMember (partnerOrganizationMember.id)}
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

                {#if partnerOrganizationMembers.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={partnerOrganizationMembers.links} />
</AuthenticatedLayout>
