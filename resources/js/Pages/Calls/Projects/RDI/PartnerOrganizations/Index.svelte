<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'

    import Stepper from '@/Components/Stepper';

    export let call
    export let rdi
    export let partnerOrganizations = []

    $title = $_('Partner organizations.plural')

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexPartnerOrganizations    = authUser.can.find(element => element == 'partner-organizations.index') == 'partner-organizations.index'
    let canShowPartnerOrganizations     = authUser.can.find(element => element == 'partner-organizations.show') == 'partner-organizations.show'
    let canCreatePartnerOrganizations   = authUser.can.find(element => element == 'partner-organizations.create') == 'partner-organizations.create'
    let canEditPartnerOrganizations     = authUser.can.find(element => element == 'partner-organizations.edit') == 'partner-organizations.edit'
    let canDeletePartnerOrganizations   = authUser.can.find(element => element == 'partner-organizations.delete') == 'partner-organizations.delete'

    let filters = {}
</script>

<AuthenticatedLayout>

    <Stepper {call} project={rdi} />

    <h1 class="font-bold text-3xl m-24 text-center">{$_('Partner organizations.plural')}</h1>
    <div class="mb-6 flex justify-between items-center">
        <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
        {#if canCreatePartnerOrganizations || isSuperAdmin}
            <Button on:click={() => Inertia.visit(route('calls.rdi.partner-organizations.create', [call.id, rdi.id]))} variant="raised">
                <div>
                    <span>{$_('Create')}</span>
                    <span class="hidden md:inline">{$_('Partner organizations.singular')}</span>
                </div>
            </Button>
        {/if}
    </div>
    <div class="bg-white rounded shadow">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl">Nombre</th>
                </tr>
            </thead>
            <tbody>
                {#each partnerOrganizations.data as partnerOrganization (partnerOrganization.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            {#if canEditPartnerOrganizations || isSuperAdmin}
                                <a
                                    use:inertia
                                    href={route('calls.rdi.partner-organizations.edit', [call.id, rdi.id, partnerOrganization.id])}
                                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganization.name}
                                </a>
                            {:else}
                                <p class="px-6 py-4 flex items-center focus:text-indigo-500">
                                    {partnerOrganization.name}
                                </p>
                            {/if}
                        </td>
                    </tr>
                {/each}

                {#if partnerOrganizations.data.length === 0}
                    <tr>
                        <td class="border-t px-6 py-4" colspan="4">{$_('No data recorded')}</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
    <Pagination links={partnerOrganizations.links} />
</AuthenticatedLayout>
