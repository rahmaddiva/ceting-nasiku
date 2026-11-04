<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait StoresUploadedImage
{
    /**
     * Simpan gambar unggahan dengan ekstensi dari MIME yang sudah lolos validasi,
     * bukan dari nama file klien. `getClientOriginalExtension()` bisa berisi
     * `.php` pada polyglot yang lolos rule `mimes:` → file tereksekusi di web root.
     *
     * @param  string  $dir  sub-direktori relatif terhadap public/, mis. 'images/recipes'
     * @return string path relatif untuk disimpan di database
     */
    protected function storeImage(UploadedFile $file, string $dir): string
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        $mime = (string) $file->getMimeType();
        $extension = $extensions[$mime] ?? 'jpg';

        $target = public_path($dir);
        if (! is_dir($target)) {
            mkdir($target, 0755, true);
        }

        $filename = Str::random(40).'.'.$extension;
        $file->move($target, $filename);

        return $dir.'/'.$filename;
    }
}
