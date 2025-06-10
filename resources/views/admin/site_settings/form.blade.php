@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h3 class="text-lg font-medium text-gray-900">
                {{ isset($siteSetting) ? 'Edit Setting' : 'Create Setting' }}
            </h3>
            <p class="text-sm text-gray-500">
                {{ isset($siteSetting) ? 'Update the setting details' : 'Add a new setting to your site' }}
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            There were {{ $errors->count() }} errors with your submission
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ isset($siteSetting) ? route('admin.site-settings.update', $siteSetting->id) : route('admin.site-settings.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @if (isset($siteSetting))
                @method('PUT')
            @endif

            <!-- Key Selection -->
            <div class="space-y-2">
                <label for="key" class="block text-sm font-medium text-gray-700">
                    Key
                </label>
                <div class="space-y-2">
                    <!-- Predefined Keys Select -->
                    <select id="predefined_keys"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        {{ isset($siteSetting) ? 'disabled' : '' }}>
                        <option value="">Select a predefined key or enter custom below</option>
                        <option value="nav-top" {{ old('key', $siteSetting->key ?? '') == 'nav-top' ? 'selected' : '' }}>nav-top</option>
                        <option value="footer-bottom" {{ old('key', $siteSetting->key ?? '') == 'footer-bottom' ? 'selected' : '' }}>footer-bottom</option>
                        <option value="footer-sections" {{ old('key', $siteSetting->key ?? '') == 'footer-sections' ? 'selected' : '' }}>footer-sections</option>
                        <option value="social-links" {{ old('key', $siteSetting->key ?? '') == 'social-links' ? 'selected' : '' }}>social-links</option>
                        <option value="site-title" {{ old('key', $siteSetting->key ?? '') == 'site-title' ? 'selected' : '' }}>site-title</option>
                        <option value="site-description" {{ old('key', $siteSetting->key ?? '') == 'site-description' ? 'selected' : '' }}>site-description</option>
                        <option value="copyright" {{ old('key', $siteSetting->key ?? '') == 'copyright' ? 'selected' : '' }}>copyright</option>
                        <option value="footer-company" {{ old('key', $siteSetting->key ?? '') == 'footer-company' ? 'selected' : '' }}>footer-company</option>
                    </select>

                    <!-- Custom Key Input -->
                    <input type="text" name="key" id="key"
                        value="{{ old('key', $siteSetting->key ?? '') }}"
                        placeholder="Or enter custom key here"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        {{ isset($siteSetting) ? 'readonly' : '' }}>
                </div>
            </div>

            <!-- Field Type -->
            <div class="space-y-2">
                <label for="type" class="block text-sm font-medium text-gray-700">
                    Field Type
                </label>
                <select name="type" id="type"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="text" {{ old('type', $siteSetting->type ?? 'text') == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="internal_link" {{ old('type', $siteSetting->type ?? '') == 'internal_link' ? 'selected' : '' }}>Internal Link</option>
                    <option value="external_link" {{ old('type', $siteSetting->type ?? '') == 'external_link' ? 'selected' : '' }}>External Link</option>
                </select>
            </div>

            <!-- Value -->
            <div class="space-y-2">
                <label for="value" class="block text-sm font-medium text-gray-700">
                    Value
                </label>
                <textarea name="value" id="value" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('value', $siteSetting->value ?? '') }}</textarea>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Description
                </label>
                <textarea name="description" id="description" rows="2"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $siteSetting->description ?? '') }}</textarea>
            </div>

            <!-- Image -->
            <div class="space-y-2">
                <label for="image" class="block text-sm font-medium text-gray-700">
                    Image
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if (isset($siteSetting) && $siteSetting->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $siteSetting->image) }}" alt="Setting Image" class="w-32 h-32 object-cover rounded-md">
                    </div>
                @endif
            </div>

            <!-- URL (for external links) -->
            <div class="space-y-2">
                <label for="url" class="block text-sm font-medium text-gray-700">
                    URL
                </label>
                <input type="url" name="url" id="url"
                    value="{{ old('url', $siteSetting->url ?? '') }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Article (for internal links) -->
            <div class="space-y-2">
                <label for="article_id" class="block text-sm font-medium text-gray-700">
                    Linked Article
                </label>
                <select name="article_id" id="article_id"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select an article</option>
                    @foreach ($articles as $article)
                        <option value="{{ $article->id }}" {{ old('article_id', $siteSetting->article_id ?? '') == $article->id ? 'selected' : '' }}>
                            {{ $article->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Order -->
            <div class="space-y-2">
                <label for="order" class="block text-sm font-medium text-gray-700">
                    Display Order
                </label>
                <input type="number" name="order" id="order"
                    value="{{ old('order', $siteSetting->order ?? 0) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ isset($siteSetting) ? 'Update Setting' : 'Create Setting' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const predefinedKeysSelect = document.getElementById('predefined_keys');
    const keyInput = document.getElementById('key');
    const fieldTypeSelect = document.getElementById('field_type');

    // Handle predefined key selection
    predefinedKeysSelect.addEventListener('change', function() {
        if (this.value) {
            keyInput.value = this.value;
        }
    });

    // Handle custom key input
    keyInput.addEventListener('input', function() {
        if (this.value) {
            predefinedKeysSelect.value = '';
        }
    });

    // Listen for field type changes
    fieldTypeSelect.addEventListener('change', toggleFields);
});
</script>
@endsection
