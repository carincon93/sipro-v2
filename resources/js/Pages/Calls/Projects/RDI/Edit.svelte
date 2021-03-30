<script context="module">
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    export const layout = AuthenticatedLayout
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember, page } from '@inertiajs/inertia-svelte'
    import { onMount } from 'svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'
    import fitTextarea from 'fit-textarea'
    import Stepper from '@/Components/Stepper.svelte'

    export let errors
    export let call
    export let rdi

    $: $title = rdi ? rdi.title : null

    let canUpdateRDI = $page.props.auth.user.can.find(element => element == 'rdi.edit')     == 'rdi.edit'
    let canDeleteRDI = $page.props.auth.user.can.find(element => element == 'rdi.delete')   == 'rdi.delete'

    let modal_open  = false
    let sending     = false
    let form        = remember({
        title:   rdi.title,
        start_date:   rdi.start_date,
        end_date:   rdi.end_date,
    })

    onMount(() => {
		const textareas = document.querySelectorAll('textarea');
        fitTextarea.watch(textareas);
	})

    function submit() {
        if (canUpdateRDI) {
            Inertia.put(route('calls.rdi.update', [call.id, rdi.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteRDI) {
            Inertia.delete(route('calls.rdi.destroy', [call.id, rdi.id]))
        }
    }
</script>

<Stepper call={call} project={rdi} />

<form on:submit|preventDefault={submit}>
    <div class="p-8">
        <div class="mt-28">
            <Label id="title" class="font-medium inline-block mb-10 text-center text-gray-700 text-sm w-full" value="Descripción llamativa que orienta el enfoque del proyecto, indica el cómo y el para qué." />
            <textarea rows="3" id="title" class="bg-transparent block border-0 outline-none-important mt-1 outline-none text-4xl text-center w-full" required>{$form.title}</textarea>
            <InputError message={errors.title} />
        </div>

        <div class="mt-44">
            <p class="text-center">Fecha de ejecución</p>
            <div class="mt-4 flex items-center justify-around">
                <div class="mt-4 flex items-center">
                    <Label id="start_date" value="Del" />
                    <div class="ml-4">
                        <Input id="start_date" type="date" class="mt-1 block w-full" bind:value={$form.start_date} required />
                        <InputError message={errors.start_date} />
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <Label id="end_date" value="hasta" />
                    <div class="ml-4">
                        <Input id="end_date" type="date" class="mt-1 block w-full" bind:value={$form.end_date} required />
                        <InputError message={errors.end_date} />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
        {#if canDeleteRDI}
            <button class="text-red-600 hover:underline" tabindex="-1" type="button" on:click={event => modal_open = true}>
                Delete {$_('RDI.singular')}
            </button>
        {/if}
        <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
            Update {$_('RDI.singular')}
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
