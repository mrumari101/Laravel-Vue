<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Tenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tenants.create') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="tenant_id" :value="__('Tenant ID')" />
                            <x-text-input id="tenant_id" name="tenant_id" type="text" 
                                class="mt-1 block w-full" required autofocus 
                                placeholder="e.g., school1" />
                            <p class="mt-2 text-sm text-gray-500">
                                This will be used as the unique identifier for the tenant.
                            </p>
                        </div>

                        <div>
                            <x-input-label for="domain" :value="__('Domain')" />
                            <x-text-input id="domain" name="domain" type="text" 
                                class="mt-1 block w-full" required 
                                placeholder="e.g., school1.localhost" />
                            <p class="mt-2 text-sm text-gray-500">
                                The domain where this tenant will be accessible.
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Tenant') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>