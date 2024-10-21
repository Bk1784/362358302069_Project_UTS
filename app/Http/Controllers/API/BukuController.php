<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menampilkan semua buku dengan kategori terkait
    public function index()
    {
        return Buku::with('kategori')->get();
    }

    // Menambahkan buku baru dengan validasi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255', // Judul wajib diisi
            'penulis' => 'required|string|max:255', // Penulis wajib diisi
            'harga' => 'required|numeric|min:1000', // Harga minimal Rp 1.000
            'stok' => 'required|integer|min:1', // Stok minimal 1
            'kategori_id' => 'required|exists:kategoris,id', // ID kategori harus valid
        ]);

        // Menyimpan data buku baru
        $buku = Buku::create($request->all());
        return response()->json($buku, 201); // Mengembalikan data buku yang baru dibuat
    }

    // Endpoint pencarian buku berdasarkan kategori_id dan judul
    public function search(Request $request)
{
    \Log::info('Request parameters:', $request->all());

    $query = Buku::query();

    // Cek apakah kategori_id diterima dengan benar
    if ($request->has('kategori_id')) {
        \Log::info('Kategori ID: ' . $request->kategori_id); // Log kategori_id yang diterima
        $query->where('kategori_id', $request->kategori_id);
    }

    // Cek apakah judul ada dan ditambahkan ke query
    if ($request->has('judul')) {
        \Log::info('Judul: ' . $request->judul); // Log judul yang diterima
        $query->where('judul', 'like', '%' . $request->judul . '%');
    }

    $bukus = $query->with('kategori')->paginate(10);

    if ($bukus->isEmpty()) {
        \Log::info('Buku tidak ditemukan.');
    }

    return response()->json($bukus);
}


    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($buku);
    }

    // Mengupdate data buku dengan validasi
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255', // Judul wajib diisi
            'penulis' => 'required|string|max:255', // Penulis wajib diisi
            'harga' => 'required|numeric|min:1000', // Harga minimal Rp 1.000
            'stok' => 'required|integer|min:1', // Stok minimal 1
            'kategori_id' => 'required|exists:kategoris,id', // ID kategori harus valid
        ]);

        // Menemukan buku berdasarkan ID
        $buku = Buku::findOrFail($id);

        // Mengupdate data buku
        $buku->update($request->all());

        return response()->json($buku, 200); // Mengembalikan data buku yang diupdate
    }

    // Menghapus buku berdasarkan ID
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        // Menghapus buku
        Buku::destroy($id);
        return response()->json(null, 204); // Mengembalikan status sukses tanpa data
    }
}
