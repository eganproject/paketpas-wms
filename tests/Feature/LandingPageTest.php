<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Landing page publik di alamat utama.
 */
class LandingPageTest extends TestCase
{
    public function test_guests_see_the_landing_page_with_the_main_sections(): void
    {
        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('Paket keluar pas.', false)
            ->assertSee('id="presentasi"', false)
            ->assertSee('images/landing/web-orders.webp', false)
            ->assertSee('images/landing/app-lengkap.webp', false)
            ->assertSee('id="fitur"', false)
            ->assertSee('id="tanya"', false)
            ->assertSee('id="harga"', false)
            ->assertSee(config('landing.pricing.rent.price'))
            ->assertSee(config('landing.pricing.setup.price'))
            ->assertSee(config('landing.pricing.buy.price'))
            ->assertSee('images/paketpas-horizontal.png', false)
            ->assertSee(route('login'), false);
    }

    public function test_the_call_to_action_falls_back_to_the_login_page_without_contact(): void
    {
        config(['landing.whatsapp' => '', 'landing.email' => '']);

        $this->get(route('landing'))
            ->assertOk()
            ->assertDontSee('wa.me', false)
            ->assertDontSee('mailto:', false)
            ->assertDontSee('Ngobrol langsung via WhatsApp');
    }

    public function test_the_call_to_action_opens_whatsapp_when_a_number_is_set(): void
    {
        config(['landing.whatsapp' => '628975568102', 'landing.contact_name' => 'Ega Nugraha', 'landing.email' => 'halo@paketpas.id']);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('https://wa.me/628975568102?text=', false)
            ->assertSee('Ega Nugraha')
            ->assertSee('Chat via WhatsApp')
            ->assertDontSee('mailto:', false);
    }

    public function test_the_call_to_action_uses_email_when_only_email_is_set(): void
    {
        config(['landing.whatsapp' => '', 'landing.email' => 'halo@paketpas.id']);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('mailto:halo@paketpas.id', false);
    }

    public function test_each_plan_opens_whatsapp_with_its_own_message(): void
    {
        config(['landing.whatsapp' => '628975568102', 'landing.pricing.rent.wa' => 'Halo, paket sewa']);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('https://wa.me/628975568102?text='.rawurlencode('Halo, paket sewa'), false);
    }
}
