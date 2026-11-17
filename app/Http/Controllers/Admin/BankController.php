<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBankRequest;
use App\Http\Requests\Admin\UpdateBankRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bank::withCount('products');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code_saham', 'like', "%{$search}%");
            });
        }

        $banks = $query->latest()->paginate(15)->withQueryString();

        return view('admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo_url')) {
            $path = $request->file('logo_url')->store('bank-logos', 'public');
            $validated['logo_url'] = $path;
        }

        Bank::create($validated);

        return redirect()->route('admin.banks.index')
            ->with('success', 'Bank berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo_url')) {
            // Hapus logo lama jika ada
            if ($bank->logo_url && Storage::disk('public')->exists($bank->logo_url)) {
                Storage::disk('public')->delete($bank->logo_url);
            }
            $path = $request->file('logo_url')->store('bank-logos', 'public');
            $validated['logo_url'] = $path;
        }

        $bank->update($validated);

        return redirect()->route('admin.banks.index')
            ->with('success', 'Data bank berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if ($bank->logo_url && Storage::disk('public')->exists($bank->logo_url)) {
            Storage::disk('public')->delete($bank->logo_url);
        }

        $bank->delete();

        return redirect()->route('admin.banks.index')
            ->with('success', 'Bank beserta data terkait berhasil dihapus!');
    }
}
