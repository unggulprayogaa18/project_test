<?php

namespace App\Http\Controllers\Guru;

use App\Constants\Role;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatOrtuController extends Controller
{
    /**
     * Menampilkan daftar percakapan yang dimiliki oleh guru.
     */ public function index()
    {
        $guru = Auth::user();

        // Ambil semua percakapan di mana guru adalah salah satu pesertanya
        $conversations = Conversation::where('participant_one_id', $guru->id)
            ->orWhere('participant_two_id', $guru->id)
            // PERBAIKAN: Eager load data anak untuk menghindari N+1 query
            ->with(['participantOne.anak', 'participantTwo.anak', 'messages']) 
            ->get();

        return view('guru.chat.index', compact('conversations', 'guru'));
    }

    /**
     * Menampilkan halaman percakapan spesifik dengan seorang orang tua.
     */
    public function show(User $orangtua)
    {
        $guru = Auth::user();

        // Pastikan user yang dituju adalah orang tua
        if ($orangtua->role !== Role::ORANG_TUA) {
            abort(404, 'Pengguna tidak ditemukan.');
        }

        // Cari percakapan yang sudah ada
        $conversation = Conversation::where(function ($query) use ($guru, $orangtua) {
            $query->where('participant_one_id', $guru->id)
                  ->where('participant_two_id', $orangtua->id);
        })->orWhere(function ($query) use ($guru, $orangtua) {
            $query->where('participant_one_id', $orangtua->id)
                  ->where('participant_two_id', $guru->id);
        })->first();

        // Jika belum ada, buat percakapan baru
        if (!$conversation) {
            $conversation = Conversation::create([
                'participant_one_id' => $guru->id,
                'participant_two_id' => $orangtua->id,
            ]);
        }

        // Ambil semua pesan dari percakapan ini
        $messages = $conversation->messages()->latest()->get();

        return view('guru.chat.show', compact('orangtua', 'conversation', 'messages'));
    }
 public function markAllRead()
    {
        $guru = Auth::user();
        
        $conversationIds = Conversation::where('participant_one_id', $guru->id)
            ->orWhere('participant_two_id', $guru->id)
            ->pluck('id');

        Message::whereIn('conversation_id', $conversationIds)
            ->where('user_id', '!=', $guru->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['status' => 'success']);
    }
    /**
     * Menyimpan pesan baru dari guru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'body' => 'required|string',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        
        // Otorisasi: pastikan guru adalah bagian dari percakapan
        if ($conversation->participant_one_id != Auth::id() && $conversation->participant_two_id != Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back();
    }
}
