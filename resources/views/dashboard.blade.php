<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">
                        User Monitoring
                    </h3>

                    <div class="space-y-3">

                        <a href="/user-monitoring/visits-monitoring"
                            class="block text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">
                            Visits Monitoring
                        </a>

                        <a href="/user-monitoring/actions-monitoring"
                            class="block text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">
                            Actions Monitoring
                        </a>

                        <a href="/user-monitoring/authentications-monitoring"
                            class="block text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">
                            Authentication Monitoring
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>