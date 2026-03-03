<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard principal com estatísticas de resumo.
     */
    public function index(): View
    {
        return view('dashboard', [
            'pageTitle' => 'Dashboard',
            'stats' => $this->getDashboardStats(),
        ]);
    }

    /**
     * Retorna dados de exemplo para os cards de estatísticas do dashboard.
     *
     * Em uma aplicação real, estes valores viriam de queries ao banco de dados
     * (ex: User::count(), Order::sum('total'), etc.).
     *
     * @return array<string, int>
     */
    private function getDashboardStats(): array
    {
        return [
            'users' => 1234,    // Total de usuários cadastrados
            'revenue' => 45678, // Receita total em centavos
            'orders' => 890,    // Total de pedidos realizados
        ];
    }
}
