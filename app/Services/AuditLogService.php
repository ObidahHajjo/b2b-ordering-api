<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuditLogService
{
    /**
     * Write a security audit log.
     *
     * @param  string  $event  Audit event name.
     * @param  string  $message  Audit message.
     * @param  array<string, mixed>  $context  Audit context.
     */
    public function security(string $event, string $message, array $context = []): void
    {
        $this->write('security', $event, $message, $context);
    }

    /**
     * Write an account audit log.
     *
     * @param  string  $event  Audit event name.
     * @param  string  $message  Audit message.
     * @param  array<string, mixed>  $context  Audit context.
     */
    public function account(string $event, string $message, array $context = []): void
    {
        $this->write('account', $event, $message, $context);
    }

    /**
     * Write an audit log entry.
     *
     * @param  string  $category  Audit category.
     * @param  string  $event  Audit event name.
     * @param  string  $message  Audit message.
     * @param  array<string, mixed>  $context  Audit context.
     */
    public function write(string $category, string $event, string $message, array $context = []): void
    {
        try {
            $request = app()->bound('request') ? app(Request::class) : null;

            AuditLog::create([
                'category' => $category,
                'event' => $event,
                'level' => $context['level'] ?? 'info',
                'message' => $message,
                'context' => $context === [] ? null : $context,
                'user_id' => $context['user_id'] ?? null,
                'subject_type' => $context['subject_type'] ?? null,
                'subject_id' => $context['subject_id'] ?? null,
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
                'logged_at' => now(),
            ]);
        } catch (Throwable $exception) {
            Log::warning('Failed to persist audit log.', [
                'audit_category' => $category,
                'audit_event' => $event,
                'audit_message' => $message,
                'audit_context' => $context,
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
