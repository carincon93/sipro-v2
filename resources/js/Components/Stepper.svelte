<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let call
    export let project
</script>
<!-- Steper -->
<div class="flex justify-around">
    <div>
        <a use:inertia href={route('calls.rdi.edit', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">1</div>
            <p class="text-sm">Generalidades</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.problem-tree', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">2</div>
            <p class="text-sm">Árbol de problemas</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.objectives-tree', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">3</div>
            <p class="text-sm">Árbol de objetivos</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.rdi.rdi-outputs.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">4</div>
            <p class="text-sm">Productos</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.activities.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">5</div>
            <p class="text-sm">Actividades</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.project-sennova-roles.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">6</div>
            <p class="text-sm">Roles</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.project-sennova-budgets.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">7</div>
            <p class="text-sm">Presupuesto</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.participants', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">8</div>
            <p class="text-sm">Participantes</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.risk-analysis.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">9</div>
            <p class="text-sm">Análisis de riesgos</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.rdi.partner-organizations.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">10</div>
            <p class="text-sm">Organizaciones aliadas</p>
        </a>
    </div>
    <div>
        <a use:inertia href={route('calls.projects.annexes.index', [call.id, project.id])} class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">11</div>
            <p class="text-sm">Anexos</p>
        </a>
    </div>
    <div>
        <a href="#" class="flex flex-col items-center inline-block">
            <div class="rounded-full bg-white w-11 h-11 text-center flex items-center justify-center shadow mb-2">12</div>
            <p class="text-sm">Finalzar formulación</p>
        </a>
    </div>
</div>
