<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let call

    $title = 'Convocatorias - Dashboard'
</script>

<div class="py-12">
    <h1 class="text-4xl text-center">¡Bienvenido(a) <span class="capitalize">{$page.props.auth.user.name}</span>! Formule proyectos de I+D+i, Tecnoacademia-Tecnopoarque y de servicios tecnológicos para la vigencia {call.year}</h1>
    <div class="grid grid-cols-3 gap-10 mt-24">
        {#if $page.props.auth.user.can.find(element => element == 'rdi.index') == 'rdi.index'}
            <a use:inertia href={route('calls.rdi.index', call.id)} class="bg-white overflow-hidden shadow-sm sm:rounded-lg block px-6 py-2 hover:bg-indigo-500 hover:text-white h-52 flex justify-around items-center flex-col h-96">
                <span>ICON</span>
                {$_('RDI.singular')}
            </a>
        {/if}
    </div>
</div>
