
<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, links } from '@/Utils'
    import { _ } from 'svelte-i18n'

    // Permisos
    let authUser        = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1}).length > 0
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1 class="font-bold text-5xl">Convocatoria 2022</h1>
                <p class="text-2xl mt-4">El proceso empezó el 15 de mayo de 2021 y finaliza el 15 de junio de 2021.</p>
                {#if authUser.can.find(element => element == 'calls.index') == 'calls.index' || authUser.can.find(element => element == 'calls.show') == 'calls.show' || authUser.can.find(element => element == 'calls.create') == 'calls.create' || authUser.can.find(element => element == 'calls.edit') == 'calls.edit' || authUser.can.find(element => element == 'calls.delete') == 'calls.delete' || isSuperAdmin}
                    <a use:inertia href={route('calls.index')} class="bg-indigo-600 hover:bg-indigo-500 inline-block mt-4 overflow-hidden px-6 py-2 shadow-sm sm:rounded-lg text-white transition-colors">
                        {$_('Calls.plural')}
                    </a>
                {/if}
            </div>
            <div>
                <figure>
                    <img src="/storage/images/dashboard.png" alt="">
                </figure>
            </div>
        </div>
    </header>
    <div class="py-12">
        <div class="grid grid-cols-3 gap-10">
            {#each links as link}
                {#if authUser.can.find(element => element == link.route+'.index') == link.route+'.index' || authUser.can.find(element => element == link.route+'.show') == link.route+'.show' || authUser.can.find(element => element == link.route+'.create') == link.route+'.create' || authUser.can.find(element => element == link.route+'.edit') == link.route+'.edit' || authUser.can.find(element => element == link.route+'.delete') == link.route+'.delete' || isSuperAdmin}
                    <a use:inertia href={route('users.index')} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                        <span>ICON</span>
                        {$_(link.name+'.plural')}
                    </a>
                {/if}
            {/each}
        </div>
    </div>
</AuthenticatedLayout>

