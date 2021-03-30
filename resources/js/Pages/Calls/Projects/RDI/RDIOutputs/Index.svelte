<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Pagination from '@/Components/Pagination'
    import Link from '@inertiajs/inertia-svelte/src/Link.svelte'
    import Stepper from '@/Components/Stepper.svelte'

    export let call
    export let rdi
    export let rdiOutputs

    $title = 'Productos de investigación - I+D+i'

    let canCreateRDIOutput = $page.props.auth.user.can.find(element => element == 'calls.rdi.rdi-outputs.create') == 'calls.rdi.rdi-outputs.create'

    let filters = {}
</script>

<Stepper call={call} project={rdi} />

<h1 class="mb-8 font-bold text-3xl">{$_("RDIOutputs.plural")}</h1>
<div class="mb-6 flex justify-between items-center">
    <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
    {#if canCreateRDIOutput}
        <Link href={route('calls.rdi.rdi-outputs.create', [call.id, rdi.id])} class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 btn-indigo ml-auto">
            <div>
                <span>Crear</span>
                <span class="hidden md:inline">producto</span>
            </div>
        </Link>
    {/if}
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4">Nombre</th>
        </tr>
        {#each rdiOutputs.data as rdiOutput (rdiOutput.id)}
        <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
                <a
                    use:inertia
                    href={route('calls.rdi.rdi-outputs.edit', [call.id, rdi.id, rdiOutput.id])}
                    class="px-6 py-4 flex items-center focus:text-indigo-500">
                    {rdiOutput.name}
                </a>
            </td>
        </tr>
        {/each}

        {#if rdiOutputs.data.length === 0}
            <tr>
                <td class="border-t px-6 py-4" colspan="4">{$_("No data recorded")}</td>
            </tr>
        {/if}
    </table>
</div>
<Pagination links={rdiOutputs.links} />
