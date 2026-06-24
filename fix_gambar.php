<?php
// Jalankan: php fix_gambar.php
// Hapus file ini setelah selesai!

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$files = glob(__DIR__ . '/public/images/tempat_pkl/*');
$updated = 0;

foreach ($files as $file) {
    $filename = basename($file);
    $normFile = strtolower(preg_replace('/[^a-z0-9]/i', '', pathinfo($filename, PATHINFO_FILENAME)));

    foreach (App\Models\TempatPkl::all() as $tempat) {
        $normName = strtolower(preg_replace('/[^a-z0-9]/i', '', $tempat->nama_instansi));
        if ($normFile && $normName && (str_contains($normFile, $normName) || str_contains($normName, $normFile))) {
            $tempat->update(['gambar' => 'tempat_pkl/' . $filename]);
            echo "OK: {$tempat->nama_instansi} -> {$filename}\n";
            $updated++;
            break;
        }
    }
}

echo "\nSelesai. {$updated} record diupdate.\n";
