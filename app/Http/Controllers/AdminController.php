<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna (User).
     * 
     * Method ini menggunakan Eloquent `with('roles')` (Eager Loading) 
     * untuk mencegah query berulang-ulang ke database saat menampilkan relasi.
     * `paginate(10)` digunakan untuk membagi hasil data menjadi 10 item per halaman (Paginasi).
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('dashboard.admin.users.index', compact('users'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
