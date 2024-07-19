<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        {{ config('app.name') }}
    </a>

    <ul class="mt-6">
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 cursor-default hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="#">
                    {{-- <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            </svg> --}}
                    <span class="ml-4">{{ __('Menu Admin') }}</span>
                </a>
            </li>
        @endrole
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('survey')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('survey') }}">
                    <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 16.5c0-1-8-2.7-9-2V1.8c1-1 9 .707 9 1.706M10 16.5V3.506M10 16.5c0-1 8-2.7 9-2V1.8c-1-1-9 .707-9 1.706" />

                    </svg>
                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Survei') }}</span>
                </a>
            </li>
        @endrole
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3 ">
                {!! request()->routeIs('page.survey.create')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('page.survey.create') }}">
                    <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 7.828 1h8.239A.969.969 0 0 1 17 2v16a.969.969 0 0 1-.933 1H3.933A.97.97 0 0 1 3 18v-2M8 1v4a1 1 0 0 1-1 1H3m-2 6h10M9.061 9.232 11.828 12l-2.767 2.768" />
                    </svg>
                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Buat Survei') }}</span>
                </a>
            </li>
        @endrole
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('dimensi')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('dimensi') }}">
                    <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M9.75 3.104v5.714a2.25 2.25 0 0
                                                                                                                                                                                                                                                        1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0
                                                                                                                                                                                                                                                        0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8
                                                                                                                                                                                                                                                        15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402
                                                                                                                                                                                                                                                        1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773
                                                                                                                                                                                                                                                        0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5">
                    </svg>
                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Dimensi') }}</span>
                </a>
            </li>
        @endrole
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('add.option')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('add.option') }}">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>

                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Opsi Jawaban') }}</span>
                </a>
            </li>
        @endrole
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('target.responden')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('target.responden') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Target Responden') }}</span>
                </a>
            </li>
        @endrole
        {{-- role Management --}}
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('roleManagement.page')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('roleManagement.page') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>

                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Role') }}</span>
                </a>
            </li>
        @endrole
        {{-- @role('Admin|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('resampling')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('resampling') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>

                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Resampling') }}</span>
                </a>
            </li>
        @endrole --}}
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 cursor-default hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="#">
                    {{-- <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    </svg> --}}
                    <span class="ml-4">{{ __('Menu User') }}</span>
                </a>
            </li>
        @endrole
        <li class="relative px-6 py-3">
            {!! request()->routeIs('dashboard')
                ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                : '' !!}
            <a data-turbolinks-action="replace"
                class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                href="{{ route('dashboard') }}">
                <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="ml-4">{{ __('Dashboard') }}</span>
            </a>
        </li>
        @role('Admin|Operator|Superadmin')
            <li class="relative px-6 py-3">
                {!! request()->routeIs('survey.fill.overview')
                    ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                    : '' !!}
                <a data-turbolinks-action="replace"
                    class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('survey.fill.overview') }}">
                    <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                    </path>
                    </svg>
                    <span class="ml-4">{{ __('Isi Survei') }}</span>
                </a>
            </li>
        @endrole
        <li class="relative px-6 py-3">
            {!! request()->routeIs('survey.visualize')
                ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>'
                : '' !!}
            <a data-turbolinks-action="replace"
                class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                href="{{ route('survey.visualize') }}">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                </path>
                </svg>
                <span class="ml-4">{{ __('Visualisasi') }}</span>
            </a>
        </li>

    </ul>

</div>
