<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import Select from 'svelte-select'

    export let errors
    export let researchTeam
    export let researchLines
    export let selectedResearchLine

    $: $title = researchTeam ? researchTeam.name : null

    let canUpdateResearchTeam = $page.props.auth.user.can.find(element => element == 'research-teams.edit') == 'research-teams.edit'
    let canDeleteResearchTeam = $page.props.auth.user.can.find(element => element == 'research-teams.delete') == 'research-teams.delete'

    let modal_open = false
    let sending = false
    let form = remember({
        name:   researchTeam.name,
        research_line: selectedResearchLine,

    })

    function submit() {
        if (canUpdateResearchTeam) {
            Inertia.put(route('research-teams.update', researchTeam.id), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteResearchTeam) {
            Inertia.delete(route('research-teams.destroy', researchTeam.id))
        }
    }
</script>

<h1 class="mb-8 font-bold text-3xl">
    <a use:inertia href={route('research-teams.index')} class="text-indigo-400 hover:text-indigo-600">
        {$_('Research teams.plural')}
    </a>
    <span class="text-indigo-400 font-medium">/</span>
    {researchTeam.name}
</h1>

<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
    <form on:submit|preventDefault={submit}>
        <div class="p-8">
            <div class="mt-4">
                <Label id="name" value="Nombre" />
                <Input id="name" type="text" class="mt-1 block w-full" bind:value={$form.name} required autofocus />
                <InputError message={errors.name} />
            </div>

            <div class="mt-4">
                <Label id="research_line" value="Grupo de investigación" />
                <Select items={researchLines} bind:selectedValue={$form.research_line} autocomplete="off" placeholder="Seleccione una línea de investigación"/>
                <InputError message={errors.research_line} />
            </div>
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
            {#if canDeleteResearchTeam}
                <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                    {$_('Delete')} {$_('Research teams.singular').toLowerCase()}
                </button>
            {/if}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Update')} {$_('Research teams.singular')}
            </LoadingButton>
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
