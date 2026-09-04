<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function index()
    {
        $this->abortIfNotAdmin();

        return view('admin.settings.maintenance');
    }

    public function migrate()
    {
        $this->abortIfNotAdmin();

        try {
            Artisan::call('migrate', ['--force' => true]);

            return back()->with([
                'success' => 'Migration command completed.',
                'artisan_output' => Artisan::output(),
            ]);
        } catch (\Throwable $e) {
            return back()->with([
                'error' => 'Migration command failed: ' . $e->getMessage(),
                'artisan_output' => Artisan::output(),
            ]);
        }
    }

    public function seed(Request $request)
    {
        $this->abortIfNotAdmin();

        $data = $request->validate([
            'seeder' => 'required|string',
        ]);

        $seeders = $this->allowedSeeders();

        if (!array_key_exists($data['seeder'], $seeders)) {
            return back()->with('error', 'Selected seeder is not allowed.');
        }

        try {
            Artisan::call('db:seed', [
                '--class' => '\\' . $data['seeder'],
                '--force' => true,
            ]);

            return back()->with([
                'success' => $seeders[$data['seeder']] . ' completed.',
                'artisan_output' => Artisan::output(),
            ]);
        } catch (\Throwable $e) {
            return back()->with([
                'error' => 'Seeder failed: ' . $e->getMessage(),
                'artisan_output' => Artisan::output(),
            ]);
        }
    }

    protected function abortIfNotAdmin()
    {
        abort_if(!auth()->user()->roles->contains('title', 'Admin'), 403);
    }

    protected function allowedSeeders()
    {
        return [
            'SubscriptionPlansTableSeeder' => 'Subscription plans seeder',
            'PaymentSettingsTableSeeder' => 'Payment settings seeder',
        ];
    }
}
