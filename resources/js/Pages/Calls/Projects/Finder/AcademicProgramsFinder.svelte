<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, remember } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import LoadingButton from '@/Components/LoadingButton'

    export let errors

    let form = remember({
        search:  '',
    })

    function submit() {
        Inertia.post('', $form, {
            onStart: ()     => sending = true,
            onFinish: ()    => sending = false,
        })
    }
</script>

<h1 class="text-4xl text-center">Programas de formación</h1>
<p class="text-center w-1/3 m-auto mt-8">Realiza la búsqueda de programas de formación</p>

<form on:submit|preventDefault={submit}>
    <div class="p-8">
        <div class="mt-4">
            <Input id="search" type="search" placeholder="Escriba el ID o el nombre completo del programa de formación" class="mt-1 w-9/12 m-auto block" bind:value={$form.search} required />
        </div>
    </div>
</form>
