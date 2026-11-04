<?php

namespace Tests\Feature;

use App\Http\Middleware\TrustProxies;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withServerVariables(['REMOTE_ADDR' => '10.'.random_int(0, 255).'.'.random_int(0, 255).'.'.random_int(1, 254)]);
    }

    public function test_x_forwarded_for_from_untrusted_source_is_ignored(): void
    {
        Route::get('/_test/ip', fn () => request()->ip());

        $this->withServerVariables(['REMOTE_ADDR' => '8.8.8.8'])
            ->withHeaders(['X-Forwarded-For' => '1.2.3.4'])
            ->get('/_test/ip')
            ->assertSee('8.8.8.8')
            ->assertDontSee('1.2.3.4');
    }

    public function test_x_forwarded_for_from_cloudflare_is_honoured(): void
    {
        Route::get('/_test/ip', fn () => request()->ip());

        $this->withServerVariables(['REMOTE_ADDR' => '173.245.48.10'])
            ->withHeaders(['X-Forwarded-For' => '203.0.113.9'])
            ->get('/_test/ip')
            ->assertSee('203.0.113.9');
    }

    public function test_trusted_proxy_list_is_not_empty(): void
    {
        $proxy = new TrustProxies(app());
        $reflection = new \ReflectionProperty($proxy, 'proxies');

        $this->assertNotEmpty($reflection->getValue($proxy));
    }

    public function test_login_is_throttled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'nobody@example.test', 'password' => 'salah']);
        }

        $this->post('/login', ['email' => 'nobody@example.test', 'password' => 'salah'])
            ->assertStatus(429);
    }

    public function test_uploaded_image_keeps_its_validated_extension_only(): void
    {
        $controller = new class
        {
            use \App\Http\Controllers\Admin\Concerns\StoresUploadedImage;

            public function store(UploadedFile $file, string $dir)
            {
                return $this->storeImage($file, $dir);
            }
        };

        $hasImageDriver = extension_loaded('gd') || extension_loaded('imagick');
        if (! $hasImageDriver) {
            $this->markTestSkipped('Butuh ekstensi gd/imagick untuk membuat file gambar asli.');
        }

        $dir = 'images/_security_test';
        // Nama klien berakhiran .php tapi isinya PNG asli: ekstensi tersimpan harus
        // mengikuti isi file, bukan nama kiriman.
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $tmp = tempnam(sys_get_temp_dir(), 'up').'.php';
        file_put_contents($tmp, $png);
        $file = new UploadedFile($tmp, 'payload.php', 'image/png', null, true);

        $path = $controller->store($file, $dir);

        $this->assertMatchesRegularExpression('/^images\/_security_test\/[A-Za-z0-9]{40}\.(jpg|png)$/', $path);
        $this->assertStringNotContainsString('.php', $path);

        @unlink(public_path($path));
        @rmdir(public_path($dir));
        @unlink($tmp);
    }
}
