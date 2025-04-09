<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Interfaces\AvatarServiceInterface;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of all people.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $people = Person::all();
        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new person.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('people.form');
    }

    /**
     * Store a newly created person in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  AvatarServiceInterface  $avatarService
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, AvatarServiceInterface $avatarService)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:6',
            'email' => 'required|email|unique:people',
        ]);
    
        $validated['avatar'] = $avatarService->generateUrl($validated['name']);
    
        Person::create($validated);
    
        return redirect()->route('people.index')->with('success', 'Person created!');
    }

    /**
     * Display the specified person.
     *
     * @param  Person  $person
     * @return \Illuminate\View\View
     */
    public function show(Person $person)
    {
        return view('people.show', compact('person'));
    }

    /**
     * Show the form for editing the specified person.
     *
     * @param  Person  $person
     * @return \Illuminate\View\View
     */
    public function edit(Person $person)
    {
        return view('people.form', compact('person'));
    }

    /**
     * Update the specified person in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Person  $person
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:6',
            'email' => 'required|email|unique:people,email,' . $person->id,
        ]);

        $person->update($validated);
        return redirect()->route('people.index')->with('success', 'Person updated!');
    }

    /**
     * Remove the specified person from storage.
     *
     * @param  Person  $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route('people.index')->with('success', 'Person deleted!');
    }
}