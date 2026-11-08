<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DownloadPrincipiosImagesCommand extends Command
{
    protected $signature = 'page:download-principios-images';

    protected $description = 'Descarga imágenes de uso libre (Pexels) para los principios rectores de Quiénes Somos';

    /**
     * Fuentes Pexels (licencia libre): personas felices relacionadas con cada principio.
     *
     * @var array<int, array{file: string, url: string, credit: string}>
     */
    private array $images = [
        [
            'file' => 'excelencia.jpg',
            'url' => 'https://images.pexels.com/photos/5214995/pexels-photo-5214995.jpeg?auto=compress&cs=tinysrgb&w=800',
            'credit' => 'Pexels — profesional científica sonriente (excelencia técnica y científica)',
        ],
        [
            'file' => 'etica.jpg',
            'url' => 'https://images.pexels.com/photos/6129450/pexels-photo-6129450.jpeg?auto=compress&cs=tinysrgb&w=800',
            'credit' => 'Pexels / RDNE — profesionales de salud sonriendo (ética e integridad)',
        ],
        [
            'file' => 'proposito-social.jpg',
            'url' => 'https://images.pexels.com/photos/6646951/pexels-photo-6646951.jpeg?auto=compress&cs=tinysrgb&w=800',
            'credit' => 'Pexels / RDNE — voluntarios sonriendo (propósito social)',
        ],
        [
            'file' => 'transparencia.jpg',
            'url' => 'https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=800',
            'credit' => 'Pexels — equipo en reunión abierta (transparencia)',
        ],
        [
            'file' => 'gestion.jpg',
            'url' => 'https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg?auto=compress&cs=tinysrgb&w=800',
            'credit' => 'Pexels — colaboración en equipo (gestión eficiente)',
        ],
    ];

    public function handle(): int
    {
        $dir = public_path('img/principios');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $downloaded = 0;

        foreach ($this->images as $image) {
            $path = $dir.DIRECTORY_SEPARATOR.$image['file'];
            $this->line("Descargando {$image['file']}…");
            $this->comment("  {$image['credit']}");

            try {
                $response = Http::timeout(60)
                    ->withHeaders(['User-Agent' => 'IDCBIS-Web/1.0'])
                    ->get($image['url']);

                if ($response->successful() && strlen($response->body()) > 1000) {
                    file_put_contents($path, $response->body());
                    $downloaded++;
                    $this->info("  ✓ {$image['file']} (".number_format(strlen($response->body()) / 1024, 1).' KB)');
                } else {
                    $this->warn("  ✗ Respuesta inválida ({$response->status()})");
                }
            } catch (\Throwable $e) {
                $this->warn("  ✗ {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("Descargadas {$downloaded}/".count($this->images)." imágenes en public/img/principios/");

        return $downloaded === count($this->images) ? self::SUCCESS : self::FAILURE;
    }
}
