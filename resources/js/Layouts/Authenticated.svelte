<script context="module">
    import { writable } from 'svelte/store'
    export const title = writable(null)
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import FlashMessages from '@/Components/FlashMessages'
    import ApplicationLogo from '@/Components/ApplicationLogo'
    import Dropdown from '@/Components/Dropdown'
    import Icon from '@/Components/Icon'
    import NavLink from '@/Components/NavLink'
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink'

    let showingNavigationDropdown = false

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
                            <Dropdown class="mt-1" placement="bottom-end">
                                <div class="flex items-center cursor-pointer select-none group">
                                    <div class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-no-wrap">
                                        <span>Panel de control</span>
                                    </div>
                                    <Icon
                                        name="cheveron-down"
                                        class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" />
                                </div>
                                <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                                    <a use:inertia href={route('dashboard')} active={isUrl('/dashboard/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                        {$_("Dashboard")}
                                    </a>
                                    {#if $page.props.auth.user.can.find(element => element == 'users.index') == 'users.index'}
                                        <a use:inertia href={route('users.index')} active={isUrl('/users/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Users.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'regional.index') == 'regional.index'}
                                        <a use:inertia href={route('regional.index')} active={isUrl('/regional/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Regional.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'academic-centres.index') == 'academic-centres.index'}
                                        <a use:inertia href={route('academic-centres.index')} active={isUrl('/academic-centres/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Academic centres.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'academic-programs.index') == 'academic-programs.index'}
                                        <a use:inertia href={route('academic-programs.index')} active={isUrl('/academic-programs/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Academic programs.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'knowledge-areas.index') == 'knowledge-areas.index'}
                                        <a use:inertia href={route('knowledge-areas.index')} active={isUrl('/knowledge-areas/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Knowledge areas.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'knowledge-subareas.index') == 'knowledge-subareas.index'}
                                        <a use:inertia href={route('knowledge-subareas.index')} active={isUrl('/knowledge-subareas/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Knowledge subareas.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'knowledge-subarea-disciplines.index') == 'knowledge-subarea-disciplines.index'}
                                        <a use:inertia href={route('knowledge-subarea-disciplines.index')} active={isUrl('/knowledge-subarea-disciplines/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Knowledge subarea disciplines.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'programmatic-lines.index') == 'programmatic-lines.index'}
                                        <a use:inertia href={route('programmatic-lines.index')} active={isUrl('/programmatic-lines/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Programmatic lines.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'knowledge-networks.index') == 'knowledge-networks.index'}
                                        <a use:inertia href={route('knowledge-networks.index')} active={isUrl('/knowledge-networks/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Knowledge networks.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'strategic-thematics.index') == 'strategic-thematics.index'}
                                        <a use:inertia href={route('strategic-thematics.index')} active={isUrl('/strategic-thematics/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Strategic thematics.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'project-types.index') == 'project-types.index'}
                                        <a use:inertia href={route('project-types.index')} active={isUrl('/project-types/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Project types.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'productive-sectors.index') == 'productive-sectors.index'}
                                        <a use:inertia href={route('productive-sectors.index')} active={isUrl('/productive-sectors/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Productive sectors.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'technical-committees.index') == 'technical-committees.index'}
                                        <a use:inertia href={route('technical-committees.index')} active={isUrl('/technical-committees/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Technical committees.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'prioritized-topics.index') == 'prioritized-topics.index'}
                                        <a use:inertia href={route('prioritized-topics.index')} active={isUrl('/prioritized-topics/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Prioritized topics.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'research-groups.index') == 'research-groups.index'}
                                        <a use:inertia href={route('research-groups.index')} active={isUrl('/research-groups/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Research groups.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'research-lines.index') == 'research-lines.index'}
                                        <a use:inertia href={route('research-lines.index')} active={isUrl('/research-lines/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Research lines.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'research-teams.index') == 'research-teams.index'}
                                        <a use:inertia href={route('research-teams.index')} active={isUrl('/research-teams/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("Research teams.plural")}
                                        </a>
                                    {/if}
                                    {#if $page.props.auth.user.can.find(element => element == 'roles.index') == 'roles.index'}
                                        <a use:inertia href={route('roles.index')} active={isUrl('/roles/*') ? true : false} class="block px-6 py-2 hover:bg-indigo-500 hover:text-white">
                                            {$_("System roles.plural")}
                                        </a>
                                    {/if}
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
                                        <span>{$page.props.auth.user.name}</span>
                                    </div>
                                    <Icon
                                        name="cheveron-down"
                                        class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" />
                                </div>
                                <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                                    <!-- <a
                                        use:inertia
                                        href={route('users.edit', $page.props.auth.user.id)}
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
                        <div class="font-medium text-base text-gray-800">{ $page.props.auth.user.name }</div>
                        <div class="font-medium text-sm text-gray-500">{ $page.props.auth.user.email }</div>
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
        <!-- {#if $slots.header}
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
        {/if} -->

        <!-- Page Content -->
        <main class="lg:px-8 max-w-7xl md:p-12 mx-auto px-4 py-8 sm:px-6">
            <FlashMessages />
            <slot />
        </main>
    </div>
</div>



