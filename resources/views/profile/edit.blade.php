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
