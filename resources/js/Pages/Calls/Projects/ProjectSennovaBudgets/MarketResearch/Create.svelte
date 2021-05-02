<script>
    import { Inertia } from '@inertiajs/inertia'
    import { useForm, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Components/Input'
    import Label from '@/Components/Label'
    import LoadingButton from '@/Components/LoadingButton'
    import File from '@/Components/File'
    import Switch from '@/Components/Switch'
    import { afterUpdate } from 'svelte';

    export let errors
    export let call
    export let project
    export let projectSennovaBudget
    export let callBudget
    export let modal_open

    // $: $title = $_('Create') + ' ' + $_('Market research.singular').toLowerCase()

    // Permisos
    let authUser = $page.props.auth.user
    let isSuperAdmin                = authUser.roles.filter(function(role) {return role.id == 1;}).length > 0
    let canIndexMarketResearch    = authUser.can.find(element => element == 'market-research.index') == 'market-research.index'
    let canShowMarketResearch     = authUser.can.find(element => element == 'market-research.show') == 'market-research.show'
    let canCreateMarketResearch   = authUser.can.find(element => element == 'market-research.create') == 'market-research.create'
    let canEditMarketResearch     = authUser.can.find(element => element == 'market-research.edit') == 'market-research.edit'
    let canDeleteMarketResearch   = authUser.can.find(element => element == 'market-research.delete') == 'market-research.delete'

    let sending = false
    let form = useForm({
        requires_third_market_research: false,
        call_budget_id: callBudget.id,
        qty_items: '',
        fact_sheet: '',
        first_price_quote: '',
        first_company_name: '',
        first_price_quote_file: '',

        second_price_quote: '',
        second_company_name: '',
        second_price_quote_file: '',

        third_price_quote: '',
        third_company_name: '',
        third_price_quote_file: '',
    })

    function submit() {
        if (canCreateMarketResearch || isSuperAdmin) {
            let formData = new FormData()
            formData.append('call_budget_id', $form.call_budget_id)
            formData.append('qty_items', $form.qty_items)
            formData.append('fact_sheet', $form.fact_sheet)

            formData.append('first_price_quote', $form.first_price_quote)
            formData.append('first_company_name', $form.first_company_name)
            formData.append('first_price_quote_file', $form.first_price_quote_file)

            formData.append('second_price_quote', $form.second_price_quote)
            formData.append('second_company_name', $form.second_company_name)
            formData.append('second_price_quote_file', $form.second_price_quote_file)

            if ($form.requires_third_market_research) {
                formData.append('third_price_quote', $form.third_price_quote)
                formData.append('third_company_name', $form.third_company_name)
                formData.append('third_price_quote_file', $form.third_price_quote_file)
            }

            sending = true,
            Inertia.post(route('calls.projects.project-sennova-budgets.project-budget-batches.store', [call.id, project.id, projectSennovaBudget]), formData, {
                onStart: ()     => sending = true,
                onFinish: ()    => {
                    sending     = false,
                    modal_open  = false
                },
                onError: () => {
                    $form.requires_third_market_research = errors.third_price_quote || errors.third_company_name || errors.third_price_quote_file ? true : false
                },
                onSuccess: () => {
                    $form.qty_items = '',
                    $form.fact_sheet = '',
                    $form.first_price_quote = '',
                    $form.first_company_name = '',
                    $form.first_price_quote_file = '',
                    $form.second_price_quote = '',
                    $form.second_company_name = '',
                    $form.second_price_quote_file = '',
                    $form.third_price_quote = '',
                    $form.third_company_name = '',
                    $form.third_price_quote_file = '',
                    document.getElementById('fact_sheet').value = ''
                    document.getElementById('first_price_quote_file').value = ''
                    document.getElementById('second_price_quote_file').value = ''
                    document.getElementById('third_price_quote_file') ? document.getElementById('third_price_quote_file').value = '' : null
                },
            })
        }
    }

    let average
    afterUpdate(() => {
        average = ((parseInt($form.first_price_quote) + parseInt($form.second_price_quote) + (parseInt($form.third_price_quote) > 0 ? parseInt($form.third_price_quote) : 0)) / (parseInt($form.third_price_quote) > 0 ? 3 : 2))
    })
</script>

<style>
    .h-90vh {
        height: 90vh;
    }
</style>

<form on:submit|preventDefault={submit} class="h-90vh overflow-y-scroll">
    <div class="p-8">
        <div class="mt-4">
            <Label required class="mb-4" id="qty_items" value="Indique la cantidad requerida del producto o servicio relacionado" />
            <Input id="qty_items" type="number" min="1" class="mt-1 block w-full" bind:value={$form.qty_items} error={errors.qty_items} required />
        </div>

        <div class="mt-4">
            <Label required class="mb-4" id="fact_sheet" value="ANEXO 2. Fichas técnicas para maquinaria y equipos" />
            <File id="fact_sheet" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.fact_sheet} error={errors.fact_sheet} required />
        </div>

        <h1 class="text-center mt-20 mb-20">Primer estudio de mercado</h1>

        <div class="mt-4">
            <Label required class="mb-4" id="first_price_quote" value="Valor (incluido IVA)" />
            <Input id="first_price_quote" type="number" min="1" class="mt-1 block w-full" bind:value={$form.first_price_quote} error={errors.first_price_quote} required />
        </div>

        <div class="mt-4">
            <Label required class="mb-4" id="first_company_name" value="Nombre de la empresa" />
            <Input id="first_company_name" type="text" class="mt-1 block w-full" bind:value={$form.first_company_name} error={errors.first_company_name} required />
        </div>

        <div class="mt-4">
            <Label required class="mb-4" id="first_price_quote_file" value="Soporte" />
            <File id="first_price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.first_price_quote_file} error={errors.first_price_quote_file} required />
        </div>

        <h1 class="text-center mt-20 mb-20">Segundo estudio de mercado</h1>

        <div class="mt-4">
            <Label required class="mb-4" id="second_price_quote" value="Valor (incluido IVA)" />
            <Input id="second_price_quote" type="number" min="1" class="mt-1 block w-full" bind:value={$form.second_price_quote} error={errors.second_price_quote} required />
        </div>

        <div class="mt-4">
            <Label required class="mb-4" id="second_company_name" value="Nombre de la empresa" />
            <Input id="second_company_name" type="text" class="mt-1 block w-full" bind:value={$form.second_company_name} error={errors.second_company_name} required />
        </div>

        <div class="mt-4">
            <Label required class="mb-4" id="second_price_quote_file" value="Soporte" />
            <File id="second_price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.second_price_quote_file} error={errors.second_price_quote_file} required />
        </div>

        <div class="mt-8">
            <Label id="requires_third_market_research" value="¿Requiere de un tercer estudio de mercado?" class="inline-block mb-4" />
            <br>
            <Switch bind:checked={$form.requires_third_market_research} />
        </div>

        {#if $form.requires_third_market_research}
            <h1 class="text-center mt-20 mb-20">Tercer estudio de mercado</h1>
            <div class="mt-4">
                <Label required class="mb-4" id="third_price_quote" value="Valor (incluido IVA)" />
                <Input id="third_price_quote" type="number" min="0" class="mt-1 block w-full" bind:value={$form.third_price_quote} error={errors.third_price_quote} required />
            </div>

            <div class="mt-4">
                <Label required class="mb-4" id="third_company_name" value="Nombre de la empresa" />
                <Input id="third_company_name" type="text" class="mt-1 block w-full" bind:value={$form.third_company_name} error={errors.third_company_name} required />
            </div>

            <div class="mt-4">
                <Label required class="mb-4" id="third_price_quote_file" value="Soporte" />
                <File id="third_price_quote_file" type="file" accept="application/pdf" class="mt-1 block w-full" bind:value={$form.third_price_quote_file} error={errors.third_price_quote_file} required />
            </div>
        {/if}
    </div>
    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center sticky bottom-0">
        <p class="break-all w-72">
            Valor promedio: ${ average > 0 ? new Intl.NumberFormat('de-DE').format(average) : 0 } COP
        </p>
        {#if canCreateMarketResearch || isSuperAdmin}
            <LoadingButton loading={sending} class="btn-indigo ml-auto" type="submit">
                {$_('Create')} {$_('Market research.singular')}
            </LoadingButton>
        {/if}
    </div>
</form>
