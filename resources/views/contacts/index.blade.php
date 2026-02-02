<x-layout>

     <div class="px-6 py-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">Contacts</h1>
        <a href="/contacts/create" class="btn btn-neutral btn-outline">New Contact</a>
        <a class="btn btn-neutral btn-outline" href="{{ route('contacts.report') }}" class="text-blue-600 hover:text-blue-900">
    📊 Reports
</a>

    </div>
<form method="GET" action="{{ route('contacts.index') }}" class="flex gap-2 items-end">
 
    <input
        type="text" name="search" class="input"  placeholder="Search name or email"
        value="{{ $search ?? '' }}">

 
 
    <input
        type="text"
        name="company"
        class="input"
        placeholder="Filter by company"
        value="{{ $company ?? '' }}"
    >
 


 
    <select name="sort"  class="px-3 py-2 border border-gray-100 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-black-500 focus:border-black-500">
        <option value="lastname_asc"  @selected(($sort ?? '') === 'lastname_asc')>Last name A–Z</option>
        <option value="lastname_desc" @selected(($sort ?? '') === 'lastname_desc')>Last name Z–A</option>
        <option value="firstname_asc" @selected(($sort ?? '') === 'firstname_asc')>First name A–Z</option>
        <option value="firstname_desc"@selected(($sort ?? '') === 'firstname_desc')>First name Z–A</option>
        <option value="email_asc"     @selected(($sort ?? '') === 'email_asc')>Email A–Z</option>
        <option value="email_desc"    @selected(($sort ?? '') === 'email_desc')>Email Z–A</option>
    </select>
   

    <button class="btn btn-neutral btn-outline" type="submit">Apply</button>
    <a class="btn btn-neutral btn-outline" href="contacts">Reset</a>
</form>
<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
<table class="table table-xs" >
    <thead>
    <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Company</th>
        <th>Postcode</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse ($contacts as $contact)
        <tr>
            <td>{{ $contact->id }}</td>
            <td>{{ $contact->firstname }}</td>
            <td>{{ $contact->lastname }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->company?->name }}</td>
            <td>{{ $contact->company?->postcode }}</td>
            <td><a href="{{ route('contacts.edit', $contact) }}" class="px-4 py-2 bg-blue-600 text-white rounded">Edit</a></td>
            <td>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Delete this contact?');">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded" type="submit">Delete</button>
                </form>
            </td>
        
        </tr>
        @empty
    <tr>
        <td colspan="7">No contacts found.</td>
    </tr>
    @endforelse
    </tbody>
</table>
</div>

<div style="margin-top: 1rem;">
    {{ $contacts->links() }}
</div>

</x-layout>