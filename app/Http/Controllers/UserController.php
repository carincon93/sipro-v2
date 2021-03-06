<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [User::class]);

        return Inertia::render('Users/Index', [
            'filters'   => request()->all('search'),
            'users'     => User::orderBy('name', 'ASC')
                ->filterUser(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [User::class]);

        $documentTypes      = [['value' => 'CC', 'label' => 'Cédula de ciudadanía'], ['value' => 'CE', 'label' => 'Cédula de extranjería'], ['value' => 'TI', 'label' => 'Tarjeta de identidad']];
        $participationTypes = [['value' => 'Planta', 'label' => 'Planta'], ['value' => 'Planta temporal', 'label' => 'Planta temporal'], ['value' => 'Contratista', 'label' => 'Contratista']];

        return Inertia::render('Users/Create', [
            'documentTypes'         => $documentTypes,
            'participationTypes'    => $participationTypes,
            'roles'                 => Role::select('id', 'name')->get('id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', [User::class]);

        $user = new User();

        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->password             = $user::makePassword($request->document_number);
        $user->document_type        = $request->document_type;
        $user->document_number      = $request->document_number;
        $user->cellphone            = $request->cellphone;
        $user->is_enabled           = $request->is_enabled;
        $user->participation_type   = $request->participation_type;
        $user->academic_centre_id   = $request->academic_centre_id;

        $user->save();

        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', [User::class, $user]);

        return Inertia::render('Users/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', [User::class, $user]);

        $documentTypes      = [['value' => 'CC', 'label' => 'Cédula de ciudadanía'], ['value' => 'CE', 'label' => 'Cédula de extranjería'], ['value' => 'TI', 'label' => 'Tarjeta de identidad']];
        $participationTypes = [['value' => 'Planta', 'label' => 'Planta'], ['value' => 'Planta temporal', 'label' => 'Planta temporal'], ['value' => 'Contratista', 'label' => 'Contratista']];

        return Inertia::render('Users/Edit', [
            'user'                  => $user,
            'documentTypes'         => $documentTypes,
            'participationTypes'    => $participationTypes,
            'user_roles'            => $user->roles()->pluck('id'),
            'roles'                 => Role::select('id', 'name')->get('id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', [User::class, $user]);

        $user->name                 = $request->name;
        $user->email                = $request->email;
        $user->document_type        = $request->document_type;
        $user->document_number      = $request->document_number;
        $user->cellphone            = $request->cellphone;
        $user->is_enabled           = $request->is_enabled;
        $user->participation_type   = $request->participation_type;
        $user->academic_centre_id   = $request->academic_centre_id;

        $user->save();

        $user->syncRoles($request->roles);

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', [User::class, $user]);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'The resource has been deleted successfully.');
    }
}
