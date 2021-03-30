<script context="module">
    import GuestLayout from '@/Layouts/Guest'
    export const layout = GuestLayout
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import Input from '@/Components/Input'
    import Checkbox from '@/Components/Checkbox'
    import Label from '@/Components/Label'
    import InputError from '@/Components/InputError'
    import LoadingButton from '@/Components/LoadingButton'

    export let canResetPassword
    export let status
    export let errors

    let selection = []
    let sending = false

    let form = {
        email: '',
        password: '',
        remember: false,
    }

    function handleSubmit() {
        const data = {
            email: form.email,
            password: form.password,
            remember: form.remember,
        }
        Inertia.post(route('login'), data, {
            onStart: () => sending = true,
            onFinish: () => sending = false,
        })
    }
</script>

<svelte:head>
    <title>Ingresar - SGPS-SIPRO</title>
</svelte:head>

{#if status}
    <div class="mb-4 font-medium text-sm text-green-600">
        { status }
    </div>
{/if}

<form on:submit|preventDefault={handleSubmit}>
    <div>
        <Label id="email" value={$_('Email')} />
        <Input id="email" type="email" class="mt-1 block w-full" bind:value={form.email} required autofocus autocomplete="email" />
        <InputError message={errors.email} />
    </div>

    <div class="mt-4">
        <Label id="password" value={$_('Password')} />
        <Input id="password" type="password" class="mt-1 block w-full" bind:value={form.password} required autocomplete="current-password" />
        <InputError message={errors.password} />
    </div>

    <div class="block mt-4">
        <label class="flex items-center" for="remember">
            <Checkbox name="remember" id="remember" bind:value={form.remember} bind:group={selection} />
            <span class="ml-2 text-sm text-gray-600">{$_('Remember me')}</span>
        </label>
    </div>

    <div class="flex items-center justify-end mt-4">
        {#if canResetPassword}
            <a use:inertia href={route('password.request')} class="mr-4 underline text-sm text-gray-600 hover:text-gray-900">
                {$_('Forgot your password?')}
            </a>
        {/if}

        <LoadingButton bind:loading={sending} class="btn-indigo" type="submit">{$_('Login')}</LoadingButton>

    </div>
</form>
