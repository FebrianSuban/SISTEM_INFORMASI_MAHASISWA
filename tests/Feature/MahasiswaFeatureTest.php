<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MahasiswaFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        return User::factory()->create([
            'role' => 'admin'
        ]);
    }

    private function createRegularUser(): User
    {
        return User::factory()->create([
            'role' => 'user'
        ]);
    }

    private function getValidMahasiswaData(): array
    {
        return [
            'nim' => '232444443232',
            'nama_lengkap' => 'Yohanes Febrianus Suban',
            'jurusan' => 'Teknik Informatika',
            'tempat_lahir' => 'Keningau, Malaysia',
            'tanggal_lahir' => '1999-02-10',
            'nomor_telepon' => '081362935208',
            'email' => 'febriansuban100299@gmail.com',
            'alamat_tinggal' => 'Jl. Contoh No. 123'
        ];
    }

    // ==================== CREATE (Tambah Data) ====================

    public function test_admin_bisa_melihat_halaman_tambah_mahasiswa(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/mahasiswa/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.mahasiswa.create');
    }

    public function test_admin_bisa_tambah_data_mahasiswa(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();

        $response = $this->actingAs($admin)->post('/admin/mahasiswa', $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.mahasiswa.index'));
        $response->assertSessionHas('success', 'Data mahasiswa berhasil ditambahkan.');

        $this->assertDatabaseHas('mahasiswas', [
            'nim' => $data['nim'],
            'nama_lengkap' => $data['nama_lengkap'],
            'jurusan' => $data['jurusan'],
            'email' => $data['email'],
        ]);

        $this->assertDatabaseCount('mahasiswas', 1);
    }

    public function test_admin_bisa_tambah_data_mahasiswa_dengan_foto(): void
    {
        // Skip test jika GD extension tidak tersedia
        if (!function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension is not installed.');
        }

        Storage::fake('public');
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $data['foto'] = UploadedFile::fake()->image('foto.jpg', 800, 600);

        $response = $this->actingAs($admin)->post('/admin/mahasiswa', $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.mahasiswa.index'));

        $mahasiswa = Mahasiswa::where('nim', $data['nim'])->first();
        $this->assertNotNull($mahasiswa);
        $this->assertNotNull($mahasiswa->foto);
        Storage::disk('public')->assertExists($mahasiswa->foto);
    }

    public function test_tambah_data_mahasiswa_gagal_tanpa_autentikasi(): void
    {
        $this->assertGuest();
        $data = $this->getValidMahasiswaData();

        $response = $this->post('/admin/mahasiswa', $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('mahasiswas', 0);
    }

    public function test_tambah_data_mahasiswa_gagal_dengan_user_bukan_admin(): void
    {
        $user = $this->createRegularUser();
        $data = $this->getValidMahasiswaData();

        $response = $this->actingAs($user)->post('/admin/mahasiswa', $data);

        $response->assertStatus(403);
        $this->assertDatabaseCount('mahasiswas', 0);
    }

    public function test_tambah_data_mahasiswa_gagal_dengan_validasi_error(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->post('/admin/mahasiswa', [
            'nim' => '',
            'nama_lengkap' => '',
            'jurusan' => 'Jurusan Tidak Valid',
            'email' => 'email-tidak-valid',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'nim',
            'nama_lengkap',
            'jurusan',
            'email',
            'tempat_lahir',
            'tanggal_lahir',
            'nomor_telepon',
            'alamat_tinggal'
        ]);

        $this->assertDatabaseCount('mahasiswas', 0);
    }

    public function test_tambah_data_mahasiswa_gagal_dengan_nim_duplikat(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();

        // Tambah data pertama
        Mahasiswa::create($data);

        // Coba tambah data dengan NIM yang sama
        $response = $this->actingAs($admin)->post('/admin/mahasiswa', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('nim');
        $this->assertDatabaseCount('mahasiswas', 1);
    }

    public function test_tambah_data_mahasiswa_gagal_dengan_email_duplikat(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();

        // Tambah data pertama
        Mahasiswa::create($data);

        // Coba tambah data dengan email yang sama
        $data2 = $this->getValidMahasiswaData();
        $data2['nim'] = '232444443233'; // NIM berbeda

        $response = $this->actingAs($admin)->post('/admin/mahasiswa', $data2);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('mahasiswas', 1);
    }

    // ==================== READ (Lihat Data) ====================

    public function test_admin_bisa_melihat_list_mahasiswa(): void
    {
        $admin = $this->createAdminUser();

        // Buat beberapa data mahasiswa
        Mahasiswa::factory()->count(3)->create();

        $response = $this->actingAs($admin)->get('/admin/mahasiswa');

        $response->assertStatus(200);
        $response->assertViewIs('admin.mahasiswa.index');
        $response->assertViewHas('mahasiswas');
    }

    public function test_admin_bisa_melihat_detail_mahasiswa(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $mahasiswa = Mahasiswa::create($data);

        $response = $this->actingAs($admin)->get("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.mahasiswa.show');
        $response->assertViewHas('mahasiswa', function ($viewMahasiswa) use ($mahasiswa) {
            return $viewMahasiswa->id === $mahasiswa->id;
        });
    }

    public function test_lihat_list_mahasiswa_gagal_tanpa_autentikasi(): void
    {
        $response = $this->get('/admin/mahasiswa');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_lihat_detail_mahasiswa_gagal_tanpa_autentikasi(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $response = $this->get("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    // ==================== UPDATE (Edit Data) ====================

    public function test_admin_bisa_melihat_halaman_edit_mahasiswa(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $mahasiswa = Mahasiswa::create($data);

        $response = $this->actingAs($admin)->get("/admin/mahasiswa/{$mahasiswa->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.mahasiswa.edit');
        $response->assertViewHas('mahasiswa', function ($viewMahasiswa) use ($mahasiswa) {
            return $viewMahasiswa->id === $mahasiswa->id;
        });
    }

    public function test_admin_bisa_update_data_mahasiswa(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $mahasiswa = Mahasiswa::create($data);

        $updateData = [
            'nim' => $mahasiswa->nim, // NIM tidak berubah
            'nama_lengkap' => 'Nama Baru',
            'jurusan' => 'Sistem Informasi',
            'tempat_lahir' => 'Jakarta, Indonesia',
            'tanggal_lahir' => '2000-01-01',
            'nomor_telepon' => '081234567890',
            'email' => $mahasiswa->email, // Email tidak berubah
            'alamat_tinggal' => 'Jl. Baru No. 456'
        ];

        $response = $this->actingAs($admin)->put("/admin/mahasiswa/{$mahasiswa->id}", $updateData);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.mahasiswa.index'));
        $response->assertSessionHas('success', 'Data mahasiswa berhasil diperbarui.');

        $this->assertDatabaseHas('mahasiswas', [
            'id' => $mahasiswa->id,
            'nama_lengkap' => 'Nama Baru',
            'jurusan' => 'Sistem Informasi',
            'tempat_lahir' => 'Jakarta, Indonesia',
        ]);
    }

    public function test_admin_bisa_update_foto_mahasiswa(): void
    {
        // Skip test jika GD extension tidak tersedia
        if (!function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension is not installed.');
        }

        Storage::fake('public');
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $mahasiswa = Mahasiswa::create($data);

        $updateData = array_merge($data, [
            'foto' => UploadedFile::fake()->image('foto-baru.jpg', 800, 600)
        ]);

        $response = $this->actingAs($admin)->put("/admin/mahasiswa/{$mahasiswa->id}", $updateData);

        $response->assertStatus(302);

        $mahasiswa->refresh();
        $this->assertNotNull($mahasiswa->foto);
        Storage::disk('public')->assertExists($mahasiswa->foto);
    }

    public function test_update_data_mahasiswa_gagal_tanpa_autentikasi(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();
        $updateData = $this->getValidMahasiswaData();
        $updateData['nim'] = $mahasiswa->nim;
        $updateData['email'] = $mahasiswa->email;

        $response = $this->put("/admin/mahasiswa/{$mahasiswa->id}", $updateData);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_update_data_mahasiswa_gagal_dengan_user_bukan_admin(): void
    {
        $user = $this->createRegularUser();
        $mahasiswa = Mahasiswa::factory()->create();
        $updateData = $this->getValidMahasiswaData();
        $updateData['nim'] = $mahasiswa->nim;
        $updateData['email'] = $mahasiswa->email;

        $response = $this->actingAs($user)->put("/admin/mahasiswa/{$mahasiswa->id}", $updateData);

        $response->assertStatus(403);
    }

    public function test_update_data_mahasiswa_gagal_dengan_validasi_error(): void
    {
        $admin = $this->createAdminUser();
        $mahasiswa = Mahasiswa::factory()->create();

        $response = $this->actingAs($admin)->put("/admin/mahasiswa/{$mahasiswa->id}", [
            'nim' => $mahasiswa->nim,
            'nama_lengkap' => '',
            'jurusan' => 'Jurusan Tidak Valid',
            'email' => $mahasiswa->email,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama_lengkap', 'jurusan']);
    }

    public function test_update_data_mahasiswa_gagal_dengan_email_duplikat(): void
    {
        $admin = $this->createAdminUser();
        $mahasiswa1 = Mahasiswa::factory()->create(['email' => 'email1@test.com']);
        $mahasiswa2 = Mahasiswa::factory()->create(['email' => 'email2@test.com']);

        $updateData = $this->getValidMahasiswaData();
        $updateData['nim'] = $mahasiswa2->nim;
        $updateData['email'] = 'email1@test.com'; // Email yang sudah digunakan mahasiswa1

        $response = $this->actingAs($admin)->put("/admin/mahasiswa/{$mahasiswa2->id}", $updateData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    // ==================== DELETE (Hapus Data) ====================

    public function test_admin_bisa_hapus_data_mahasiswa(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $mahasiswa = Mahasiswa::create($data);

        $response = $this->actingAs($admin)->delete("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.mahasiswa.index'));
        $response->assertSessionHas('success', 'Data mahasiswa berhasil dihapus.');

        $this->assertDatabaseMissing('mahasiswas', [
            'id' => $mahasiswa->id
        ]);

        $this->assertDatabaseCount('mahasiswas', 0);
    }

    public function test_admin_bisa_hapus_data_mahasiswa_dengan_foto(): void
    {
        Storage::fake('public');
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();
        $data['foto'] = 'mahasiswa/test-foto.jpg';
        $mahasiswa = Mahasiswa::create($data);

        // Simulasikan file foto ada
        Storage::disk('public')->put($data['foto'], 'fake content');

        $response = $this->actingAs($admin)->delete("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('mahasiswas', ['id' => $mahasiswa->id]);

        // Foto juga harus terhapus
        Storage::disk('public')->assertMissing($data['foto']);
    }

    public function test_hapus_data_mahasiswa_gagal_tanpa_autentikasi(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $response = $this->delete("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('mahasiswas', ['id' => $mahasiswa->id]);
    }

    public function test_hapus_data_mahasiswa_gagal_dengan_user_bukan_admin(): void
    {
        $user = $this->createRegularUser();
        $mahasiswa = Mahasiswa::factory()->create();

        $response = $this->actingAs($user)->delete("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('mahasiswas', ['id' => $mahasiswa->id]);
    }

    // ==================== INTEGRATION TEST (CRUD Lengkap) ====================

    public function test_crud_lengkap_mahasiswa(): void
    {
        $admin = $this->createAdminUser();
        $data = $this->getValidMahasiswaData();

        // CREATE
        $createResponse = $this->actingAs($admin)->post('/admin/mahasiswa', $data);
        $createResponse->assertStatus(302);
        $this->assertDatabaseCount('mahasiswas', 1);

        $mahasiswa = Mahasiswa::where('nim', $data['nim'])->first();
        $this->assertNotNull($mahasiswa);

        // READ
        $readResponse = $this->actingAs($admin)->get("/admin/mahasiswa/{$mahasiswa->id}");
        $readResponse->assertStatus(200);
        $readResponse->assertViewHas('mahasiswa');

        // UPDATE
        $updateData = array_merge($data, [
            'nama_lengkap' => 'Nama Diupdate',
            'jurusan' => 'Sistem Informasi'
        ]);
        $updateResponse = $this->actingAs($admin)->put("/admin/mahasiswa/{$mahasiswa->id}", $updateData);
        $updateResponse->assertStatus(302);
        $this->assertDatabaseHas('mahasiswas', [
            'id' => $mahasiswa->id,
            'nama_lengkap' => 'Nama Diupdate',
            'jurusan' => 'Sistem Informasi'
        ]);

        // DELETE
        $deleteResponse = $this->actingAs($admin)->delete("/admin/mahasiswa/{$mahasiswa->id}");
        $deleteResponse->assertStatus(302);
        $this->assertDatabaseCount('mahasiswas', 0);
    }
}

