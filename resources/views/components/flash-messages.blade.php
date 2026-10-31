{{-- Flash message sukses/error + ringkasan error validasi (style inline agar tampil tanpa build Tailwind) --}}
@if (session('success'))
    <div role="alert" style="background:#dcfce7;border:1px solid #4ade80;color:#166534;padding:12px 16px;border-radius:6px;margin-bottom:16px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div role="alert" style="background:#fee2e2;border:1px solid #f87171;color:#991b1b;padding:12px 16px;border-radius:6px;margin-bottom:16px;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div role="alert" style="background:#fee2e2;border:1px solid #f87171;color:#991b1b;padding:12px 16px;border-radius:6px;margin-bottom:16px;">
        <ul style="list-style:disc;padding-left:20px;margin:0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

