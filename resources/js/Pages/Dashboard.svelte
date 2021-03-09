<script>
    import AuthenticatedLayout from '@/Layouts/Authenticated'
    import { _ } from 'svelte-i18n'
</script>

<AuthenticatedLayout>
    <!-- <template #header> -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {$_("Dashboard")}
        </h2>
    <!-- </template> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>

