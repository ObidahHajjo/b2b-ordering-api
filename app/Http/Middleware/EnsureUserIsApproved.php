<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\AuditLogService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Create the approval middleware.
     *
     * @param  AuditLogService  $auditLogService  Audit log service.
     * @return void
     */
    public function __construct(private readonly AuditLogService $auditLogService) {}

    /**
     * Block pending users.
     *
     * @param  \Closure(Request): Response  $next
     * @param  Request  $request  Incoming request.
     * @return Response Next response or forbidden response.
     */
    public function handle(Request $request, Closure $next): Response
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

            return response()->json([
                'message' => 'Your account is awaiting admin approval.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
