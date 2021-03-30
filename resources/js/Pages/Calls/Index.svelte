<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let calls

    $title = 'Convocatorias'
</script>

<div class="py-12">
    <div class="grid grid-cols-3 gap-10">
        {#each calls.data as call (call.id)}
            {#if $page.props.auth.user.can.find(element => element == 'calls.index') == 'calls.index'}
                <a use:inertia href={route('calls.dashboard', call.id)} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col">
                    <span>ICON</span>
                    {$_('Calls.singular')} { call.year }
                </a>
            {/if}
        {/each}
    </div>
</div>
