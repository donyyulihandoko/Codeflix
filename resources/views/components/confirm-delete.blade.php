<!-- Cukup pastikan Swal ter-load jika komponen ini dipasang terpisah -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.confirmDelete = function(formId, itemTitle = 'film ini') {
        Swal.fire({
            title: `<span class="text-white font-extrabold text-xl">Hapus dari Watchlist?</span>`,
            html: `<p class="text-zinc-400 text-sm"><strong>${itemTitle}</strong> akan dikeluarkan dari daftar tontonanmu.</p>`,
            icon: 'warning',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-trash mr-1.5"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#27272a',
            background: '#18181b',
            color: '#ffffff',
            reverseButtons: true,
            customClass: {
                popup: 'border border-zinc-800 rounded-2xl p-6 shadow-2xl',
                confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider active:scale-95 shadow-lg shadow-red-950/50',
                cancelButton: 'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-zinc-300 hover:text-white'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                }
            }
        });
    }
</script>
