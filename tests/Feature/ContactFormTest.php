<?php

namespace Tests\Feature;

use App\Mail\ContactFormSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function contacto_content_data_has_hero_contact_and_form_blocks()
    {
        $content = require database_path('data/contacto-content.php');

        $this->assertIsArray($content);
        $this->assertCount(3, $content);
        $this->assertSame('hero', $content[0]['type'] ?? null);
        $this->assertSame('idcbis-contact', $content[1]['type'] ?? null);
        $this->assertSame('form', $content[2]['type'] ?? null);
        $this->assertNotEmpty($content[2]['fields'] ?? []);
    }

    /** @test */
    public function contacto_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\ContactoPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'contacto',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'contacto')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('form', $page->content[2]['type'] ?? null);
    }

    /** @test */
    public function contact_form_sends_email_to_configured_recipient()
    {
        Mail::fake();

        config([
            'contact.mail_to' => 'destino@idcbis.org.co',
            'contact.mail_to_name' => 'Equipo IDCBIS',
        ]);

        $response = $this->postJson('/api/contact', [
            'nombre' => 'María García',
            'email' => 'maria@ejemplo.com',
            'asunto' => 'Consulta general',
            'mensaje' => 'Deseo información sobre donación de sangre.',
        ]);

        $response->assertOk()
            ->assertJsonPath('message', 'Su mensaje fue enviado correctamente. Nos pondremos en contacto pronto.');

        Mail::assertSent(ContactFormSubmitted::class, function (ContactFormSubmitted $mail) {
            return $mail->hasTo('destino@idcbis.org.co', 'Equipo IDCBIS')
                && $mail->data['nombre'] === 'María García'
                && $mail->data['email'] === 'maria@ejemplo.com'
                && $mail->data['asunto'] === 'Consulta general';
        });
    }

    /** @test */
    public function contact_form_validates_required_fields()
    {
        Mail::fake();

        $response = $this->postJson('/api/contact', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nombre', 'email', 'asunto', 'mensaje']);

        Mail::assertNothingSent();
    }
}
