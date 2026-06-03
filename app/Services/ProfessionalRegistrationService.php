<?php

namespace App\Services;

use App\Models\File;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Hash;

class ProfessionalRegistrationService
{
    /**
     * Register a professional client account.
     *
     * @param  array<string, mixed>  $attributes  Registration attributes.
     * @return User Created pending user.
     */
    public function register(array $attributes): User
    {
        return DB::transaction(function () use ($attributes): User {
            $store = Store::create([
                'name' => $attributes['company_name'],
                'legal_status' => $attributes['legal_status'],
                'siret' => $attributes['siret'],
                'email' => $attributes['company_email'],
                'phone' => $attributes['company_phone'],
            ]);

            $this->storeKbisFile($store, $attributes['kbis_file']);

            $role = Role::query()->firstOrCreate([
                'name' => 'user',
            ]);

            return User::create([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'email' => $attributes['email'],
                'password' => Hash::make((string) $attributes['password']),
                'phone' => $attributes['phone'],
                'role_id' => $role?->id,
                'store_id' => $store->id,
            ]);
        });
    }

    /**
     * Store the uploaded KBIS file metadata.
     *
     * @param  Store  $store  Created store.
     * @param  UploadedFile  $file  Uploaded KBIS file.
     * @return File Created file record.
     */
    private function storeKbisFile(Store $store, UploadedFile $file): File
    {
        $directory = base_path('tmp/kbis');
        FileFacade::ensureDirectoryExists($directory);

        $fileName = uniqid('kbis_', true).'_'.$file->getClientOriginalName();
        $file->move($directory, $fileName);

        return File::create([
            'name' => $file->getClientOriginalName(),
            'path' => 'tmp/kbis/'.$fileName,
            'uploaded_at' => now(),
            'store_id' => $store->id,
        ]);
    }
}
