<x-layout>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
            .print-break { page-break-before: always; }
        }
    </style>

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm border print:shadow-none print:border-none">
        
        {{-- Print Header / Screen Controls --}}
        <div class="px-6 py-4 border-b border-gray-200 print:border-b-2 print:border-black">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:flex-col print:items-stretch">
                <div class="print:text-left">
                    <h1 class="text-3xl font-bold text-gray-900 print:text-2xl print:font-black">
                        Contacts by Area Report
                    </h1>
                    <p class="text-gray-600 mt-1 print:text-black print:font-medium">
                        Generated: {{ now()->format('d M Y H:i') }} | Total: {{ number_format($totalContacts) }} contacts
                    </p>
                </div>
                
                {{-- Print Button - HIDDEN when printing --}}
                <div class="no-print flex gap-2 print:hidden">
                    <button 
                        onclick="window.print()" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 font-medium flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </button>
                    <a href="{{ route('contacts.index') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-medium">
                        Back to Contacts
                    </a>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto print:overflow-visible">
            <table class="min-w-full divide-y divide-gray-200 print:divide-gray-400">
                <thead class="bg-gray-50 print:bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider print:text-sm print:font-bold print:border-b-2 print:border-gray-400">
                            Area (Postcode)
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider print:text-sm print:font-bold print:border-b-2 print:border-gray-400">
                            Contacts
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-900 uppercase tracking-wider print:text-sm print:font-bold print:border-b-2 print:border-gray-400">
                            Percentage
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 print:divide-gray-300">
                    @forelse ($rows as $index => $row)
                        <tr class="hover:bg-gray-50 print:hover:bg-white print:odd:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 print:text-base print:font-semibold">
                                {{ $row->area ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 print:text-lg print:font-bold">
                                {{ number_format($row->contact_count) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-right print:text-base print:font-semibold">
                                @if($totalContacts > 0)
                                    <span class="print:text-black">
                                        {{ number_format(($row->contact_count / $totalContacts) * 100, 1) }}%
                                    </span>
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 print:text-lg">
                                No contacts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50 print:bg-gray-100 print:border-t-4 print:border-black">
                    <tr>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900 print:text-xl print:font-black print:border-t-2 print:border-gray-400"></td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900 print:text-xl print:font-black print:border-t-2 print:border-gray-400">
                            {{ number_format($totalContacts) }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right print:text-xl print:font-black print:border-t-2 print:border-gray-400">
                            100%
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Footer - Only on screen --}}
        <div class="no-print px-6 py-4 bg-gray-50 border-t border-gray-200 text-center text-sm text-gray-500">
            Generated on {{ now()->format('d M Y H:i') }}
        </div>
    </div>
</x-layout>
