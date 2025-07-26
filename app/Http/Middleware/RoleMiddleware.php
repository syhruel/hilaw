<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        
        \Log::info('RoleMiddleware check', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'required_roles' => $roles,
            'is_approved' => $user->is_approved ?? 'null',
            'route' => $request->route()->getName()
        ]);
        
        if ($user->role === 'dokter' && !$user->is_approved) {
            if (!$request->routeIs('dokter.pending*')) {
                \Log::info('Dokter not approved, redirecting to pending');
                return redirect()->route('dokter.pending')
                    ->with('warning', 'Akun Anda belum disetujui admin. Silakan tunggu persetujuan.');
            }
        }

        if (!in_array($user->role, $roles)) {
            \Log::warning('Role access denied', [
                'user_role' => $user->role,
                'required_roles' => $roles
            ]);
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'Akses ditolak untuk halaman tersebut');
                case 'dokter':
                    if ($user->is_approved) {
                        return redirect()->route('dokter.dashboard')
                            ->with('error', 'Akses ditolak untuk halaman tersebut');
                    } else {
                        return redirect()->route('dokter.pending.simple')
                            ->with('error', 'Akses ditolak untuk halaman tersebut');
                    }
                case 'pengguna':
                    return redirect()->route('pengguna.dashboard')
                        ->with('error', 'Akses ditolak untuk halaman tersebut');
                default:
                    return redirect('/')
                        ->with('error', 'Akses ditolak');
            }
        }

        return $next($request);
    }
}