<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name1 = 'Uno';
        $password = '1234';

        User::factory()->create([
            'name' => 'Usuario' . ' ' . $name1,
            'email' => Str::slug($name1) . '@' . str_replace(' ', '', Str::lower(config('app.name'))) . '.com',
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'remember_token' => null
        ]);

        $name2 = 'Dos';

        User::factory()->create([
            'name' => 'Usuario' . ' ' . $name2,
            'email' => Str::slug($name2) . '@' . str_replace(' ', '', Str::lower(config('app.name'))) . '.com',
            'password' => Hash::make($password),
            'email_verified_at' => null,
            'remember_token' => null
        ]);

        $name3 = 'Tres';

        User::factory()->create([
            'name' => 'Usuario' . ' ' . $name3,
            'email' => Str::slug($name3) . '@' . str_replace(' ', '', Str::lower(config('app.name'))) . '.com',
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'remember_token' => null
        ]);

        $name4 = 'Cuatro';

        User::factory()->create([
            'name' => 'Usuario' . ' ' . $name4,
            'email' => Str::slug($name4) . '@' . str_replace(' ', '', Str::lower(config('app.name'))) . '.com',
            'password' => Hash::make($password),
            'email_verified_at' => null,
            'remember_token' => null
        ]);
    }
}
