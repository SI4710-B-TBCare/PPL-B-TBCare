<x-app-layout>
    <x-slot name="title">ChatBot TBC — TBCare</x-slot>

    <section class="row justify-content-center">
        <div class="col-md-8">

            {{-- Kartu konteks prediksi (hanya muncul jika ada prediksi yang dipilih) --}}
            @if($prediction)
            <div class="alert alert-info d-flex align-items-start mb-3" role="alert">
                <i class="fas fa-info-circle mr-2 mt-1"></i>
                <div>
                    <strong>Konteks Prediksi Aktif</strong><br>
                    Risiko: <span class="font-weight-bold">{{ $prediction->risk_level }}</span>
                    ({{ $prediction->risk_percentage }}%) —
                    {{ $prediction->created_at->format('d M Y, H:i') }}<br>
                    <small class="text-muted">AI akan menjawab berdasarkan data prediksi ini.</small>
                </div>
            </div>
            @endif

            <div class="card shadow">
                {{-- Header --}}
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-robot mr-2"></i>
                        <strong>TBCare ChatBot</strong>
                        <small class="ml-2 opacity-75">Asisten Kesehatan TBC</small>
                    </div>
                    <button
                        id="btn-reset"
                        class="btn btn-sm btn-outline-light"
                        title="Hapus semua riwayat chat ini"
                        onclick="resetChat()">
                        <i class="fas fa-trash-alt mr-1"></i> Reset Chat
                    </button>
                </div>

                {{-- Area Chat --}}
                <div class="card-body p-0">
                    <div id="chat-box"
                         style="height:420px; overflow-y:auto; padding:1rem; background:#f8f9fc;">

                        {{-- Pesan sambutan jika belum ada history --}}
                        @if($messages->isEmpty())
                        <div class="text-center text-muted my-4" id="welcome-msg">
                            <i class="fas fa-robot fa-2x mb-2 text-primary"></i>
                            <p class="mb-0">
                                Halo! Saya <strong>TBCare AI</strong>.<br>
                                Tanyakan apa saja seputar Tuberkulosis (TBC) kepada saya.
                            </p>
                        </div>
                        @endif

                        {{-- Render history dari DB --}}
                        @foreach($messages as $msg)
                            @if($msg->role === 'user')
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="chat-bubble-user px-3 py-2 rounded"
                                         style="max-width:75%; background:#4e73df; color:#fff; border-radius:18px 18px 4px 18px;">
                                        {!! nl2br(e($msg->content)) !!}
                                        <div class="text-right mt-1">
                                            <small style="opacity:0.75; font-size:0.7rem;">
                                                {{ $msg->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="mr-2 mt-1">
                                        <span class="badge badge-primary rounded-circle p-2">
                                            <i class="fas fa-robot"></i>
                                        </span>
                                    </div>
                                    <div class="chat-bubble-ai px-3 py-2 rounded"
                                         style="max-width:75%; background:#fff; border:1px solid #e3e6f0; border-radius:4px 18px 18px 18px;">
                                        {!! nl2br(e($msg->content)) !!}
                                        <div class="text-right mt-1">
                                            <small class="text-muted" style="font-size:0.7rem;">
                                                {{ $msg->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        {{-- Loading indicator (tersembunyi secara default) --}}
                        <div id="loading-indicator" class="d-none d-flex justify-content-start mb-3">
                            <div class="mr-2 mt-1">
                                <span class="badge badge-primary rounded-circle p-2">
                                    <i class="fas fa-robot"></i>
                                </span>
                            </div>
                            <div class="px-3 py-2 rounded"
                                 style="background:#fff; border:1px solid #e3e6f0; border-radius:4px 18px 18px 18px;">
                                <i class="fas fa-circle-notch fa-spin text-primary mr-1"></i>
                                <small class="text-muted">TBCare AI sedang mengetik...</small>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Input Area --}}
                <div class="card-footer bg-white p-2">
                    <form id="chat-form" class="d-flex" onsubmit="sendMessage(event)">
                        @csrf
                        <input type="hidden" id="prediction-id" value="{{ $predictionId }}">
                        <input
                            type="text"
                            id="user-input"
                            class="form-control mr-2"
                            placeholder="Ketik pertanyaan Anda seputar TBC..."
                            autocomplete="off"
                            maxlength="1000"
                            required>
                        <button type="submit" id="btn-send" class="btn btn-primary px-3">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Link kembali --}}
            <div class="mt-2 text-center">
                <a href="{{ route('users.prediksi.index') }}" class="btn btn-sm btn-link text-muted">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Riwayat Prediksi
                </a>
            </div>

        </div>
    </section>

    {{-- JavaScript --}}
    <script>
    // Scroll ke bawah saat halaman load
    (function() {
        var box = document.getElementById('chat-box');
        box.scrollTop = box.scrollHeight;
    })();

    var sendUrl  = "{{ route('users.chatbot.send') }}";
    var resetUrl = "{{ route('users.chatbot.reset') }}";
    var csrfToken = document.querySelector('input[name="_token"]').value;

    function appendBubble(role, text) {
        var box = document.getElementById('chat-box');

        // Hapus pesan sambutan jika masih ada
        var welcome = document.getElementById('welcome-msg');
        if (welcome) welcome.remove();

        var wrapper = document.createElement('div');
        wrapper.className = 'd-flex mb-3 ' + (role === 'user' ? 'justify-content-end' : 'justify-content-start');

        var now = new Date();
        var timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');

        // Konversi newline ke <br>
        var safeText = text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');

        if (role === 'user') {
            wrapper.innerHTML =
                '<div class="px-3 py-2 rounded" style="max-width:75%;background:#4e73df;color:#fff;border-radius:18px 18px 4px 18px;">'
                + safeText
                + '<div class="text-right mt-1"><small style="opacity:0.75;font-size:0.7rem;">' + timeStr + '</small></div>'
                + '</div>';
        } else {
            wrapper.innerHTML =
                '<div class="mr-2 mt-1"><span class="badge badge-primary rounded-circle p-2"><i class="fas fa-robot"></i></span></div>'
                + '<div class="px-3 py-2 rounded" style="max-width:75%;background:#fff;border:1px solid #e3e6f0;border-radius:4px 18px 18px 18px;">'
                + safeText
                + '<div class="text-right mt-1"><small class="text-muted" style="font-size:0.7rem;">' + timeStr + '</small></div>'
                + '</div>';
        }

        box.insertBefore(wrapper, document.getElementById('loading-indicator'));
        box.scrollTop = box.scrollHeight;
    }

    function sendMessage(event) {
        event.preventDefault();

        var input       = document.getElementById('user-input');
        var btnSend     = document.getElementById('btn-send');
        var loading     = document.getElementById('loading-indicator');
        var predId      = document.getElementById('prediction-id').value;
        var message     = input.value.trim();

        if (!message) return;

        // Tampilkan bubble user
        appendBubble('user', message);
        input.value = '';

        // Nonaktifkan input & tampilkan loading
        input.disabled = true;
        btnSend.disabled = true;
        loading.classList.remove('d-none');
        document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;

        // Kirim AJAX
        fetch(sendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                message: message,
                prediction_id: predId || null,
            }),
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            loading.classList.add('d-none');
            input.disabled = false;
            btnSend.disabled = false;
            input.focus();

            if (data.error) {
                appendBubble('model', '⚠️ ' + data.error);
            } else {
                appendBubble('model', data.reply);
            }
        })
        .catch(function(err) {
            loading.classList.add('d-none');
            input.disabled = false;
            btnSend.disabled = false;
            appendBubble('model', '⚠️ Terjadi kesalahan jaringan. Silakan coba lagi.');
        });
    }

    function resetChat() {
        if (!confirm('Hapus semua riwayat percakapan ini?')) return;

        var predId = document.getElementById('prediction-id').value;

        fetch(resetUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ prediction_id: predId || null }),
        })
        .then(function() { location.reload(); })
        .catch(function() { alert('Gagal mereset chat.'); });
    }
    </script>

</x-app-layout>
