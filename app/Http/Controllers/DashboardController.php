<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard principal
     */
    public function index(): View
    {
        return view('dashboard', [
            'pageTitle' => 'Dashboard',
            'stats' => $this->getDashboardStats(),
        ]);
    }
    
    /**
     * Obtém estatísticas para o dashboard
     */
    private function getDashboardStats(): array
    {
        return [
            'users' => 1234,
            'revenue' => 45678,
            'orders' => 890,
        ];
    }
}
