@extends('layouts.general')
@section('title', 'Register - Frequenters')
@section('content')
<head>   
    <!-- Include Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* General Form Styling */
        

        .form-group {
            margin-bottom: 5px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #efefef;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive Adjustments */
        @media (max-width: 600px) {
            .container {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
<header class="header"><h1>Frequenters</h1></header>
    <div class="container">
        <div class="login-container">
            <h2>Register Your Business</h2>
            
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('business.register.submit') }}" method="POST">
                <!-- Add CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter a password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>

                <div class="form-group">
                    <label for="business_name">Business Name</label>
                    <input type="text" id="business_name" name="business_name" placeholder="Enter your business name" required>
                </div>

                <div class="form-group">
                    <label for="industry_type">Industry Type</label>
                    <input type="text" id="industry_type" name="industry_type" placeholder="Enter your industry type" required>
                </div>

                <div class="form-group">
                    <label for="address_line1">Address Line 1</label>
                    <input type="text" id="address_line1" name="address_line1" placeholder="Enter your business address">
                </div>

                <div class="form-group">
                    <label for="address_line2">Address Line 2</label>
                    <input type="text" id="address_line2" name="address_line2" placeholder="Enter additional address info">
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Enter your city" required>
                </div>

                <div class="form-group">
                    <label for="zip_code">Zip Code</label>
                    <input type="text" id="zip_code" name="zip_code" placeholder="Enter your zip code" required>
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" placeholder="Enter your state" required>
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" placeholder="Enter your country" required>
                </div>

                <div class="form-group">
                    <button type="submit">Register Business</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@endsection