<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Modal, Card } from 'svelte-chota'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import Checkbox from '@smui/checkbox'
    import FormField from '@smui/form-field'
    import Textarea from '@/Components/Textarea'

    export let errors
    export let call
    export let project
    export let activity
    export let activity_outputs
    export let outputs = []

    $: $title = activity ? activity.name : null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin                    = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexActivities   = authUser.can.find(element => element == 'activities.index') == 'activities.index'
    let canShowActivities    = authUser.can.find(element => element == 'activities.show') == 'activities.show'
    let canCreateActivities  = authUser.can.find(element => element == 'activities.create') == 'activities.create'
    let canEditActivities    = authUser.can.find(element => element == 'activities.edit') == 'activities.edit'
    let canDeleteActivities  = authUser.can.find(element => element == 'activities.delete') == 'activities.delete'

    let modal_open = false
    let sending = false
    let form = useForm({
        description:  activity.description,
        start_date:  activity.start_date,
        end_date:  activity.end_date,
        output_id:  activity_outputs,
    })

    function submit() {
        if (canEditActivities || isSuperAdmin) {
            Inertia.put(route('calls.projects.activities.update', [call.id, project.id, activity.id]), $form, {
                onStart: ()     => sending = true,
                onFinish: ()    => sending = false,
            })
        }
    }

    function destroy() {
        if (canDeleteActivities || isSuperAdmin) {
            Inertia.delete(route('calls.projects.activities.destroy', [call.id, project.id, activity.id]))
        }
    }
</script>

<AuthenticatedLayout>
    <header class="shadow bg-white" slot="header">
        <div class="flex items-center justify-between lg:px-8 max-w-7xl mx-auto px-4 py-6 sm:px-6">
            <div>
                <h1>
                    {#if canIndexActivities || canEditActivities || isSuperAdmin}
                        <a use:inertia href={route('calls.projects.activities.index', [call.id, project.id])} class="text-indigo-400 hover:text-indigo-600">
                            {$_('Activities.plural')}
                        </a>
                    {/if}
                    <span class="text-indigo-400 font-medium">/</span>
                    {activity.description}
                </h1>
            </div>
        </div>
    </header>

    <div class="bg-white rounded shadow max-w-3xl">
        <form on:submit|preventDefault={submit}>
            <fieldset class="p-8" disabled={canEditActivities || isSuperAdmin ? undefined : true}>
                <div>
                    <Label required class="mb-4" id="description" value="Descripción" />
                    <Textarea id="description" error={errors.description} bind:value={$form.description} required />
                </div>
                <div class="mt-4">
                    <p class="text-center">Fecha de ejecución</p>
                    <div class="mt-4 flex items-start justify-around">
                        <div class="mt-4 flex {errors.start_date ? '' : 'items-center'}">
                            <Label required id="start_date" class="{errors.start_date ? 'top-3.5 relative' : ''}" value="Del" />
                            <div class="ml-4">
                                <Input id="start_date" type="date" class="mt-1 block w-full" error={errors.start_date} bind:value={$form.start_date} required />
                            </div>
                        </div>
                        <div class="mt-4 flex {errors.end_date ? '' : 'items-center'}">
                            <Label required id="end_date" class="{errors.end_date ? 'top-3.5 relative' : ''}" value="hasta" />
                            <div class="ml-4">
                                <Input id="end_date" type="date" class="mt-1 block w-full" error={errors.end_date} bind:value={$form.end_date} required />
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="mt-20 mb-12 text-2xl">{$_('Outputs.plural')}</h6>
                <div class="bg-white rounded shadow overflow-hidden">
                    <div class="grid grid-cols-2">
                        {#each outputs as {id, name}, i}
                            <FormField>
                                <Checkbox
                                    bind:group={$form.output_id}
                                    value={id}
                                />
                                    <span slot="label">{$_(name)}</span>
                            </FormField>
                        {/each}
                    </div>
                </div>
            </fieldset>
            <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
                {#if canDeleteActivities || isSuperAdmin}
                    <button class="text-red-600 hover:underline text-left" tabindex="-1" type="button" on:click={event => modal_open = true}>
                        {$_('Delete')} {$_('Activities.singular').toLowerCase()}
                    </button>
                {/if}
                {#if canEditActivities || isSuperAdmin}
                    <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                        {$_('Update')} {$_('Activities.singular')}
                    </LoadingButton>
                {/if}
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
</AuthenticatedLayout>
