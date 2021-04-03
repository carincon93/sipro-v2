<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let calls

    let authUser = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
    let canIndexCalls   = authUser.can.find(element => element == 'calls.index') == 'calls.index'
    let canShowCalls    = authUser.can.find(element => element == 'calls.show') == 'calls.show'
    let canCreateCalls  = authUser.can.find(element => element == 'calls.create') == 'calls.create'
    let canEditCalls    = authUser.can.find(element => element == 'calls.edit') == 'calls.edit'
    let canDeleteCalls  = authUser.can.find(element => element == 'calls.delete') == 'calls.delete'

    $title = $_('Calls.plural')
</script>

<AuthenticatedLayout>
    <div class="py-12">
        <div class="grid grid-cols-3 gap-10">
            {#if canIndexCalls || isSuperAdmin}
                {#each calls.data as call (call.id)}
                    <a use:inertia href={route('calls.dashboard', call.id)} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                        <span>ICON</span>
                        {$_('Calls.singular')} { call.year }
                    </a>
                {/each}
            {/if}
        </div>
    </div>
</AuthenticatedLayout>
