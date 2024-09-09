<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Track Point</title>
    <link href="{{ asset('assets/img/logo.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('loginform_css/register.css') }}">
</head>
<body>
<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="login__field">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" class="login__input" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="login__field">
                    <label for="phone_number">Phone Number</label>
                    <input id="phone_number" type="text" name="phone_number" class="login__input" value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email (Optional) -->
                <div class="login__field">
                    <label for="email">Email (optional)</label>
                    <input id="email" type="email" name="email" class="login__input" value="{{ old('email') }}">
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Shop Information (Only show if not the first user) -->
                @if($userCount > 0)
                    <div class="login__field">
                        <label for="shop_count">Number of Shops</label>
                        <input id="shop_count" type="number" name="shop_count" class="login__input" min="1" value="{{ old('shop_count') }}" required>
                        @error('shop_count')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="shop-details">
                        <!-- Shop details will be populated here by JavaScript -->
                    </div>
                @endif

                <!-- Password -->
                <div class="login__field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="login__input" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="login__field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="login__input" required>
                </div>

                <button type="submit" class="button login__submit">Register</button>
            </form>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
</div>

<script>
// Pass the user count from PHP to JavaScript
const userCount = {{ $userCount }};

if (userCount > 0) {
    document.getElementById('shop_count').addEventListener('input', function () {
        const shopDetailsDiv = document.getElementById('shop-details');
        shopDetailsDiv.innerHTML = ''; // Clear existing fields

        const shopCount = this.value;
        if (shopCount > 0) {
            for (let i = 1; i <= shopCount; i++) {
                shopDetailsDiv.innerHTML += `
                    <h4>Shop ${i} Details</h4>
                    <div class="login__field">
                        <label for="shop_name_${i}">Shop Name</label>
                        <input id="shop_name_${i}" type="text" name="shop_names[]" class="login__input" required>
                    </div>
                    <div class="login__field">
                        <label for="shop_address_${i}">Shop Address</label>
                        <input id="shop_address_${i}" type="text" name="shop_addresses[]" class="login__input" required>
                    </div>
                `;
            }
        }
    });
}
</script>
</body>
</html>
