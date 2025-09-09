{{-- Footer --}}
<footer class="bg-white border-t border-gray-100">
    <div class="mx-auto max-w-[100em] px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-start gap-12 gap-x-30">

            {{-- Brand --}}
            <div class="grow-1 max-w-[30em]">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('assets/images/stone_logo.webp') }}" alt="Stone" class="h-10 w-10" />
                    <span class="text-2xl font-bold text-gray-900">Stone</span>
                </div>
                <p class="text-gray-600 leading-relaxed mb-6">
                    La solution de gestion client tout-en-un conçue par un freelance pour simplifier votre quotidien professionnel.
                </p>
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Suivez-nous (5)</h4>
                    <div class="flex items-center space-x-3">
                        <a href="{{ config('contact.social.x') }}" target="_blank" rel="noopener" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-blue-100 transition-colors group">
                            <svg class="h-5 w-5 text-gray-600 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="{{ config('contact.social.facebook') }}" target="_blank" rel="noopener" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-blue-100 transition-colors group">
                            <svg class="h-5 w-5 text-gray-600 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="{{ config('contact.social.instagram') }}" target="_blank" rel="noopener" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-pink-100 transition-colors group">
                            <svg class="h-5 w-5 text-gray-600 group-hover:text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="{{ config('contact.social.linkedin') }}" target="_blank" rel="noopener" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-blue-100 transition-colors group">
                            <svg class="h-5 w-5 text-gray-600 group-hover:text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="{{ config('contact.social.github') }}" target="_blank" rel="noopener" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors group">
                            <svg class="h-5 w-5 text-gray-600 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="mailto:{{ config('contact.emails.contact') }}" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                        <x-heroicon-o-envelope class="h-5 w-5 text-gray-600" />
                    </a>
                    <a href="tel:{{ config('contact.phone.main') }}" class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                        <x-heroicon-o-phone class="h-5 w-5 text-gray-600" />
                    </a>
                </div>
            </div>

            {{--LINKS COLUMNS--}}
            <div class="flex items-start justify-between gap-x-24 gap-y-12 flex-wrap grow-1">

                {{-- Product --}}
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Produit</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="{{ route('features') }}" class="hover:text-gray-900 transition-colors">Fonctionnalités</a></li>
                        <li><a href="{{ route('security') }}" class="hover:text-gray-900 transition-colors">Sécurité</a></li>
                        <li><a href="{{ route('updates') }}" class="hover:text-gray-900 transition-colors">Mises à jour</a></li>
                    </ul>
                </div>

                {{-- Support --}}
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Support</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="{{ route('support.help-center') }}" class="hover:text-gray-900 transition-colors">Centre d'aide</a></li>
                        <li><a href="{{ route('support.documentation') }}" class="hover:text-gray-900 transition-colors">Documentation</a></li>
                        <li><a href="{{ route('support.contact') }}" class="hover:text-gray-900 transition-colors">Contact</a></li>
                        <li><a href="{{ route('support.community') }}" class="hover:text-gray-900 transition-colors">Communauté</a></li>
                    </ul>
                </div>

                {{-- Legal --}}
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Légal</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="{{ route('legal.legal-notice') }}" class="hover:text-gray-900 transition-colors">Mentions légales</a></li>
                        <li><a href="{{ route('legal.privacy') }}" class="hover:text-gray-900 transition-colors">Confidentialité</a></li>
                        <li><a href="{{ route('legal.terms') }}" class="hover:text-gray-900 transition-colors">CGU</a></li>
                        <li><a href="{{ route('legal.gdpr') }}" class="hover:text-gray-900 transition-colors">RGPD</a></li>
                    </ul>
                </div>

            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-100 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-600 text-sm">
                © 2025 {{ config('app.name') }}. Conçu avec ❤️ à Evian-les-bains, pour les freelances.
            </p>
            <div class="flex items-center space-x-6 mt-4 md:mt-0">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <div class="h-2 w-2 bg-green-500 rounded-full"></div>
                    <span>Serveurs français</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <x-heroicon-o-shield-check class="h-4 w-4 text-green-600" />
                    <span>RGPD conforme</span>
                </div>
            </div>
        </div>
    </div>
</footer>
