<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignSuperAdmin extends Command
{
    /**
     * Uso: php artisan user:super-admin {email}
     */
    protected $signature = 'user:super-admin {email : Email del usuario}';

    protected $description = 'Asigna el rol super_admin a un usuario por email';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("❌ Usuario con email {$email} no encontrado.");
            return self::FAILURE;
        }

        if ($user->hasRole('super_admin')) {
            $this->info("ℹ️  {$user->name} ({$email}) ya es Super Admin.");
            return self::SUCCESS;
        }

        $user->assignRole('super_admin');
        $this->info("✅ {$user->name} ({$email}) ahora es Super Admin.");

        return self::SUCCESS;
    }
}
