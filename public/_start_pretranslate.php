<?php

if (($_GET['k'] ?? '') !== 'k7m2p9qx') {
    http_response_code(404);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? 'status';
$statusFile = __DIR__.'/../storage/app/pretranslate-status.json';

if ($action === 'probe') {
    $php = 'C:\\laragon\\bin\\php\\php-8.3.19-nts-Win32-vs16-x64\\php.exe';
    $output = [];
    $code = 1;
    if (function_exists('exec')) {
        exec(escapeshellarg($php).' -r "echo PHP_VERSION;"', $output, $code);
    }
    $bg = [];
    $bgCode = 1;
    $log = __DIR__.'/../storage/app/probe-bg.txt';
    @unlink($log);
    $worker = __DIR__.'/../storage/app/probe-bg-worker.php';
    $bgCmd = 'cmd /c start /B "" '.escapeshellarg($php).' '.escapeshellarg($worker);
    exec($bgCmd, $bg, $bgCode);
    sleep(2);
    $gtx = [];
    $gtxCode = 1;
    $gtxScript = __DIR__.'/../storage/app/gtx-test.php';
    $gtxOut = __DIR__.'/../storage/app/gtx-test.txt';
    @unlink($gtxOut);
    exec(escapeshellarg($php).' '.escapeshellarg($gtxScript), $gtx, $gtxCode);
    echo json_encode([
        'php' => $php,
        'exists' => is_file($php),
        'code' => $code,
        'output' => $output,
        'bgCode' => $bgCode,
        'bgFile' => is_file($log),
        'gtxCode' => $gtxCode,
        'gtx' => $gtx,
        'gtxBody' => is_file($gtxOut) ? file_get_contents($gtxOut) : null,
    ]);
    exit;
}

if ($action === 'start') {
    $php = 'C:\\laragon\\bin\\php\\php-8.3.19-nts-Win32-vs16-x64\\php.exe';
    $worker = __DIR__.'/../storage/app/run-pretranslate.php';
    $cmd = 'cmd /c start /B "" '.escapeshellarg($php).' '.escapeshellarg($worker);
    $output = [];
    $code = 1;
    exec($cmd, $output, $code);
    echo json_encode(['ok' => $code === 0, 'code' => $code, 'cmd' => $cmd]);
    exit;
}

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if ($action === 'step') {
    set_time_limit(180);

    $offset = max(0, (int) ($_GET['offset'] ?? 0));
    $ids = Illuminate\Support\Facades\DB::table('pages')
        ->where('status', 'published')
        ->whereNull('deleted_at')
        ->orderBy('slug')
        ->pluck('slug');

    $total = $ids->count();
    if ($offset >= $total) {
        echo json_encode(['done' => true, 'offset' => $offset, 'total' => $total]);
        exit;
    }

    $slug = (string) $ids[$offset];
    $exit = $kernel->call('pages:pretranslate', [
        '--force' => true,
        '--locale' => 'en',
        '--slug' => $slug,
    ]);

    $page = App\Models\Page::query()->where('slug', $slug)->first();
    $en = is_array($page?->translations) ? ($page->translations['en'] ?? null) : null;
    $title = is_array($en) ? ($en['title'] ?? null) : null;

    echo json_encode([
        'done' => false,
        'offset' => $offset,
        'next' => $offset + 1,
        'total' => $total,
        'slug' => $slug,
        'exit' => $exit,
        'enTitle' => $title,
        'baseTitle' => $page?->title,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$state = is_file($statusFile)
    ? json_decode((string) file_get_contents($statusFile), true)
    : ['state' => 'idle'];

echo json_encode($state, JSON_UNESCAPED_UNICODE);
