<?php

namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class DonacionesPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('donaciones', [
            'title' => 'Donaciones | IDCBIS',
            'meta_title' => 'Donar sangre o tejidos | IDCBIS',
            'meta_description' => 'Elige donar sangre o tejidos en el IDCBIS. Un acto voluntario, gratuito y altruista que puede cambiar muchas vidas.',
            'meta_keywords' => 'donaciones, donar sangre, donar tejidos, IDCBIS, altruismo, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /donaciones');
        }

        $this->pointHomeCardToDonaciones();
    }

    private function pointHomeCardToDonaciones(): void
    {
        $home = Page::query()->where('slug', 'inicio')->first();
        if (! $home || ! is_array($home->content)) {
            return;
        }

        $content = json_decode(json_encode($home->content), true);
        $changed = false;

        foreach ($content as &$block) {
            if (($block['type'] ?? null) !== 'idcbis-services' || ! is_array($block['cards'] ?? null)) {
                continue;
            }

            foreach ($block['cards'] as &$card) {
                $isDonations = ($card['id'] ?? null) === 'card_bienestar'
                    || ($card['title'] ?? null) === 'Donaciones';
                if (! $isDonations) {
                    continue;
                }

                $card['url'] = '/donaciones';
                $card['tag'] = '#ELIGEDONAR';
                $card['description'] = 'Elige donar sangre o tejidos. Un acto voluntario, gratuito y altruista.';
                $changed = true;
            }
        }
        unset($block, $card);

        if (! $changed) {
            return;
        }

        $home->content = $content;
        $home->save();

        if ($this->command) {
            $this->command->info('La tarjeta Donaciones del inicio ahora abre /donaciones');
        }
    }
}
