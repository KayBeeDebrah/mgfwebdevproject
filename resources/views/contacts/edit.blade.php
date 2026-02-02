<x-layout>
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">Update Contact</h1>
    </div>

    {{-- Errors (BEFORE form) --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg mx-6 mt-4">
            <ul class="text-sm text-red-800 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contacts.update', $contact) }}">
        @csrf
        @method('PUT')

        <div class="card bg-base-100 w-full max-w-3xl mx-auto shadow-2xl my-6">
            <div class="card-body">
                <fieldset class="fieldset">
                    <label class="label">First Name</label>
                    <input 
                        id="firstname" 
                        name="firstname" 
                        type="text" 
                        value="{{ old('firstname', $contact->firstname) }}" 
                        class="input input-bordered w-full @error('firstname') border-red-500 ring-1 ring-red-200 @enderror"
                        placeholder="First Name" 
                    />

                    <label class="label">Last Name</label>
                    <input 
                        id="lastname" 
                        name="lastname" 
                        type="text" 
                        value="{{ old('lastname', $contact->lastname) }}" 
                        class="input input-bordered w-full @error('lastname') border-red-500 ring-1 ring-red-200 @enderror"
                        placeholder="Last Name" 
                    />

                    <label class="label">Email</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ old('email', $contact->email) }}" 
                        class="input input-bordered w-full @error('email') border-red-500 ring-1 ring-red-200 @enderror"
                        placeholder="Email" 
                    />

                    <div>
                        <label for="company_id" class="label">Company (Optional)</label>
                        <select 
                            id="company_id"
                            name="company_id"
                            class="input input-bordered w-full @error('company_id') border-red-500 ring-1 ring-red-200 @enderror"
                        >
                            <option value="">Select Company</option>
                            @foreach($companies as $id => $name)
                                <option value="{{ $id }}" {{ old('company_id', $contact->company_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-6">
                        <button type="submit" class="btn btn-neutral flex-1">Update</button>
                        <a href="{{ route('contacts.index') }}" class="btn btn-ghost flex-1">Cancel</a>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
</x-layout>
