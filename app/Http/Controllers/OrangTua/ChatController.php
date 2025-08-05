<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constants\Role;

class ChatController extends Controller
{
    /**
     * Menampilkan daftar semua guru yang bisa dihubungi untuk konsultasi.
     */
    public function index()
    {
        // Ambil semua user dengan role 'guru' dan lakukan paginasi
        // Misalnya, 10 guru per halaman. Anda bisa sesuaikan angka ini.
        $guruList = User::where('role', Role::GURU)
                        ->orderBy('nama')
                        ->paginate(10); // <-- UBAH DI SINI

        return view('orangtua.chat.index', compact('guruList'));
    }

    /**
     * Menampilkan halaman percakapan spesifik dengan seorang guru.
     */
    public function show(User $guru)
    {
        $orangTua = Auth::user();

        // Cari percakapan yang sudah ada antara orang tua dan guru ini
        $conversation = Conversation::where(function ($query) use ($orangTua, $guru) {
            $query->where('participant_one_id', $orangTua->id)
                  ->where('participant_two_id', $guru->id);
        })->orWhere(function ($query) use ($orangTua, $guru) {
            $query->where('participant_one_id', $guru->id)
                  ->where('participant_two_id', $orangTua->id);
        })->first();

        // Jika belum ada percakapan, buat yang baru
        if (!$conversation) {
            $conversation = Conversation::create([
                'participant_one_id' => $orangTua->id,
                'participant_two_id' => $guru->id,
            ]);
        }

        // Ambil semua pesan dari percakapan ini
        $messages = $conversation->messages()->latest()->get();

        return view('orangtua.chat.show', compact('guru', 'conversation', 'messages'));
    }

    /**
     * Menyimpan pesan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'body' => 'required|string',
        ]);

        // Cek otorisasi, pastikan user yang mengirim pesan adalah bagian dari percakapan
        $conversation = Conversation::findOrFail($request->conversation_id);
        if ($conversation->participant_one_id != Auth::id() && $conversation->participant_two_id != Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengirim pesan di percakapan ini.');
        }

        Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => Auth::id(), // Pengirim pesan adalah user yang login
            'body' => $request->body,
        ]);

        return back(); // Kembali ke halaman chat sebelumnya
    }
}