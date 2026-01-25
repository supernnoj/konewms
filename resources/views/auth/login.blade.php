<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Warehouse Monitoring System - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-fav.png') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/lib/material-design-icons/css/material-design-iconic-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/lib/bootstrap-slider/css/bootstrap-slider.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}" />

    <!-- Additional imports -->
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    {{-- @import url('https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css') --}}


    <style>
        body {
            margin: 0;
            font-family: "Roboto", Arial, sans-serif;
            background-color: #f3f5f7;
            color: #333;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f3f5f7;
        }

        .login-topbar {
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 32px;
            background-color: #1450f5;
            /* match your blue navbar */
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .login-topbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .login-topbar-logo img {
            height: 32px;
        }

        .login-topbar-title {
            font-size: 18px;
            font-weight: 500;
            letter-spacing: .5px;
        }

        .login-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .login-card-header {
            padding: 20px 24px 12px;
            border-bottom: 1px solid #eef0f4;
        }

        .login-card-title {
            margin: 0;
            font-size: 20px;
            font-weight: 500;
            color: #222;
        }

        .login-card-subtitle {
            margin-top: 4px;
            font-size: 13px;
            color: #6b7280;
        }

        .login-card-body {
            padding: 20px 24px 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            height: 38px;
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #cbd2e1;
            font-size: 14px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #1450f5;
            box-shadow: 0 0 0 1px rgba(12, 79, 183, 0.15);
        }

        .login-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #4b5563;
        }

        .btn-primary-login {
            padding: 8px 18px;
            border-radius: 4px;
            border: none;
            background-color: #1450f5;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color .15s ease, box-shadow .15s ease;
        }

        .btn-primary-login:hover {
            background-color: #0a3f92;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .alert {
            padding: 10px 12px;
            margin-bottom: 16px;
            border-radius: 4px;
            font-size: 13px;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .login-footer-text {
            margin-top: 12px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }

        @media (max-width: 480px) {
            .login-card {
                max-width: 100%;
            }
        }

        .kone-letter-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            height: 32px;
            padding: 0 6px;
            /* slimmer left/right space */
            width: 20px;
            /* keeps it boxy but not too wide */

            font-weight: 700;
            border-radius: 3px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        {{-- Top bar similar to app --}}
        {{-- <div class="login-topbar">
            <div class="login-topbar-logo">
                <img src="{{ asset('assets/img/kone.png') }}" alt="KONE">
                <span
                    class="kone-letter-box bg-white text-primary d-inline-flex align-items-center justify-content-center">
                    K
                </span>
                <span
                    class="kone-letter-box bg-white text-primary d-inline-flex align-items-center justify-content-center">
                    O
                </span>
                <span
                    class="kone-letter-box bg-white text-primary d-inline-flex align-items-center justify-content-center">
                    N
                </span>
                <span
                    class="kone-letter-box bg-white text-primary d-inline-flex align-items-center justify-content-center">
                    E
                </span>
                <span class="login-topbar-title ml-3">Warehouse Monitoring System</span>
            </div>
        </div> --}}

        {{-- Centered login card --}}
        <div class="login-main">
            <div class="login-card">
                <div class="login-card-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="120" align="center" valign="middle" style="padding:10px 20px 10px 0px;">
                            <img src="{{ asset('assets/img/kone.png') }}" alt="KONE" style="height:40px;">
                        </td>
                        <td align="left" valign="middle">
                            <div style="
                                font-size:10px;
                                color:#666;
                                letter-spacing:2px;
                                font-family: Arial, Helvetica, sans-serif;
                                font-weight:500;
                                margin-bottom:2px;">
                                WAREHOUSE MONITORING SYSTEM
                            </div>
                            <div class="text-uppercase"
                                 style="
                                    font-size:24px;
                                    font-weight:bold;
                                    color:#222;
                                    font-family: Arial, Helvetica, sans-serif;
                                    letter-spacing:1px;
                                    margin-top:4px;">
                                SIGN IN
                            </div>
                        </td>
                    </tr>
                </table>
                    {{-- <h1 class="login-card-title">
                        Sign in
                    </h1>
                    <p class="login-card-subtitle">Use your Employee ID to access the Warehouse Monitoring System.</p> --}}
                </div>

                <div class="login-card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="form-group">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input id="employee_id" type="text" name="employee_id" value="{{ old('employee_id') }}"
                                class="form-control" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>

                        <div class="login-footer-row">
                            {{-- <label class="form-check">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label> --}}

                            <div></div>

                            <button type="submit" class="btn-primary-login">
                                Login
                            </button>
                        </div>
                    </form>

                    <div class="login-footer-text mt-5">
                        © {{ date('Y') }}
                        <img class="pl-1 pr-1" style="height: 16px" src="{{ asset('assets/img/kone.png') }}"
                            alt="KONE">
                        Warehouse Monitoring System
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
