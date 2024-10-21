<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index() {
        return Kategori::all();
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris|max:255'
        ]);

        return Kategori::create($request->all());
    }
}
