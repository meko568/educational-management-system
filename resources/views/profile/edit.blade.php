<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 56rem; margin: 0 auto;">

        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2;">
                {{ __('messages.profile_information') }}
            </h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
                Review your institutional identity and contact details
            </p>
        </div>

        <!-- Identity Details Card -->
        <div class="card-custom" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; {{ app()->getLocale() === 'ar' ? 'left: 0;' : 'right: 0;' }} padding: 2rem; opacity: 0.05;">
                <svg style="width: 6rem; height: 6rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>

            <div style="position: relative; z-index: 10;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
                    <div style="width: 3.5rem; height: 3.5rem; background-color: rgba(79, 70, 229, 0.1); color: #b5501f; border-radius: 1rem; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(79, 70, 229, 0.2);">
                        <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin: 0;">{{ __('messages.identity_details') }}</h3>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Institutional Grade Profile</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2.5rem;">
                    <!-- Name -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.name') }}</p>
                        <p style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ Auth::user()->name }}</p>
                    </div>

                    <!-- Role -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.system_role') }}</p>
                        <div style="display: flex;">
                            <span style="padding: 0.375rem 1rem; background-color: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 0.75rem; font-weight: 800; border-radius: 0.625rem; text-transform: uppercase; border: 1px solid rgba(16, 185, 129, 0.2);">
                                {{ strtoupper(Auth::user()->role ?? 'User') }}
                            </span>
                        </div>
                    </div>

                    <!-- Code -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.code') }}</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <p style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0; font-family: monospace;">{{ Auth::user()->code }}</p>
                            <div style="padding: 0.25rem 0.5rem; background-color: var(--bg-alt); border: 1px solid var(--border-color); border-radius: 0.375rem; font-size: 0.625rem; font-weight: 800; color: var(--text-muted);">PRIMARY ID</div>
                        </div>
                    </div>

                    <!-- Academic Year -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.academic_year') }}</p>
                        <p style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ strtoupper(str_replace('_', ' ', Auth::user()->academicYear ?? 'N/A')) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Preferences (Small Screens Only) -->
        <div class="sm:hidden card-custom">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                <div style="width: 3rem; height: 3rem; background-color: var(--bg-alt); color: var(--text-main); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);">
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0;">{{ __('messages.theme') }} & {{ __('messages.language') }}</h3>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; text-transform: uppercase;">Personalize your experience</p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Appearance Toggle -->
                <div x-data="{
                    mode: localStorage.getItem('mode') || 'light',
                    toggle() {
                        this.mode = this.mode === 'light' ? 'dark' : 'light';
                        localStorage.setItem('mode', this.mode);
                        if (this.mode === 'dark') document.documentElement.classList.add('dark');
                        else document.documentElement.classList.remove('dark');
                    }
                }" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background-color: var(--bg-alt); border-radius: 1rem; border: 1px solid var(--border-color);">
                    <div style="display: flex; items-center gap: 0.75rem;">
                        <svg x-show="mode === 'dark'" style="width: 1.25rem; height: 1.25rem; color: var(--accent-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728L5.99 5.99" /></svg>
                        <svg x-show="mode === 'light'" style="width: 1.25rem; height: 1.25rem; color: var(--accent-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.theme') }}</span>
                    </div>
                    <button @click="toggle()" class="px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-widest transition-all" style="background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main);">
                        <span x-text="mode === 'light' ? '{{ __('messages.theme_dark') }}' : '{{ __('messages.theme_light') }}'"></span>
                    </button>
                </div>

                <!-- Language Switcher -->
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background-color: var(--bg-alt); border-radius: 1rem; border: 1px solid var(--border-color);">
                    <div style="display: flex; items-center gap: 0.75rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: var(--accent-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /></svg>
                        <span style="font-size: 0.875rem; font-weight: 700; color: var(--text-main);">{{ __('messages.language') }}</span>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase {{ app()->getLocale() === 'en' ? '' : 'opacity-50' }}" style="{{ app()->getLocale() === 'en' ? 'background-color: var(--accent-color); color: white;' : 'background-color: var(--bg-card); color: var(--text-muted);' }}">EN</a>
                        <a href="{{ route('lang.switch', 'ar') }}" class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase {{ app()->getLocale() === 'ar' ? '' : 'opacity-50' }}" style="{{ app()->getLocale() === 'ar' ? 'background-color: var(--accent-color); color: white;' : 'background-color: var(--bg-card); color: var(--text-muted);' }}">AR</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information Card -->
        <div class="card-custom">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
                <div style="width: 3.5rem; height: 3.5rem; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 1rem; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin: 0;">{{ __('messages.contact_information') }}</h3>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Security & Communication Handles</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2.5rem;">
                <!-- Phone -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.phone_number') }}</p>
                    <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ Auth::user()->phone ?? '---' }}</p>
                </div>

                <!-- Parent Phone -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.parents_phone_number') }}</p>
                    <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ Auth::user()->parent_phone ?? '---' }}</p>
                </div>

                <!-- Last Update -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Record Verified</p>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 0.5rem; height: 0.5rem; background-color: #10b981; border-radius: 9999px;"></span>
                        <p style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0;">{{ Auth::user()->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lock Notice -->
        <div style="background-color: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.1); border-radius: 1.5rem; padding: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <div>
                <h4 style="font-size: 0.875rem; font-weight: 800; color: #92400e; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Security Protocol Active</h4>
                <p style="font-size: 0.875rem; color: #b45309; margin: 0.25rem 0 0 0; line-height: 1.5;">
                    {{ __('messages.profile_lock_notice') }}
                </p>
            </div>
        </div>

    </div>
</x-app-layout>
