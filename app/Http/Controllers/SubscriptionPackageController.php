<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageController extends Controller
{
    // Menangani daftar, pembuatan, perubahan, dan penghapusan paket langganan.
    /**
     * Display a listing of the resource.
     */
       public function index(Request $request)
    {
        //$request->ajax jika ada permintaan dari ajax js, permintaan proses datatbels dipanggil maemlalu ajax js di bladenya
       if ($request->ajax()){
        $model = SubscriptionPackage::query();

        return DataTables::eloquent($model)
        //memberi nomor urut 123
        ->addIndexColumn()
        //menambah data selain yang ada di databese : mengubah data atau untuk btn aksi
        ->editColumn('price', function ($data) {
            return 'Rp ' . number_format($data->price, 0, ',', '.');
        })

        ->addColumn('action', function($dataa){
            $editUrl = route('admin.subscription-packages.edit', $dataa->id);
            $deleteUrl = route('admin.subscription-packages.destroy', $dataa->id);
            $csrf = csrf_field();
            $method = method_field('DELETE');
            $btnEdit =  '<a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>';
            $btnDelete =  '<form action="'. $deleteUrl .'" method="POST"
                            class="d-inline">' . $csrf . $method . '<button type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm(\'Apakah anda yakin menghapus\')">Hapus</button>
                        </form>';

                        return $btnEdit . $btnDelete;
        })
        //menyimpan dari addcolumn yg ada html didalamnya
        ->rawColumns(['action'])
        ->toJson();
       }
        return view('admin.subscription-packages.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.subscription-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data paket sebelum membuat record baru.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required' , 'string'],
        ]);

        SubscriptionPackage::create($validated);
        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);
        return view('admin.subscription-packages.edit', compact('subscriptionPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        // Validasi seluruh kolom paket sebelum menyimpan perubahan.
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required' , 'string'],
        ]);
    //update digunakan untuk mengubah data, namun pengguananya harus setelah prosess pencarian data yang akan diubahnya
        $subscriptionPackage->update($validateData);
        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);
        $subscriptionPackage->delete();
        //delete digunakan pada model untuk menghapus data namun penggunanya harus setelah proses pencarian data yang akan diubahnya
        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil dihapus');
    }
}