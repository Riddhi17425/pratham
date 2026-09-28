@if (session('toast_success') || session('toast_error') || session('toast_info'))
    @php
        $toastType = session('toast_success') ? 'success' : (session('toast_error') ? 'danger' : 'info');
        $toastMessage = session('toast_success') ?? session('toast_error') ?? session('toast_info');
    @endphp
    <div id="app-toast" class="alert alert-{{ $toastType }} shadow d-flex align-items-center gap-2"
         style="position:fixed;top:20px;right:20px;z-index:9999;min-width:280px;max-width:380px;">
        <span class="flex-fill">{{ $toastMessage }}</span>
        <button type="button" class="btn-close" onclick="document.getElementById('app-toast').remove()"></button>
    </div>
    <script>setTimeout(() => document.getElementById('app-toast')?.remove(), 4000);</script>
@endif
