<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\AuditLogService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = $request->user();

        if ($user !== null && $user->is_active === null) {
            $this->auditLogService->security(
                'approved_area_access_blocked',
                'A pending account was blocked from accessing an approved-only area.',
                [
                    'user_id' => $user->id,
                    'subject_type' => User::class,
                    'subject_id' => $user->id,
                    'email' => $user->email,
                    'path' => $request->path(),
                    'level' => 'warning',
                ],
            );

            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('status', 'Your account is awaiting admin approval.');
        }

        return $next($request);
    }
}
