<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    protected function abortIfNotAdmin()
    {
        abort_if(!auth()->user()->roles->contains('title', 'Admin'), 403);
    }
}
