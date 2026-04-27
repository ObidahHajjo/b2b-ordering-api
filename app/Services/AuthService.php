<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Rules\Password;

class AuthService
{
    public function __construct(private readonly AuthRepositoryInterface $authRepository)
    {
    }

    /**
     * @param array<string, string> $input
     */
    public function register(array $input): User
    {
        $input = $this->normalizeRegistrationInput($input);

        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ])->validate();

        return $this->authRepository->createUser([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'] ?? '',
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }

    public function authenticate(Request $request): ?User
    {
        $email = (string) $request->input(Fortify::username());
        $password = (string) $request->input('password');

        if ($email === '' || $password === '') {
            return null;
        }

        $user = $this->authRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }

    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    /**
     * @param array<string, string> $input
     * @return array<string, string>
     */
    private function normalizeRegistrationInput(array $input): array
    {
        if (isset($input['first_name'])) {
            return $input;
        }

        $name = trim($input['name'] ?? '');
        [$firstName, $lastName] = array_pad(preg_split('/\s+/', $name, 2), 2, '');

        return [
            ...$input,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ];
    }
}
