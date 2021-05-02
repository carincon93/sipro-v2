<script context="module">
    import { writable } from 'svelte/store'
    export const title = writable(null)
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, links } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import ApplicationLogo from '@/Components/ApplicationLogo'
    import Dropdown from '@/Components/Dropdown'
    import Icon from '@/Components/Icon'
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink'
    import FlashMessages from '@/Components/FlashMessages'

    let showingNavigationDropdown = false
    let authUser        = $page.props.auth.user
    let isSuperAdmin    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0

    $: isUrl = (...urls) => {
        return urls.filter(url => $page.url.match(url)).length
    }
</script>

<svelte:head>
    <title>{$title ? `${$title} - SIPRO-SPA` : 'SIPRO-SPA'}</title>
</svelte:head>

<div>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a use:inertia href={route('dashboard')}>
                                <ApplicationLogo class="w-10" />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <Dropdown class="mt-1" classes="w-9/12" placement="bottom-end">
                                <div class="flex items-center cursor-pointer select-none group">
                                    <div class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-no-wrap">
                                        <span>Panel de control</span>
                                    </div>
                                    <Icon
                                        name="cheveron-down"
                                        class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" />
                                </div>
                                <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm" style="max-height: 750px; overflow-y: auto;">
                                    <h1 class="bg-white p-8 sticky text-4xl shadow text-center top-0">Menú de navegación</h1>
                                    <div class="grid grid-cols-3 gap-5 p-8">
                                        {#each links as link}
                                            {#if authUser.can.find(element => element == link.route+'.index') == link.route+'.index' || authUser.can.find(element => element == link.route+'.show') == link.route+'.show' || authUser.can.find(element => element == link.route+'.create') == link.route+'.create' || authUser.can.find(element => element == link.route+'.edit') == link.route+'.edit' || authUser.can.find(element => element == link.route+'.delete') == link.route+'.delete' || isSuperAdmin}
                                                <a use:inertia href={route(link.route+'.index')} class="block border flex h-16 hover:bg-indigo-500 hover:text-white items-center overflow-hidden px-6 py-2 shadow-sm sm:rounded-lg{isUrl('/'+link.route+'/*') ? ' bg-indigo-600 text-white' : ''}">
                                                    {$_(link.name+'.plural')}
                                                </a>
                                            {/if}
                                        {/each}
                                    </div>
                                    <div class="mt-8 p-4 flex justify-between">
                                        <a use:inertia href={route('dashboard')} class="block border flex hover:bg-indigo-500 hover:text-white items-center overflow-hidden px-6 py-2 shadow-sm sm:rounded-lg{isUrl('/dashboard/*') ? ' bg-indigo-600 text-white' : ''}">
                                            {$_("Dashboard")}
                                        </a>
                                        <button type="button">{$_('Cancel')}</button>
                                    </div>
                                </div>
                            </Dropdown>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <Dropdown class="mt-1" placement="bottom-end">
                                <div class="flex items-center cursor-pointer select-none group">
                                    <div class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-no-wrap">
                                        <span>{authUser.name}</span>
                                    </div>
                                    <Icon
                                        name="cheveron-down"
                                        class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" />
                                </div>
                                <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                                    <!-- <a
                                        use:inertia
                                        href={route('users.edit', authUser.id)}
                                        class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                        Mi perfil
                                    </a> -->
                                    <a
                                        use:inertia={{ method: 'post' }}
                                        href={route('logout')}
                                        class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                        {$_("Logout")}
                                    </a>
                                </div>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <!-- <div class="-mr-2 flex items-center sm:hidden">
                        <button on:click={showingNavigationDropdown = ! showingNavigationDropdown} class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="{showingNavigationDropdown ? 'hidden': '', ! showingNavigationDropdown ? 'inline-flex': ''}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path class="{! showingNavigationDropdown ? 'hidden': '', showingNavigationDropdown ? 'inline-flex': ''}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div> -->
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div class="sm:hidden{showingNavigationDropdown ? ' block': '', ! showingNavigationDropdown ? ' hidden': ''}">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                        {$_("Dashboard")}
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="font-medium text-base text-gray-800">{ authUser.name }</div>
                        <div class="font-medium text-sm text-gray-500">{ authUser.email }</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink href={route('logout')} method="post" as="button">
                            {$_("Logout")}
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        {#if $$slots.header}
            <slot name="header" />
        {/if}

        <!-- Page Content -->
        <main class="lg:px-8 max-w-7xl md:p-12 mx-auto px-4 py-8 sm:px-6">
            <FlashMessages />
            <slot />
        </main>
    </div>
</div>



