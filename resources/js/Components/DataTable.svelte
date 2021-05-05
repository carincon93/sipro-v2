<h1 class="mb-8 font-bold text-3xl">
    <slot name="title" />
</h1>
<div class="mb-6 flex justify-end items-center">
    <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
    <slot name="actions" />
</div>
<div class="bg-white rounded shadow">
    <table class="w-full whitespace-no-wrap">
        <thead>
            <slot name="thead" />
        </thead>
        <slot name="tbody" />
    </table>
</div>
