<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#18181b',
        color: '#ffffff',
        customClass: {
            popup: 'border border-zinc-800 shadow-2xl rounded-2xl font-sans'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Flash Alert Sukses
    @if (session('success'))
        Toast.fire({
            icon: 'success',
            iconColor: '#22c55e',
            title: "{{ session('success') }}"
        });
    @endif

    // Flash Alert Error
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            iconColor: '#f43f5e',
            title: '<span class="text-white font-extrabold text-xl tracking-tight">Terjadi Kesalahan!</span>',
            html: '<span class="text-zinc-400 text-sm">{{ session('error') }}</span>',
            background: '#18181b',
            color: '#ffffff',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#e11d48',
            customClass: {
                popup: 'border border-zinc-800/80 rounded-2xl p-6 shadow-2xl backdrop-blur-md',
                confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider active:scale-95'
            }
        });
    @endif
</script>
