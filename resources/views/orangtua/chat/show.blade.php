<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi dengan {{ $guru->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .chat-container { max-width: 800px; margin: auto; }
        .chat-box { height: 70vh; overflow-y: auto; display: flex; flex-direction: column-reverse; }
        .message { max-width: 70%; padding: 10px 15px; margin-bottom: 10px; border-radius: 20px; word-wrap: break-word; }
        .message.sent { background-color: #0084ff; color: white; align-self: flex-end; border-bottom-right-radius: 5px; }
        .message.received { background-color: #e4e6eb; color: #050505; align-self: flex-start; border-bottom-left-radius: 5px; }
        .message-time { font-size: 0.75rem; color: #65676b; margin-top: 5px; }
    </style>
</head>
<body>
    <main class="container py-4">
        <div class="card chat-container">
            <div class="card-header d-flex align-items-center">
                <a href="{{ route('orangtua.chat.index') }}" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
                <h5 class="mb-0">Konsultasi dengan {{ $guru->nama }}</h5>
            </div>
            <div class="card-body chat-box p-3" id="chatBox">
                {{-- Pesan akan ditampilkan di sini, dari yang terbaru --}}
                @forelse($messages as $message)
                    @if($message->user_id == Auth::id())
                        {{-- Pesan yang dikirim oleh orang tua (sent) --}}
                        <div class="message sent">
                            <div>{{ $message->body }}</div>
                            <div class="text-end message-time">{{ $message->created_at->format('H:i') }}</div>
                        </div>
                    @else
                        {{-- Pesan yang diterima dari guru (received) --}}
                        <div class="message received">
                            <div>{{ $message->body }}</div>
                            <div class="text-start message-time">{{ $message->created_at->format('H:i') }}</div>
                        </div>
                    @endif
                @empty
                    <p class="text-center text-muted">Mulai percakapan dengan mengirim pesan pertama Anda.</p>
                @endforelse
            </div>
            <div class="card-footer">
                <form action="{{ route('orangtua.chat.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="input-group">
                        <input type="text" name="body" class="form-control" placeholder="Ketik pesan Anda..." required autocomplete="off">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-send-fill"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
