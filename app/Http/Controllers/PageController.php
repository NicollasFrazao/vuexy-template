<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Exibe a página de configurações da conta do usuário.
     */
    public function accountSettings(): View
    {
        return view('pages.account-settings');
    }

    /**
     * Exibe a página de perfil do usuário.
     */
    public function profile(): View
    {
        return view('pages.profile');
    }
}
