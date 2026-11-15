<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Alamat utama menampilkan landing page, bukan lagi dialihkan ke panel admin.
     */
    public function test_the_root_url_shows_the_landing_page(): void
    {
        $this->get('/')->assertOk()->assertSee('Paketpas');
    }
}
