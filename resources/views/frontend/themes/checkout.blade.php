<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<title>Purchase {{ $theme->name }} - NewsHub</title>

<script src="https://cdn.tailwindcss.com"></script>
```

</head>

<body class="bg-slate-50 text-slate-900">

<div class="min-h-screen flex items-center justify-center px-4 py-10">

```
<div class="w-full max-w-lg">

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

        {{-- Header --}}
        <div class="bg-slate-950 text-white p-6">

            <p class="text-xs uppercase tracking-widest text-slate-400 font-bold">
                NewsHub Theme Store
            </p>

            <h1 class="mt-2 text-2xl font-black">
                Complete Your Purchase
            </h1>

            @if(!isset($razorpayOrder))

                <p class="mt-2 text-sm text-slate-400">
                    Enter your details before proceeding to payment.
                </p>

            @else

                <p class="mt-2 text-sm text-slate-400">
                    Your order is ready. Complete the secure payment.
                </p>

            @endif

        </div>


        {{-- Content --}}
        <div class="p-6">

            {{-- Theme --}}
            <div class="flex gap-4 items-center">

                @if($theme->preview_image)

                    <img
                        src="{{ asset('storage/' . $theme->preview_image) }}"
                        alt="{{ $theme->name }}"
                        class="w-28 h-20 object-cover rounded-xl border"
                    >

                @else

                    <div class="w-28 h-20 rounded-xl bg-slate-100
                                flex items-center justify-center">
                        🎨
                    </div>

                @endif


                <div>

                    <h2 class="text-xl font-black">
                        {{ $theme->name }}
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Premium News Website Theme
                    </p>

                </div>

            </div>


            {{-- Price --}}
            <div class="mt-8 p-5 rounded-xl bg-slate-50 border border-slate-200">

                <div class="flex items-center justify-between">

                    <span class="text-sm font-bold text-slate-500">
                        Theme Price
                    </span>

                    <span class="text-3xl font-black">
                        ₹{{ number_format($theme->price, 2) }}
                    </span>

                </div>

            </div>


            {{-- Website --}}
            <div class="mt-5">

                <p class="text-xs uppercase tracking-wider
                          text-slate-400 font-bold">
                    Website
                </p>

                <p class="mt-1 font-bold">
                    {{ $website->name }}
                </p>

            </div>


            {{-- Validation Errors --}}
            @if($errors->any())

                <div class="mt-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <p class="font-bold text-red-700 text-sm">
                        Please correct the following:
                    </p>

                    <ul class="mt-2 text-sm text-red-600 list-disc list-inside">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Session Error --}}
            @if(session('error'))

                <div class="mt-6 rounded-xl bg-red-50 border border-red-200 p-4">

                    <p class="text-sm font-semibold text-red-700">
                        {{ session('error') }}
                    </p>

                </div>

            @endif


            @if(!isset($razorpayOrder))

                {{-- ================================= --}}
                {{-- CUSTOMER DETAILS FORM              --}}
                {{-- ================================= --}}

                <form
                    method="POST"
                    action="{{ route('frontend.themes.start-payment', [
                        'websiteSlug' => $website->slug,
                        'themeId' => $theme->id
                    ]) }}"
                    class="mt-7"
                >

                    @csrf


                    {{-- Name --}}
                    <div>

                        <label
                            for="name"
                            class="block text-sm font-bold text-slate-700"
                        >
                            Full Name
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            placeholder="Enter your full name"
                            class="mt-2 w-full rounded-xl border border-slate-300
                                   px-4 py-3 outline-none
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100"
                        >

                    </div>


                    {{-- Email --}}
                    <div class="mt-5">

                        <label
                            for="email"
                            class="block text-sm font-bold text-slate-700"
                        >
                            Gmail / Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="example@gmail.com"
                            class="mt-2 w-full rounded-xl border border-slate-300
                                   px-4 py-3 outline-none
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100"
                        >

                    </div>


                    {{-- Mobile --}}
                    <div class="mt-5">

                        <label
                            for="mobile"
                            class="block text-sm font-bold text-slate-700"
                        >
                            Mobile Number
                        </label>

                        <input
                            id="mobile"
                            type="tel"
                            name="mobile"
                            value="{{ old('mobile') }}"
                            required
                            autocomplete="tel"
                            maxlength="20"
                            placeholder="Enter your mobile number"
                            class="mt-2 w-full rounded-xl border border-slate-300
                                   px-4 py-3 outline-none
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100"
                        >

                    </div>


                    {{-- Password --}}
                    <div class="mt-5">

                        <label
                            for="password"
                            class="block text-sm font-bold text-slate-700"
                        >
                            Password
                        </label>

                        <div class="relative mt-2">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                                placeholder="Minimum 8 characters"
                                class="w-full rounded-xl border border-slate-300
                                       px-4 py-3 pr-12 outline-none
                                       focus:border-blue-500 focus:ring-2
                                       focus:ring-blue-100"
                            >

                            {{-- Show / Hide Password --}}
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0
                                       px-4 flex items-center
                                       text-slate-500
                                       hover:text-slate-800
                                       cursor-pointer"
                                aria-label="Show password"
                            >
                                👁️
                            </button>

                        </div>

                        <p class="mt-2 text-xs text-slate-400">
                            Minimum 8 characters.
                        </p>

                    </div>


                    {{-- Continue Payment --}}
                    <button
                        type="submit"
                        class="mt-8 w-full py-3.5 rounded-xl
                               bg-blue-600 hover:bg-blue-700
                               text-white font-black transition
                               shadow-lg shadow-blue-100"
                    >

                        Continue to Payment

                        <span class="ml-1">
                            ₹{{ number_format($theme->price, 2) }}
                        </span>

                    </button>

                </form>


                <p class="mt-4 text-center text-xs text-slate-400">
                    🔒 Your information is securely processed.
                </p>


            @else

                {{-- ================================= --}}
                {{-- RAZORPAY PAYMENT STATE             --}}
                {{-- ================================= --}}

                <div class="mt-7 rounded-xl bg-green-50
                            border border-green-200 p-5 text-center">

                    <div class="text-3xl">
                        🔒
                    </div>

                    <h3 class="mt-2 font-black text-green-800">
                        Order Ready
                    </h3>

                    <p class="mt-1 text-sm text-green-700">
                        Click below if the payment window does not open automatically.
                    </p>

                </div>


                <button
                    id="pay-button"
                    type="button"
                    class="mt-6 w-full py-3.5 rounded-xl
                           bg-blue-600 hover:bg-blue-700
                           text-white font-black transition
                           shadow-lg shadow-blue-100"
                >
                    Pay ₹{{ number_format($theme->price, 2) }}
                </button>


                <p class="mt-4 text-center text-xs text-slate-400">
                    🔒 Secure payment powered by Razorpay
                </p>

            @endif

        </div>

    </div>

</div>
```

</div>

{{-- ========================================= --}}
{{-- RAZORPAY SCRIPT                          --}}
{{-- ========================================= --}}

@if(isset($razorpayOrder))

```
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

    function openRazorpay() {

        const options = {

            key: "{{ config('services.razorpay.key') }}",

            amount: "{{ $razorpayOrder['amount'] }}",

            currency: "INR",

            name: "NewsHub",

            description: "{{ $theme->name }}",

            order_id: "{{ $razorpayOrder['id'] }}",

            handler: function (response) {

                const form = document.createElement('form');

                form.method = 'POST';

                form.action =
                    "{{ route('frontend.themes.payment.success') }}";


                // CSRF
                const csrf = document.createElement('input');

                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";

                form.appendChild(csrf);


                // Payment ID
                const paymentId = document.createElement('input');

                paymentId.type = 'hidden';
                paymentId.name = 'razorpay_payment_id';
                paymentId.value =
                    response.razorpay_payment_id;

                form.appendChild(paymentId);


                // Order ID
                const orderId = document.createElement('input');

                orderId.type = 'hidden';
                orderId.name = 'razorpay_order_id';
                orderId.value =
                    response.razorpay_order_id;

                form.appendChild(orderId);


                // Signature
                const signature = document.createElement('input');

                signature.type = 'hidden';
                signature.name = 'razorpay_signature';
                signature.value =
                    response.razorpay_signature;

                form.appendChild(signature);


                document.body.appendChild(form);

                form.submit();

            },


            prefill: {

                name: "{{ session('theme_customer.name', '') }}",

                email: "{{ session('theme_customer.email', '') }}"

            },


            theme: {

                color: "#2563eb"

            }

        };


        const razorpay = new Razorpay(options);

        razorpay.open();

    }


    document.addEventListener('DOMContentLoaded', function () {

        const payButton =
            document.getElementById('pay-button');


        if (payButton) {

            payButton.addEventListener('click', function () {

                openRazorpay();

            });


            setTimeout(function () {

                openRazorpay();

            }, 500);

        }

    });

</script>
```

@endif

{{-- ========================================= --}}
{{-- PASSWORD SHOW / HIDE SCRIPT              --}}
{{-- ========================================= --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const passwordInput =
            document.getElementById('password');

        const togglePassword =
            document.getElementById('togglePassword');


        if (!passwordInput || !togglePassword) {

            return;

        }


        togglePassword.addEventListener('click', function () {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                togglePassword.textContent = '🙈';

                togglePassword.setAttribute(
                    'aria-label',
                    'Hide password'
                );

            } else {

                passwordInput.type = 'password';

                togglePassword.textContent = '👁️';

                togglePassword.setAttribute(
                    'aria-label',
                    'Show password'
                );

            }

        });

    });

</script>

</body>

</html>
