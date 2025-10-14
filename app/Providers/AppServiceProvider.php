<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Definisikan Blade Directive @currency
        Blade::directive('currency', function ($expression) {
            // $expression akan berisi variabel seperti $data['submission']->monthly_installment
            // Kita gunakan number_format untuk format Rupiah yang umum
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });
        
        // Pastikan RouteServiceProvider sudah ada
        // (Ini hanya untuk referensi, tapi penting untuk Bootstrap)
    }
    public const HOME = '/dashboard'; // Hapus atau biarkan saja (tidak akan digunakan)

    public static function HOME(string $role): string
    {
        return match ($role) {
            'admin' => '/admin/dashboard',
            'user' => '/user/dashboard',
            default => '/dashboard', // Fallback jika role tidak terdefinisi
        };
    }
}
