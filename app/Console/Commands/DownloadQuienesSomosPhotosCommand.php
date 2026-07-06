<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DownloadQuienesSomosPhotosCommand extends Command
{
    protected $signature = 'page:download-quienes-somos-photos';

    protected $description = 'Descarga las fotos del equipo desde idcbis.org.co/quienes-somos';

    /** Orden alineado con database/data/quienes-somos-page.php */
    private array $photoSlugs = [
        'bernardo-armando-camacho-rodriguez',
        'gustavo-andres-salguero',
        'ingrid-zulay-silva-cote',
        'alvaro-ignacio-guerrero-devia',
        'diana-carolina-camelo-sanchez',
        'ana-maria-perdomo',
        'jenny-johana-pinilla-gomez',
        'cesar-augusto-ramirez-segura',
        'carlos-ayala-grosso',
        'sonia-patricia-forero',
        'jhon-alexander-bello-sepulveda',
        'paula-andrea-gaviria',
        'paola-andrea-cendales-rodriguez',
        'leidi-yohana-mendez-baez',
        'marcela-eugenia-gutierrez-esquivel',
        'sindy-lorena-alvarez-hernandez',
        'william-idarraga-ariza',
        'jeimi-martinez-osorio',
        'mariana-canas',
        'gina-alexandra-mendoza-rodriguez',
        'sandra-patricia-gomez-rubio',
        'jaime-jhonatan-rivera-diaz',
        'jose-luis-preciado-gomez',
        'german-camilo-ramirez-montenegro',
        'mary-alejandra-guarnizo-devia',
    ];

    public function handle(): int
    {
        $url = 'https://idcbis.org.co/quienes-somos/';
        $this->info("Obteniendo HTML de {$url}…");

        $response = Http::timeout(60)->get($url);
        if (! $response->successful()) {
            $this->error('No se pudo acceder al sitio oficial.');

            return self::FAILURE;
        }

        $html = $response->body();
        $dir = public_path('img/equipo');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $imageUrls = $this->extractPortraitUrls($html);

        if ($imageUrls === []) {
            $this->error('No se encontraron imágenes de retrato en la página.');

            return self::FAILURE;
        }

        $this->info('Imágenes detectadas: ' . count($imageUrls));
        $downloaded = 0;

        foreach ($this->photoSlugs as $index => $slug) {
            if (! isset($imageUrls[$index])) {
                $this->warn("  · Sin imagen para {$slug}");
                continue;
            }

            $absolute = $imageUrls[$index];
            $ext = pathinfo(parse_url($absolute, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $path = $dir . DIRECTORY_SEPARATOR . $slug . '.' . $ext;

            try {
                $img = Http::timeout(30)->get($absolute);
                if ($img->successful()) {
                    file_put_contents($path, $img->body());
                    $downloaded++;
                    $this->line("  ✓ {$slug}.{$ext}");
                }
            } catch (\Throwable) {
                $this->warn("  ✗ {$slug}");
            }
        }

        $this->newLine();
        $this->info("Descargadas {$downloaded} fotos en public/img/equipo/");
        $this->comment('Vuelve a cargar /quienes-somos para ver las imágenes.');

        return self::SUCCESS;
    }

    private function extractPortraitUrls(string $html): array
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);
        $urls = [];

        foreach (array_unique($matches[1] ?? []) as $src) {
            if (! preg_match('/\.(jpe?g|png|webp)(\?|$)/i', $src)) {
                continue;
            }

            $lower = strtolower($src);
            if (str_contains($lower, 'logo') || str_contains($lower, 'icon') || str_contains($lower, 'banner')
                || str_contains($lower, 'escudo') || str_contains($lower, 'marca') || str_contains($lower, 'mapa')) {
                continue;
            }

            $absolute = Str::startsWith($src, 'http')
                ? $src
                : 'https://idcbis.org.co' . (Str::startsWith($src, '/') ? '' : '/') . $src;

            $urls[] = $absolute;
        }

        // En el sitio oficial, las fotos del equipo suelen ser las últimas imágenes de retrato antes del footer
        $portraits = array_values(array_filter($urls, fn ($u) => ! str_contains(strtolower($u), '150x150')));

        if (count($portraits) >= count($this->photoSlugs)) {
            return array_slice($portraits, -count($this->photoSlugs));
        }

        return $portraits;
    }
}
