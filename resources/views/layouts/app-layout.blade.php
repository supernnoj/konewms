<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-fav.png') }}">
    <title>KWMS</title>

    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" />
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
        /* Additional Style */
        /* primary color: 1450f5 */
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
            font-size: 18px;
            border-radius: 3px;
            text-transform: uppercase;
        }

        .list-group-item-action:focus,
        .list-group-item-action:active {
            outline: none !important;
            /* box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.5) !important; */
            box-shadow: none;
            /* adjust to your primary color */
            border-color: #1450f5 !important;
            /* Bootstrap primary or your brand color */

        }

        .table .thead-primary th {
            color: #FFFFFF;
            background-color: #1450f5;
            border-color: #1450f5;
        }
        
    </style>

    @livewireStyles
</head>

<body>
    <div class="be-wrapper be-mega-menu">
        @include('layouts.navbar-top-header')
        @include('layouts.navbar-sub-header')
        <div class="be-content container">
            <div class="page-head">
                <h2 class="page-head-title">@yield('page-head-title')</h2>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb page-head-nav">
                        @yield('breadcrumb-item')
                    </ol>
                </nav>
            </div>
            <div class="main-content container-fluid">
                @yield('main-content')
            </div>
        </div>
        <nav class="be-right-sidebar">
            <div class="sb-content">
                <div class="tab-navigation">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab1"
                                aria-controls="tab1" role="tab" data-toggle="tab">Chat</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#tab2" aria-controls="tab2"
                                role="tab" data-toggle="tab">Todo</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#tab3" aria-controls="tab3"
                                role="tab" data-toggle="tab">Settings</a></li>
                    </ul>
                </div>
                <div class="tab-panel">
                    <div class="tab-content">
                        <div class="tab-pane tab-chat active" id="tab1" role="tabpanel">
                            <div class="chat-contacts">
                                <div class="chat-sections">
                                    <div class="be-scroller-chat">
                                        <div class="content">
                                            <h2>Recent</h2>
                                            <div class="contact-list contact-list-recent">
                                                <div class="user"><a href="#"><img src="assets/img/avatar1.png"
                                                            alt="Avatar">
                                                        <div class="user-data"><span class="status away"></span><span
                                                                class="name">Claire Sassu</span><span
                                                                class="message">Can you share the...</span></div>
                                                    </a></div>
                                                <div class="user"><a href="#"><img src="assets/img/avatar2.png"
                                                            alt="Avatar">
                                                        <div class="user-data"><span class="status"></span><span
                                                                class="name">Maggie jackson</span><span
                                                                class="message">I confirmed the info.</span></div>
                                                    </a></div>
                                                <div class="user"><a href="#"><img src="assets/img/avatar3.png"
                                                            alt="Avatar">
                                                        <div class="user-data"><span
                                                                class="status offline"></span><span
                                                                class="name">Joel King </span><span
                                                                class="message">Ready for the meeti...</span></div>
                                                    </a></div>
                                            </div>
                                            <h2>Contacts</h2>
                                            <div class="contact-list">
                                                <div class="user"><a href="#"><img
                                                            src="assets/img/avatar4.png" alt="Avatar">
                                                        <div class="user-data2"><span class="status"></span><span
                                                                class="name">Mike Bolthort</span></div>
                                                    </a></div>
                                                <div class="user"><a href="#"><img
                                                            src="assets/img/avatar5.png" alt="Avatar">
                                                        <div class="user-data2"><span class="status"></span><span
                                                                class="name">Maggie jackson</span></div>
                                                    </a></div>
                                                <div class="user"><a href="#"><img
                                                            src="assets/img/avatar6.png" alt="Avatar">
                                                        <div class="user-data2"><span
                                                                class="status offline"></span><span
                                                                class="name">Jhon Voltemar</span></div>
                                                    </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-input">
                                    <input type="text" placeholder="Search..." name="q"><span
                                        class="mdi mdi-search"></span>
                                </div>
                            </div>
                            <div class="chat-window">
                                <div class="title">
                                    <div class="user"><img src="assets/img/avatar2.png" alt="Avatar">
                                        <h2>Maggie jackson</h2><span>Active 1h ago</span>
                                    </div><span class="icon return mdi mdi-chevron-left"></span>
                                </div>
                                <div class="chat-messages">
                                    <div class="be-scroller-messages">
                                        <div class="content">
                                            <ul>
                                                <li class="friend">
                                                    <div class="msg">Hello</div>
                                                </li>
                                                <li class="self">
                                                    <div class="msg">Hi, how are you?</div>
                                                </li>
                                                <li class="friend">
                                                    <div class="msg">Good, I'll need support with my pc</div>
                                                </li>
                                                <li class="self">
                                                    <div class="msg">Sure, just tell me what is going on with your
                                                        computer?</div>
                                                </li>
                                                <li class="friend">
                                                    <div class="msg">I don't know it just turns off suddenly</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-input">
                                    <div class="input-wrapper"><span class="photo mdi mdi-camera"></span>
                                        <input type="text" placeholder="Message..." name="q"
                                            autocomplete="off"><span class="send-msg mdi mdi-mail-send"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tab-todo" id="tab2" role="tabpanel">
                            <div class="todo-container">
                                <div class="todo-wrapper">
                                    <div class="be-scroller-todo">
                                        <div class="todo-content"><span class="category-title">Today</span>
                                            <ul class="todo-list">
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            checked="" id="tck1">
                                                        <label class="custom-control-label" for="tck1">Initialize
                                                            the project</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tck2">
                                                        <label class="custom-control-label" for="tck2">Create the
                                                            main structure </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tck3">
                                                        <label class="custom-control-label" for="tck3">Updates
                                                            changes to GitHub </label>
                                                    </div>
                                                </li>
                                            </ul><span class="category-title">Tomorrow</span>
                                            <ul class="todo-list">
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tck4">
                                                        <label class="custom-control-label" for="tck4">Initialize
                                                            the project </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tck5">
                                                        <label class="custom-control-label" for="tck5">Create the
                                                            main structure </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tck6">
                                                        <label class="custom-control-label" for="tck6">Updates
                                                            changes to GitHub </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-checkbox custom-control custom-control-sm"><span
                                                            class="delete mdi mdi-delete"></span>
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="tck7">
                                                        <label class="custom-control-label" for="tck7"
                                                            title="This task is too long to be displayed in a normal space!">This
                                                            task is too long to be displayed in a normal space! </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-input">
                                    <input type="text" placeholder="Create new task..." name="q"><span
                                        class="mdi mdi-plus"></span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tab-settings" id="tab3" role="tabpanel">
                            <div class="settings-wrapper">
                                <div class="be-scroller-settings"><span class="category-title">General</span>
                                    <ul class="settings-list">
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" checked="" name="st1"
                                                    id="st1"><span>
                                                    <label for="st1"></label></span>
                                            </div><span class="name">Available</span>
                                        </li>
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" checked="" name="st2"
                                                    id="st2"><span>
                                                    <label for="st2"></label></span>
                                            </div><span class="name">Enable notifications</span>
                                        </li>
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" checked="" name="st3"
                                                    id="st3"><span>
                                                    <label for="st3"></label></span>
                                            </div><span class="name">Login with Facebook</span>
                                        </li>
                                    </ul><span class="category-title">Notifications</span>
                                    <ul class="settings-list">
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" name="st4" id="st4"><span>
                                                    <label for="st4"></label></span>
                                            </div><span class="name">Email notifications</span>
                                        </li>
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" checked="" name="st5"
                                                    id="st5"><span>
                                                    <label for="st5"></label></span>
                                            </div><span class="name">Project updates</span>
                                        </li>
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" checked="" name="st6"
                                                    id="st6"><span>
                                                    <label for="st6"></label></span>
                                            </div><span class="name">New comments</span>
                                        </li>
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" name="st7" id="st7"><span>
                                                    <label for="st7"></label></span>
                                            </div><span class="name">Chat messages</span>
                                        </li>
                                    </ul><span class="category-title">Workflow</span>
                                    <ul class="settings-list">
                                        <li>
                                            <div class="switch-button switch-button-sm">
                                                <input type="checkbox" name="st8" id="st8"><span>
                                                    <label for="st8"></label></span>
                                            </div><span class="name">Deploy on commit</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <footer class="be-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 pt-4"><img class="mb-3" src="{{ asset('assets/img/logo.png') }}"
                        alt="KONE">
                    <p class="mb-3">Autum - ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                        incididunt.</p>
                    <p>&copy; 2018 Your Company</p>
                </div>
                <div class="col-md-7 offset-md-1 pt-4">
                    <div class="row justify-content-around">
                        <div class="col">
                            <ul class="list-unstyled be-footer-links">
                                <li class="mb-1"><strong>Learn more</strong></li>
                                <li><a class="text-reset" href="#">Blueprints</a></li>
                                <li><a class="text-reset" href="#">Webinars</a></li>
                                <li><a class="text-reset" href="#">Tools</a></li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-unstyled">
                                <li class="mb-1"><strong>Company</strong></li>
                                <li><a class="text-reset" href="#">Our Team</a></li>
                                <li><a class="text-reset" href="#">Philosophy</a></li>
                                <li><a class="text-reset" href="#">Green Work</a></li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-unstyled">
                                <li class="mb-1"><strong>Follow</strong></li>
                                <li><a class="text-reset" href="#">Github</a></li>
                                <li><a class="text-reset" href="#">Twitter</a></li>
                                <li><a class="text-reset" href="#">LinkedIn</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Docs</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Company</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Support</a></li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-4">
                    <p class="footer-copyright text-secondary">&copy; 2018 Your Company</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/prettify/prettify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app-megamenu.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('assets/lib/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app-ui-sweetalert2.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap-slider/bootstrap-slider.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bs-custom-file-input/bs-custom-file-input.js') }}" type="text/javascript"></script>

    <!-- Initialize scripts -->
    <script type="text/javascript">
        $(document).ready(function() {
            //initialize the javascript
            App.init();
            App.megaMenu();

            App.formElements();

            //Runs prettify
            prettyPrint();

            //sweetalert2
            // App.uiSweetalert2();

            //Reload Page
            window.addEventListener('page:reload', () => {
                window.location.reload();
            });

        });
    </script>
    {{-- @include('alerts.swal-alerts') --}}
    @include('transactions.transactions-alert')
    @livewireScripts
    @stack('scripts')
</body>

</html>
