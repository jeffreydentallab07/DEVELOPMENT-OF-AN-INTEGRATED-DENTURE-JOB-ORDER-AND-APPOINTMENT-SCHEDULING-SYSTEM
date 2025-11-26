<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo3.ico') }}" type="image/x-icon">
    <title>@yield('title', 'Clinic Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .notification-popup-transition {
            transition: transform 0.2s ease-out, opacity 0.2s ease-out;
        }

        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="h-screen flex bg-white text-[12px]">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="w-48 sm:w-52 md:w-48 bg-blue-900 text-white flex flex-col fixed top-0 left-0 h-full z-40 transform -translate-x-full md:translate-x-0 sidebar-transition">
        <div class="h-16 sm:h-20 px-3 border-b border-blue-700 flex items-center justify-between">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="h-10 sm:h-12 object-contain">
            <!-- Close button (mobile only) -->
            <button id="close-sidebar-btn" class="md:hidden text-white p-2 hover:bg-blue-800 rounded">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="mt-3 sm:mt-4 flex-grow space-y-1 overflow-y-auto">
            <a href="{{ route('clinic.case-orders.index') }}"
                class="flex items-center space-x-2 p-2 sm:p-2.5 rounded-l-lg hover:bg-gray-300 hover:text-blue-900 {{ request()->routeIs('clinic.case-orders.*') ? 'bg-gray-300 text-blue-900 font-semibold' : 'text-indigo-300' }} text-xs sm:text-[12px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v12a2 2 0 01-2 2z" />
                </svg>
                <span>Case Orders</span>
            </a>

            <a href="{{ route('clinic.appointments.index') }}"
                class="flex items-center space-x-2 p-2 sm:p-2.5 rounded-l-lg hover:bg-gray-300 hover:text-blue-900 {{ request()->routeIs('clinic.appointments.*') ? 'bg-gray-300 text-blue-900 font-semibold' : 'text-indigo-300' }} text-xs sm:text-[12px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        d="M8 7V3m8 4V3m-9 8h10m-10 4h10M4 21h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Appointments</span>
            </a>

            <a href="{{ route('clinic.patients.index') }}"
                class="flex items-center space-x-2 p-2 sm:p-2.5 rounded-l-lg hover:bg-gray-300 hover:text-blue-900 {{ request()->routeIs('clinic.patients.*') ? 'bg-gray-300 text-blue-900 font-semibold' : 'text-indigo-300' }} text-xs sm:text-[12px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        d="M5.121 17.804A8.962 8.962 0 0112 15c2.5 0 4.735 1.03 6.379 2.684M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Patients</span>
            </a>

            <a href="{{ route('clinic.dentists.index') }}"
                class="flex items-center space-x-2 p-2 sm:p-2.5 rounded-l-lg hover:bg-gray-300 hover:text-blue-900 {{ request()->routeIs('clinic.dentists.*') ? 'bg-gray-300 text-blue-900 font-semibold' : 'text-indigo-300' }} text-xs sm:text-[12px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20v-1a4 4 0 014-4h4a4 4 0 014 4v1H6z" />
                </svg>
                <span>Dentists</span>
            </a>

            <a href="{{ route('clinic.billing.index') }}"
                class="flex items-center space-x-2 p-2 sm:p-2.5 rounded-l-lg hover:bg-gray-300 hover:text-blue-900 {{ request()->routeIs('clinic.billing.*') ? 'bg-gray-300 text-blue-900 font-semibold' : 'text-indigo-300' }} text-xs sm:text-[12px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9m14 0h-4" />
                </svg>
                <span>Billing</span>
            </a>
        </nav>

        <div class="p-3 sm:p-4 border-t border-blue-700 text-[10px] sm:text-xs space-y-2">
            <p class="uppercase tracking-wide text-indigo-300 font-semibold">Follow Us</p>
            <div class="flex items-center gap-2 sm:gap-3 text-indigo-200">
                <a href="https://www.facebook.com/jeffrey.dental.lab.2025" target="_blank" class="hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M22 12a10 10 0 1 0-11.5 9.95v-7.05H8v-3h2.5V9.5a3.5 3.5 0 0 1 3.7-3.8c1 0 2 .1 2 .1v2.3h-1.2c-1.2 0-1.6.8-1.6 1.6v1.8H17l-.3 3h-2.5v7.05A10 10 0 0 0 22 12" />
                    </svg>
                </a>
                <a href="#" class="hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M23 3a10.9 10.9 0 0 1-3.14.86A4.48 4.48 0 0 0 22.4.36a9.08 9.08 0 0 1-2.88 1.1A4.52 4.52 0 0 0 16.62 0a4.48 4.48 0 0 0-4.5 4.5c0 .35.04.7.12 1.03A12.94 12.94 0 0 1 1.64.88 4.48 4.48 0 0 0 3.04 6.5a4.48 4.48 0 0 1-2.04-.56v.06a4.52 4.52 0 0 0 3.6 4.41 4.48 4.48 0 0 1-2.03.08 4.48 4.48 0 0 0 4.18 3.12A9 9 0 0 1 0 19.54a12.73 12.73 0 0 0 6.92 2.03c8.3 0 12.84-6.87 12.84-12.84 0-.2 0-.41-.01-.61A9.22 9.22 0 0 0 24 4.56a9.1 9.1 0 0 1-2.6.71A4.52 4.52 0 0 0 23 3z" />
                    </svg>
                </a>
            </div>
            <p class="mt-2 text-indigo-300 text-[10px] sm:text-[11px]">@JeffreyDentalLab</p>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow flex flex-col h-full md:ml-48">

        <!-- Header -->
        <header class="bg-white px-3 py-2 sm:p-3 flex items-center justify-between md:justify-end shadow-md z-10">

            <!-- Hamburger Menu (Mobile Only) -->
            <button id="hamburger-btn" class="md:hidden text-gray-700 p-1.5 sm:p-2 hover:bg-gray-100 rounded">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Search Bar (Hidden on small screens) -->
            {{-- <div class="hidden lg:flex items-center gap-2 border border-gray-300 rounded-lg w-96 p-2 bg-white">
                <svg class="w-4 h-4 text-gray-300 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5z" />
                </svg>
                <input type="text" placeholder="Search..." class="outline-none w-full text-[12px]">
            </div> --}}


            <div class="flex items-center gap-1.5 sm:gap-2">

                <a href="{{ route('clinic.dashboard') }}"
                    class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-lg hover:bg-gray-300 transition ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke="black">
                        <path d="M3 12l9-9 9 9M4 10v10h5v-6h6v6h5V10" />
                    </svg>
                </a>
                <div id="notification-container" class="relative">
                    <button id="notification-bell-btn"
                        class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-lg hover:bg-gray-300 transition relative z-30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                        </svg>

                        @if(isset($notificationCount) && $notificationCount > 0)
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                            {{ $notificationCount }}
                        </span>
                        @endif
                    </button>

                    <div id="notification-popup"
                        class="absolute right-0 sm:right-auto sm:left-auto mt-3 w-[calc(100vw-2rem)] sm:w-80 md:w-96 max-w-md bg-white rounded-xl shadow-2xl border border-gray-300 hidden z-40 origin-top-right notification-popup-transition scale-95 opacity-0">
                        <div
                            class="p-3 sm:p-4 border-b border-gray-300 flex justify-between items-center bg-gray-50 rounded-t-xl">
                            <h5 class="text-sm sm:text-base font-semibold text-gray-700">Notifications</h5>
                            @if(isset($notificationCount) && $notificationCount > 0)
                            <span class="text-xs text-red-500 font-medium">{{ $notificationCount }} New</span>
                            @endif
                        </div>

                        <div class="max-h-64 sm:max-h-80 overflow-y-auto divide-y divide-gray-200">
                            @if(isset($clinicNotifications) && $clinicNotifications->count() > 0)
                            @foreach($clinicNotifications as $notification)
                            <a href="{{ $notification->link ?? '#' }}"
                                onclick="markAsRead(event, {{ $notification->id }})"
                                class="block p-2.5 sm:p-3 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs sm:text-sm font-medium text-gray-800 truncate">{{
                                            $notification->title }}</p>
                                        <p class="text-[11px] sm:text-xs text-gray-600 mt-1 line-clamp-2">{{
                                            $notification->message }}</p>
                                        <p class="text-[10px] sm:text-xs text-gray-400 mt-1">{{
                                            $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <div class="p-4 sm:p-6 text-center text-gray-500">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                <p class="text-xs sm:text-sm">No new notifications</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="relative">
                    <button id="userDropdownBtn"
                        class="flex items-center gap-1 px-1.5 sm:px-2 py-1 rounded-lg hover:bg-gray-100 text-[11px] sm:text-[12px]">
                        <div
                            class="w-6 h-6 sm:w-7 sm:h-7 bg-blue-600 text-white flex items-center justify-center rounded-full font-bold text-[10px] sm:text-[11px]">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:inline max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                    </button>
                    <div id="userDropdownMenu"
                        class="absolute right-0 mt-2 w-36 sm:w-40 bg-white rounded-md shadow-md border hidden z-50">
                        <button id="openClinicSettingsBtn" type="button"
                            class="w-full text-left flex items-center px-3 py-2 hover:bg-gray-100 text-[11px] sm:text-[12px]">Settings</button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-3 py-2 text-red-500 hover:bg-gray-100 text-[11px] sm:text-[12px]">Sign
                                out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow overflow-y-auto">
            <div>
                @yield('content')
            </div>
        </main>
    </div>

    <div id="clinicSettingsModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50 p-2 sm:p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
            <div
                class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-4 sm:px-6 md:px-8 py-4 sm:py-5 rounded-t-xl z-10">
                <h2 class="text-xl sm:text-2xl font-bold text-white">Clinic Settings</h2>
                <p class="text-blue-100 text-xs sm:text-sm mt-1">Update your clinic information and account preferences
                </p>
            </div>

            <form id="clinicSettingsForm" method="POST" action="{{ route('clinic.settings.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="px-4 sm:px-6 md:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6">
                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200">
                        <h3
                            class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            Clinic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Clinic
                                    Name</label>
                                <input type="text" name="clinic_name" value="{{ Auth::user()->clinic_name ?? '' }}"
                                    placeholder="Enter clinic name"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('clinic_name')
                                <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Phone
                                    Number</label>
                                <input type="text" name="phone" value="{{ Auth::user()->contact_number ?? '' }}"
                                    placeholder="Enter phone number"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('phone')
                                <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Clinic
                                    Address</label>
                                <textarea name="address" rows="3" placeholder="Enter clinic address"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none">{{ Auth::user()->address ?? '' }}</textarea>
                                @error('address')
                                <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200">
                        <h3
                            class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                            Profile Picture
                        </h3>
                        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                            <div class="flex-shrink-0">
                                @if(Auth::user()->profile_photo)
                                <img id="previewClinicPhoto" src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                    alt="Profile"
                                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-blue-100">
                                @else
                                <img id="previewClinicPhoto" src="{{ asset('images/default-avatar.png') }}"
                                    alt="Default Profile"
                                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-blue-100">
                                @endif
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <label
                                    class="cursor-pointer inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm font-medium text-sm">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Choose Photo
                                    <input type="file" name="photo" accept="image/*" class="hidden"
                                        onchange="previewClinicImage(event)">
                                </label>
                                <p class="text-[11px] sm:text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max size 2MB</p>
                                @error('photo')
                                <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Change Password
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">
                            Leave password fields empty if you don't want to change your password.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">New
                                    Password</label>
                                <input type="password" name="password"
                                    placeholder="Enter new password (min. 8 characters)"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                @error('password')
                                <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Confirm New
                                    Password</label>
                                <input type="password" name="password_confirmation" placeholder="Confirm new password"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div
                class="px-4 sm:px-6 md:px-8 py-4 sm:py-5 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 rounded-b-xl">
                <button type="button" onclick="closeModal('clinicSettingsModal')"
                    class="px-4 sm:px-6 py-2 sm:py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition text-sm order-2 sm:order-1">
                    Cancel
                </button>
                <button type="submit" form="clinicSettingsForm"
                    class="px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium shadow-sm transition text-sm order-1 sm:order-2">
                    Save Changes
                </button>
            </div>

        </div>
    </div>

    <script>
        // Mobile Sidebar Toggle
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        }

        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', openSidebar);
        }

        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeSidebar);
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', closeSidebar);
        }

        // Modal functions
        function openModal(id) { 
            document.getElementById(id).classList.remove('hidden'); 
            document.getElementById(id).classList.add('flex'); 
        }

        function closeModal(id) { 
            document.getElementById(id).classList.remove('flex'); 
            document.getElementById(id).classList.add('hidden'); 
        }

        function previewClinicImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewClinicPhoto').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function markAsRead(event, notificationId) {
            fetch(`/clinic/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    const countElement = document.querySelector('#notification-bell-btn span');
                    if (countElement) {
                        let count = parseInt(countElement.textContent);
                        count = Math.max(0, count - 1);
                        if (count === 0) {
                            countElement.remove();
                        } else {
                            countElement.textContent = count;
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Notification popup
            const bellButton = document.getElementById('notification-bell-btn');
            const popup = document.getElementById('notification-popup');
            const container = document.getElementById('notification-container');

            if (bellButton && popup) {
                function closePopup() {
                    popup.classList.add('hidden', 'scale-95', 'opacity-0');
                    popup.classList.remove('scale-100', 'opacity-100');
                }

                function openPopup() {
                    popup.classList.remove('hidden');
                    void popup.offsetWidth;
                    popup.classList.add('scale-100', 'opacity-100');
                    popup.classList.remove('scale-95', 'opacity-0');
                }

                bellButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (popup.classList.contains('hidden')) {
                        openPopup();
                    } else {
                        closePopup();
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!popup.classList.contains('hidden') && !container.contains(e.target)) {
                        closePopup();
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !popup.classList.contains('hidden')) {
                        closePopup();
                    }
                });
            }

            // User dropdown menu
            const userBtn = document.getElementById('userDropdownBtn');
            const userMenu = document.getElementById('userDropdownMenu');
            const openSettingsBtn = document.getElementById('openClinicSettingsBtn');
            const modal = document.getElementById('clinicSettingsModal');

            if (userBtn && userMenu) {
                userBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }

            if (openSettingsBtn && modal) {
                openSettingsBtn.addEventListener('click', function() {
                    userMenu.classList.add('hidden');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            }

            // Close modal and sidebar with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (modal && !modal.classList.contains('hidden')) {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                    }
                    if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                        closeSidebar();
                    }
                }
            });
        });
    </script>
</body>

</html>