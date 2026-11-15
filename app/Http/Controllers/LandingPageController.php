<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Halaman depan publik (landing page) Paketpas.
 */
class LandingPageController extends Controller
{
    public function __invoke(): View
    {
        $whatsapp = config('landing.whatsapp');
        $email = config('landing.email');

        $contactUrl = match (true) {
            filled($whatsapp) => 'https://wa.me/'.$whatsapp.'?text='.rawurlencode((string) config('landing.whatsapp_message')),
            filled($email) => 'mailto:'.$email.'?subject='.rawurlencode('Demo Paketpas'),
            default => route('login'),
        };

        return view('landing', [
            'contactUrl' => $contactUrl,
            'contactIsExternal' => filled($whatsapp) || filled($email),
            'contactName' => filled($whatsapp) ? config('landing.contact_name') : null,
        ]);
    }
}
