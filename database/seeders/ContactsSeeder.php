<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('ContactSeeder started');
    try {
        //
         $path=database_path('data/contacts.json');

            if(!File::exists($path))
            {
                $this->command?->error("File not foun at {$path}");
                return;
            }
            $contacts_json= File::get($path);
            $item_= json_decode($contacts_json,true);


            foreach ($item_ as $item_collection)
                {
                        //First we create or update company
                        $companyDetails = $item_collection['company']?? null;
                         Log::info('Checkdetails');
                        if(!$companyDetails)
                            {
                                 Log::info('no details');
                                continue;
                            }
                            Log::info('company started');
                        $company= Company::updateOrCreate(
                             
                            ['id'=>$companyDetails['id']],
                            [
                                'name' => $companyDetails['name']?? null,
                                'postcode' => $companyDetails['postcode']?? null,
                            ]
                        );
                        Log::info('company finished');

                        //Cotinue with Contact
                        Contact::updateOrCreate(
                            ['id'=> $item_collection['id']],
                            [
                             'firstname' => $item_collection['firstname']??null,
                             'lastname' => $item_collection['lastname']??null,
                             'email' => $item_collection['email']??null,
                             'company_id' => $company->id,

                            
                            ]
                        );
                        Log::info('contacts finished');
                    }
                    
            }
                   catch (\Throwable $e) {

            Log::error('ContactSeeder failed', [
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);
        } 
 
    }
}
