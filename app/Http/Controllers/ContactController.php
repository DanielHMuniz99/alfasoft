<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Interfaces\CountryServiceInterface;

class ContactController extends Controller
{
    /**
     * @var CountryServiceInterface
     */
    protected $countryService;

    /**
     * Constructor for ContactController.
     *
     * @param CountryServiceInterface $countryService Service for country-related operations
     */
    public function __construct(CountryServiceInterface $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Show the form for creating a new contact for a specific person.
     *
     * @param Person $person The person to associate the contact with
     * @return \Illuminate\View\View
     */
    public function create(Person $person)
    {
        $countries = $this->countryService->getCountries();
        return view('contacts.form', compact('person', 'countries'));
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param Request $request
     * @param Person $person The person to associate the contact with
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @bodyParam country_code string required The country code (max 5 characters)
     * @bodyParam number string required The phone number (must be 9 digits)
     */
    public function store(Request $request, Person $person)
    {
        $validated = $request->validate([
            'country_code' => 'required|string|max:5',
            'number' => ['required', 'regex:/^\d{9}$/'],
        ]);

        $person->contacts()->create($validated);
        return redirect()->route('people.show', $person)->with('success', 'Contact added!');
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param Contact $contact The contact to edit
     * @return \Illuminate\View\View
     */
    public function edit(Contact $contact)
    {
        $countries = $this->countryService->getCountries();
        return view('contacts.form', compact('contact', 'countries'));
    }

    /**
     * Update the specified contact in storage.
     *
     * @param Request $request
     * @param Contact $contact The contact to update
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @bodyParam country_code string required The country code (max 5 characters)
     * @bodyParam number string required The phone number (must be 9 digits)
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'country_code' => 'required|string|max:5',
            'number' => ['required', 'regex:/^\d{9}$/'],
        ]);

        $contact->update($validated);
        return redirect()->route('people.show', $contact->person_id)->with('success', 'Contact updated!');
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param Contact $contact The contact to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $personId = $contact->person_id;
        $contact->delete();
        return redirect()->route('people.show', $personId)->with('success', 'Contact deleted!');
    }
}