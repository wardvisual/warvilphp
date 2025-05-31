<!-- <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" style="background-image: url('/public/assets/warvilphp.jpg');"> -->
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 flex items-center justify-center">
    <div class="mt-[4em] w-full max-w-6xl bg-gray-900 bg-opacity-80 rounded-xl shadow-2xl overflow-hidden">
        <div class="p-8 md:p-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-purple-400 text-6xl md:text-7xl lg:text-8xl font-bold mb-4">WarvilPHP</h1>
                <p class="text-gray-300 text-2xl md:text-3xl font-light">
                    The elegance of frameworks, the freedom of pure PHP.
                </p>
            </div>
            
            <!-- Feature Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🏗️</div>
                    <h3 class="text-white text-xl font-semibold mb-2">MVC Architecture</h3>
                    <p class="text-gray-300">Clean separation of Model, View and Controller for organized code structure.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🌐</div>
                    <h3 class="text-white text-xl font-semibold mb-2">Simple Routing</h3>
                    <p class="text-gray-300">Intuitive routing system for both web pages and API endpoints.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🔧</div>
                    <h3 class="text-white text-xl font-semibold mb-2">CLI Tools</h3>
                    <p class="text-gray-300">Built-in command line tools for scaffolding your application.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🧩</div>
                    <h3 class="text-white text-xl font-semibold mb-2">Components</h3>
                    <p class="text-gray-300">Reusable view components for consistent interfaces.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🛡️</div>
                    <h3 class="text-white text-xl font-semibold mb-2">Middleware</h3>
                    <p class="text-gray-300">Request filtering for authentication, validation, and more.</p>
                </div>
                <div class="bg-gray-800 bg-opacity-50 p-6 rounded-lg hover:bg-purple-900 hover:bg-opacity-30 transition-all duration-300">
                    <div class="text-purple-400 text-4xl mb-4">🔌</div>
                    <h3 class="text-white text-xl font-semibold mb-2">API Development</h3>
                    <p class="text-gray-300">Tools for building robust RESTful APIs quickly.</p>
                </div>
            </div>
            
            <!-- Get Started -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-lg mb-8">
                <h2 class="text-white text-2xl font-semibold mb-4">Get Started</h2>
                <div class="bg-gray-900 p-4 rounded-md overflow-x-auto mb-4">
                    <pre class="text-green-400">$ php warvil make:controller UserController</pre>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="/docs" class="block bg-purple-700 hover:bg-purple-600 text-white text-center py-3 px-4 rounded-md transition-colors">Documentation</a>
                    <a href="https://github.com/wardvisual/warvilphp" target="_blank" class="block bg-gray-700 hover:bg-gray-600 text-white text-center py-3 px-4 rounded-md transition-colors">GitHub</a>
                    <a href="/examples" class="block bg-gray-700 hover:bg-gray-600 text-white text-center py-3 px-4 rounded-md transition-colors">Examples</a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center text-gray-400">
                <p>WarvilPHP v<?= WARVIL_VERSION ?? '1.0.0' ?> • Made with ❤️ by <a href="https://github.com/wardvisual" class="text-purple-400 hover:text-purple-300">WardVisual</a></p>
                <p class="text-sm mt-2">Under active development. While we strive for stability, use in production is at your own risk.</p>
            </div>
        </div>
    </div>
</div>