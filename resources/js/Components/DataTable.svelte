<h1 class="mb-8 font-bold text-center text-3xl">
    <slot name="title" />
</h1>
<div class="mb-8">
    <slot name="caption" />
</div>
<div class="mb-6 flex justify-end items-center">
    <!-- <SearchFilter class="w-full max-w-md mr-4" bind:filters /> -->
    <slot name="actions" />
</div>
<div class="bg-white rounded shadow">
    <table class="w-full whitespace-no-wrap">
        <slot name="thead" />
        <slot name="tbody" />
        <slot name="tfoot" />
    </table>
</div>
