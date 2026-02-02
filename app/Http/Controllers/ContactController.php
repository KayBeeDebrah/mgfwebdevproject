<?php

namespace App\Http\Controllers;
use App\Support\Validation\ContactValidation;
use App\Models\Contact;
use App\Models\Company;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
         // eager load company to avoid N+1 queries
        //$contacts = Contact::with('company')->paginate(15);

        $search = $request->query('search');      // filter by name/email
        $company = $request->query('company');    // filter by company name
        $sort = $request->query('sort', 'lastname_asc'); // default sort

        $query = Contact::with('company');

        // simple search on firstname, lastname, email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // filter by company name
        if ($company) {
            $query->whereHas('company', function ($q) use ($company) {
                $q->where('name', 'like', "%{$company}%");
            });
        }

  // sorting
        switch ($sort) {
            case 'firstname_asc':
                $query->orderBy('firstname', 'asc');
                break;
            case 'firstname_desc':
                $query->orderBy('firstname', 'desc');
                break;
            case 'lastname_desc':
                $query->orderBy('lastname', 'desc');
                break;
            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;
            case 'email_desc':
                $query->orderBy('email', 'desc');
                break;
            default: // lastname_asc
                $query->orderBy('lastname', 'asc');
        }

       $contacts = $query->paginate(15)->appends($request->query());
         return view('contacts.index', [
            'contacts' => $contacts,
            'search'   => $search,
            'company'  => $company,
            'sort'     => $sort,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $companies = Company::orderBy('name')->pluck('name', 'id');
    return view('contacts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        #$validated = $request->validate([
        #'firstname' => 'required|string|max:45',
        #'lastname' => 'required|string|max:45',
        #'email' => 'required|email|unique:contacts,email|max:90',
        #'company_id' => 'nullable|exists:companies,id',
        #]);

        

        $validated = $request->validate(ContactValidation::rules());

        //$validated = $request->validated();   // already validated        
        Contact::create($validated);

        return redirect()->route('contacts.index')
        ->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
        //dd($contact);
        $companies = Company::orderBy('name')->pluck('name', 'id');
         return view('contacts.edit', compact('contact', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
        $validated = $request->validate([
        'firstname'  => 'required|string|max:45',
        'lastname'   => 'required|string|max:45',
        'email'      => 'required|email|unique:contacts,email,' . $contact->id,
        'company_id' => 'nullable|exists:companies,id',
        ]);

         $contact->update($validated);

        // return view('contacts.index', ['contact' => $contact]);
         // Preserve ALL query params from original request
        
         return redirect()->route('contacts.index', request()->query())
        ->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
        $contact->delete(); // soft delete: sets deleted_at
        return redirect()->route('contacts.index')
            ->with('status', 'Contact deleted.');
    }

   

public function report(Request $request)
{
   // Group contacts by company postcode (area) and count them
        $rows = Contact::select(
                'companies.postcode as area',
                DB::raw('count(contacts.id) as contact_count')
            )
            ->join('companies', 'companies.id', '=', 'contacts.company_id')
            ->groupBy('companies.postcode')
            ->orderBy('companies.postcode')
            ->get();

        $totalContacts = Contact::count();

        return view('contacts.report', compact('rows', 'totalContacts'));
        //return view('contacts.report', compact('report', 'totalContacts', 'companies', 'postcode'));
    }

}
