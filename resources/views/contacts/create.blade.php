<x-layout>
       <div class="px-6 py-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">New Contact</h1>
     
    </div>
    <form method="POST" action="/contacts">
     <!--protection from requests outside the current website-->
    @csrf
    
  <div class="card bg-base-100 w-full max-w-3xl mx-auto shadow-2xl">
  <div class="card-body">
    <fieldset class="fieldset">
      <label class="label">First Name</label>
      <input id="firstname" name="firstname" type="text" class="input input-bordered w-full @error('firstname') border-red-500 ring-1 ring-red-200 @enderror"" placeholder="First Name" />
      <label class="label">First Name</label>
      <input id="lastname" name="lastname" type="text" class="input input-bordered w-full @error('lastname') border-red-500 ring-1 ring-red-200 @enderror"" placeholder="Last Name" />
      <label class="label">Email</label>
      <input id="email" name="email" type="email" class="input input-bordered w-full @error('email') border-red-500 ring-1 ring-red-200 @enderror"" placeholder="Email" />
<div>
    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Company (Optional)
                </label>
                <select 
                    id="company_id"
                    name="company_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2  @error('company_id') border-red-500 ring-1 ring-red-200 @enderror"
                >
                    <option value="">Select Company</option>
                    @foreach($companies as $id => $name)
                        <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
      <button class="btn btn-neutral mt-4 w-full">Save</button>
        <a 
                    href="{{ route('contacts.index') }}"
                    class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg shadow-sm font-medium text-center hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200"
                >
                    Cancel
                </a>
    </fieldset>
    @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-sm text-red-800 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
  </div>
</div>

    </div>
    
    </form>
</x-layout>