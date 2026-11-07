<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TiketWahana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TiketWahanaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $tiketWahanas = TiketWahana::query()
            ->orderByDesc('id_tiket_wahana')
            ->get();

        return view(
            'admin.tiket-wahana.index',
            compact('tiketWahanas')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.tiket-wahana.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = auth('admin')->user();

        if (!$user) {
            return redirect()
                ->route('admin.tiket-wahana.create')
                ->with(
                    'error',
                    'Sesi admin tidak ditemukan. Silakan login kembali.'
                );
        }

        $harga = preg_replace(
            '/\D/',
            '',
            (string) $request->input('harga')
        );

        $request->merge([
            'harga' => $harga,
        ]);

        $validated = $request->validate([
            'nama_wahana' => [
                'required',
                'string',
                'max:255',
            ],

            'harga' => [
                'required',
                'integer',
                'min:2000',
                'max:50000',
            ],

            'status' => [
                'required',
                'in:Tersedia,Tidak Tersedia',
            ],

            'ketentuan' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $validated['id_user'] = $user->id_user;

        $gambarBaru = null;

        if ($request->hasFile('gambar')) {
            $gambarBaru = $request
                ->file('gambar')
                ->store(
                    'tiket-wahana',
                    'public'
                );

            $validated['gambar'] = $gambarBaru;
        }

        try {
            TiketWahana::create($validated);
        } catch (Throwable $e) {
            if ($gambarBaru) {
                Storage::disk('public')->delete($gambarBaru);
            }

            report($e);

            throw $e;
        }

        return redirect()
            ->route('admin.tiket-wahana.index')
            ->with(
                'success',
                'Tiket wahana berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $tiketWahana = TiketWahana::query()
            ->where(
                'id_tiket_wahana',
                $id
            )
            ->firstOrFail();

        return view(
            'admin.tiket-wahana.edit',
            compact('tiketWahana')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        $tiketWahana = TiketWahana::query()
            ->where(
                'id_tiket_wahana',
                $id
            )
            ->firstOrFail();

        $harga = preg_replace(
            '/\D/',
            '',
            (string) $request->input('harga')
        );

        $request->merge([
            'harga' => $harga,
        ]);

        $validated = $request->validate([
            'nama_wahana' => [
                'required',
                'string',
                'max:255',
            ],

            'harga' => [
                'required',
                'integer',
                'min:2000',
                'max:50000',
            ],

            'status' => [
                'required',
                'in:Tersedia,Tidak Tersedia',
            ],

            'ketentuan' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $gambarLama = $tiketWahana->gambar;
        $gambarBaru = null;

        if ($request->hasFile('gambar')) {
            $gambarBaru = $request
                ->file('gambar')
                ->store(
                    'tiket-wahana',
                    'public'
                );

            $validated['gambar'] = $gambarBaru;
        }

        try {
            DB::transaction(function () use (
                $tiketWahana,
                $validated
            ) {
                $tiketWahana->update($validated);
            });
        } catch (Throwable $e) {
            if ($gambarBaru) {
                Storage::disk('public')->delete($gambarBaru);
            }

            report($e);

            throw $e;
        }

        if (
            $gambarBaru &&
            $gambarLama &&
            $gambarLama !== $gambarBaru
        ) {
            Storage::disk('public')->delete($gambarLama);
        }

        return redirect()
            ->route('admin.tiket-wahana.index')
            ->with(
                'success',
                'Tiket wahana berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    |
    | HAPUS SAMPAI KE AKAR
    |
    | Tidak hanya menghapus tiket_wahanas.
    |
    | Semua record anak yang mempunyai foreign key menuju tiket tersebut
    | akan dihapus terlebih dahulu secara rekursif.
    |
    | Contoh:
    |
    | tiket_wahanas
    |      ↓
    | detail_pesanans
    |
    | tiket_wahanas
    |      ↓
    | paket_bundling_wahanas
    |
    | Jika di kemudian hari ada tabel anak baru yang memiliki FK ke
    | tiket_wahanas, sistem juga akan menemukannya melalui
    | information_schema tanpa perlu menambahkan nama tabel secara manual.
    |
    */

    public function destroy($id)
    {
        $tiketWahana = TiketWahana::query()
            ->where(
                'id_tiket_wahana',
                $id
            )
            ->firstOrFail();

        $tiketId = (int) $tiketWahana->id_tiket_wahana;
        $gambar = $tiketWahana->gambar;

        try {
            DB::transaction(function () use ($tiketId) {

                /*
                |--------------------------------------------------------------------------
                | HAPUS SEMUA CHILD RECORD
                |--------------------------------------------------------------------------
                |
                | Foreign key checks tetap aktif.
                | Child dihapus lebih dahulu, baru parent.
                |
                */

                $this->deleteChildrenRecursively(
                    'tiket_wahanas',
                    'id_tiket_wahana',
                    $tiketId
                );


                /*
                |--------------------------------------------------------------------------
                | HAPUS TIKET UTAMA
                |--------------------------------------------------------------------------
                */

                DB::table('tiket_wahanas')
                    ->where(
                        'id_tiket_wahana',
                        $tiketId
                    )
                    ->delete();
            });


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR
            |--------------------------------------------------------------------------
            */

            if (
                $gambar &&
                Storage::disk('public')->exists($gambar)
            ) {
                Storage::disk('public')->delete($gambar);
            }


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('admin.tiket-wahana.index')
                ->with(
                    'success',
                    'Tiket wahana dan seluruh data turunannya berhasil dihapus sampai ke akar.'
                );

        } catch (Throwable $e) {

            report($e);

            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN ERROR ASLI
            |--------------------------------------------------------------------------
            |
            | Jangan lagi menampilkan pesan lama "sudah digunakan pada pesanan".
            | Jika database masih mempunyai relasi yang belum bisa dihapus,
            | pesan error asli akan membantu mengetahui tabel mana yang
            | menyebabkan masalah.
            |
            */

            $message = $e->getMessage();

            if (
                app()->environment('local') &&
                !empty($message)
            ) {
                $errorMessage =
                    'Penghapusan gagal: ' .
                    $message;
            } else {
                $errorMessage =
                    'Tiket wahana belum dapat dihapus. Database membatalkan proses penghapusan. Periksa storage/logs/laravel.log untuk detail.';
            }

            return redirect()
                ->route('admin.tiket-wahana.index')
                ->with(
                    'error',
                    $errorMessage
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE CHILDREN RECURSIVELY
    |--------------------------------------------------------------------------
    |
    | Mencari seluruh foreign key yang menunjuk ke tabel parent.
    |
    | Contoh otomatis:
    |
    | tiket_wahanas
    |       ↓
    | detail_pesanans
    |
    | lalu apabila detail_pesanans ternyata mempunyai child:
    |
    | tiket_wahanas
    |       ↓
    | detail_pesanans
    |       ↓
    | tabel_lain
    |
    | maka tabel_lain dihapus terlebih dahulu.
    |
    */

    private function deleteChildrenRecursively(
        string $parentTable,
        string $parentColumn,
        int|string $parentValue,
        array &$visited = []
    ): void {
        $connection = DB::connection();
        $databaseName = $connection->getDatabaseName();

        $relations = $connection->select(
            "
            SELECT
                TABLE_NAME,
                COLUMN_NAME,
                CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE
                CONSTRAINT_SCHEMA = ?
                AND REFERENCED_TABLE_SCHEMA = ?
                AND REFERENCED_TABLE_NAME = ?
                AND REFERENCED_COLUMN_NAME = ?
            ",
            [
                $databaseName,
                $databaseName,
                $parentTable,
                $parentColumn,
            ]
        );


        foreach ($relations as $relation) {

            $childTable = $relation->TABLE_NAME;
            $childColumn = $relation->COLUMN_NAME;

            /*
            |--------------------------------------------------------------------------
            | CEGAH LOOP
            |--------------------------------------------------------------------------
            */

            $visitKey =
                $childTable .
                '.' .
                $childColumn .
                '=' .
                (string) $parentValue;

            if (isset($visited[$visitKey])) {
                continue;
            }

            $visited[$visitKey] = true;


            /*
            |--------------------------------------------------------------------------
            | AMBIL ID CHILD
            |--------------------------------------------------------------------------
            */

            $childRows = DB::table($childTable)
                ->where(
                    $childColumn,
                    $parentValue
                )
                ->get();


            if ($childRows->isEmpty()) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TELUSURI TURUNAN CHILD
            |--------------------------------------------------------------------------
            |
            | Cari primary key child supaya child tersebut bisa dijadikan
            | parent pada level berikutnya.
            |
            */

            $primaryKey = $this->getPrimaryKeyColumn(
                $childTable
            );


            if ($primaryKey) {

                foreach ($childRows as $childRow) {

                    if (
                        !isset(
                            $childRow->{$primaryKey}
                        )
                    ) {
                        continue;
                    }

                    $this->deleteChildrenRecursively(
                        $childTable,
                        $primaryKey,
                        $childRow->{$primaryKey},
                        $visited
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS CHILD
            |--------------------------------------------------------------------------
            */

            DB::table($childTable)
                ->where(
                    $childColumn,
                    $parentValue
                )
                ->delete();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GET PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    private function getPrimaryKeyColumn(
        string $table
    ): ?string {
        $connection = DB::connection();
        $databaseName = $connection->getDatabaseName();

        $primaryKey = $connection->selectOne(
            "
            SELECT
                COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE
                CONSTRAINT_SCHEMA = ?
                AND TABLE_SCHEMA = ?
                AND TABLE_NAME = ?
                AND CONSTRAINT_NAME = 'PRIMARY'
            ORDER BY ORDINAL_POSITION ASC
            LIMIT 1
            ",
            [
                $databaseName,
                $databaseName,
                $table,
            ]
        );

        return $primaryKey
            ? $primaryKey->COLUMN_NAME
            : null;
    }
}
