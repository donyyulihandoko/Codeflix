<x-app-layout>
    <x-slot:title>Checkout - {{ $plan->title }} - Codeflix</x-slot>

    <div class="w-full min-h-screen px-4 py-16 text-gray-200 bg-zinc-950 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8">
                <a href="{{ route('subscriptions.index') }}"
                    class="inline-flex items-center space-x-2 text-xs font-bold transition text-zinc-500 hover:text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Change Plan</span>
                </a>
            </div>

            <div class="grid items-start grid-cols-1 gap-8 md:grid-cols-12">

                <!-- Plan Summary Card -->
                <div
                    class="p-6 space-y-6 border md:col-span-5 bg-zinc-900/30 border-zinc-900 rounded-2xl backdrop-blur-sm">
                    <div class="space-y-2">
                        <span
                            class="bg-red-600/10 text-red-500 border border-red-500/20 px-2 py-0.5 text-[10px] font-black uppercase tracking-widest rounded">
                            Selected Plan
                        </span>
                        <h2 class="text-xl font-black tracking-wider text-white uppercase">
                            {{ $plan->title }}
                        </h2>
                    </div>

                    <div class="pt-4 space-y-3 text-xs font-medium border-t border-zinc-800/60 text-zinc-400">
                        <div class="flex justify-between">
                            <span>Resolution:</span>
                            <span class="font-bold text-white uppercase">{{ $plan->resolution }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Simultaneous Screens:</span>
                            <span class="font-bold text-white">
                                {{ $plan->max_devices }} {{ $plan->max_devices > 1 ? 'Devices' : 'Device' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Duration:</span>
                            <span class="font-bold text-white">{{ $plan->duration }} Days</span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-1 border-t border-zinc-800/60">
                        <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">Total Price</span>
                        <div class="text-2xl font-black text-white">
                            {{ $plan->formatted_price ?? 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Checkout Form & Payment Trigger -->
                <div
                    class="p-6 space-y-6 border shadow-2xl md:col-span-7 bg-zinc-900/50 border-zinc-900 sm:p-8 rounded-2xl shadow-black">
                    <div class="space-y-1">
                        <h3 class="flex items-center gap-2 text-lg font-black tracking-wide text-white uppercase">
                            <i class="text-sm text-red-500 fa-solid fa-shield-halved"></i> Secure Checkout
                        </h3>
                        <p class="text-xs text-zinc-500">Please review your account details before proceeding to
                            payment.</p>
                    </div>

                    <form>
                        @csrf
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase tracking-widest text-zinc-400 block">
                                Subscriber Name
                            </label>
                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                class="w-full p-3 text-xs border cursor-not-allowed select-none bg-zinc-950 border-zinc-900 text-zinc-400 rounded-xl focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase tracking-widest text-zinc-400 block">
                                Email Address
                            </label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                class="w-full p-3 text-xs border cursor-not-allowed select-none bg-zinc-950 border-zinc-900 text-zinc-400 rounded-xl focus:outline-none">
                        </div>

                        <div
                            class="bg-zinc-950 border border-zinc-900 p-3.5 rounded-xl flex items-start space-x-3 text-[11px] text-zinc-500 leading-relaxed">
                            <i class="mt-0.5 fa-solid fa-lock text-zinc-600"></i>
                            <span>Your subscription will automatically activate instantly after successful payment
                                confirmation.</span>
                        </div>

                        <button type="button" id="pay-button"
                            class="block w-full px-4 py-4 mt-6 text-xs font-black tracking-widest text-center text-white uppercase transition duration-200 bg-red-600 shadow-lg hover:bg-red-700 rounded-xl shadow-red-950/40">
                            Proceed to Payment
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            const payButton = document.querySelector('#pay-button');
            payButton.addEventListener('click', function(event) {
                event.preventDefault();
                fetch('{{ route('payments.purchase', $plan) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        // body: JSON.stringify({
                        //     plan_id: '{{ $plan->id }}',
                        //     amount: '{{ $plan->price }}'
                        // })
                    })
                    // .then(alert('success'))
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            window.snap.pay(data.midtrans_snap_token, {
                                onSuccess: function(result) {
                                    window.location.href = '{{ route('subscriptions.success') }}';
                                },
                                onPending: function(result) {
                                    window.location.href = '/payment/pending';
                                },
                                onError: function(result) {
                                    window.location.href = '/payment/error';
                                },
                                onClose: function() {
                                    alert(
                                        'You closed the payment window without completing the payment'
                                    );
                                }
                            })
                        } else {
                            alert('Failed to initiate payment. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing your payment. Please try again.');
                    });
            });
        </script>
    @endpush

</x-app-layout>
