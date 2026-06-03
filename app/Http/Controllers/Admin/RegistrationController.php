<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    /**
     * Display pending professional registrations.
     *
     * @return JsonResponse Pending registration response.
     */
    public function pending(): JsonResponse
    {
        $users = User::query()
            ->with(['store.files', 'role'])
            ->whereNull('is_active')
            ->orderBy('created_at')
            ->get()
            ->map(function (User $user): array {
                return [
                    'id' => $user->hashid,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'store' => [
                        'id' => $user->store?->id,
                        'name' => $user->store?->name,
                        'legal_status' => $user->store?->legal_status,
                        'siret' => $user->store?->siret,
                        'email' => $user->store?->email,
                        'phone' => $user->store?->phone,
                        'files' => $user->store?->files->map(fn ($file): array => [
                            'id' => $file->id,
                            'name' => $file->name,
                            'path' => $file->path,
                            'uploaded_at' => $file->uploaded_at?->toISOString(),
                        ])->values() ?? [],
                    ],
                    'created_at' => $user->created_at?->toISOString(),
                ];
            })->values();

        return response()->json([
            'pending_registrations' => $users,
        ]);
    }
}
