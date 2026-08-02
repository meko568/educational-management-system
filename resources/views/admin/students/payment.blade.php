<x-app-layout>
    <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 48rem; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start;" class="md:flex-row md:items-center">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin: 0;">Payment Details</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.875rem;">Manage subscription and payment status for {{ $student->name }}</p>
            </div>

            <a href="{{ route('admin.students.index', ['academicYear' => $student->academicYear]) }}"
               style="padding: 0.625rem 1.25rem; background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 0.75rem; font-size: 0.875rem; font-weight: 700; text-decoration: none;">
                {{ __('messages.back_to_list') }}
            </a>
        </div>

        <!-- Student Summary Card -->
        <div class="card-custom">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.name') }}</p>
                    <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0.25rem 0 0 0;">{{ $student->name }}</p>
                </div>
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.code') }}</p>
                    <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0.25rem 0 0 0; font-family: monospace;">{{ $student->code }}</p>
                </div>
                <div>
                    <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">{{ __('messages.academic_year') }}</p>
                    <p style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0.25rem 0 0 0;">{{ strtoupper(str_replace('_', ' ', $student->academicYear)) }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Status Card -->
        <div class="card-custom" style="display: flex; flex-direction: column; gap: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3rem; height: 3rem; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 3v2m3-2v2m3-2v2m3-2v2m3 13h1a2 2 0 002-2V9.5a2 2 0 00-2-2H5.5a2 2 0 00-2 2v10a2 2 0 002 2h1m6-13h2m-6 5h8m-8 3h8m-8 3h6" /></svg>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--text-main); margin: 0;">Current Payment Status</h3>
            </div>

            @if($latestPayment)
                @php
                    $paymentDate = $latestPayment->paid_at;
                    $expiryDate = $paymentDate->copy()->addMonth();
                    $now = now();
                    $isExpired = $now->greaterThan($expiryDate);
                    $daysRemaining = $now->diffInDays($expiryDate, false);
                @endphp

                <div style="padding: 2rem; border-radius: 1.5rem; border: 1px solid {{ $isExpired ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}; background-color: {{ $isExpired ? 'rgba(239, 68, 68, 0.05)' : 'rgba(16, 185, 129, 0.05)' }};">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                        <span style="padding: 0.375rem 1rem; border-radius: 0.625rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; background-color: {{ $isExpired ? '#ef4444' : '#10b981' }}; color: white;">
                            {{ $isExpired ? 'Expired' : 'Active' }}
                        </span>
                        <div style="text-align: right;">
                            <p style="font-size: 0.625rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Last Payment ({{ date('F Y', mktime(0,0,0, $latestPayment->month, 1, $latestPayment->year)) }})</p>
                            <p style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); margin: 0.125rem 0 0 0;">Recorded: {{ $paymentDate->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
                            Subscription valid until: <span style="font-weight: 700; color: var(--text-main);">{{ $expiryDate->format('F d, Y') }}</span>
                        </p>
                        @if(!$isExpired)
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                                <div style="flex: 1; height: 0.5rem; background-color: var(--bg-alt); border-radius: 9999px; overflow: hidden;">
                                    <div style="width: {{ max(0, min(100, ($daysRemaining / 30) * 100)) }}%; height: 100%; background-color: #10b981; border-radius: 9999px;"></div>
                                </div>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #10b981;">{{ $daysRemaining }} days left</span>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div style="padding: 3rem; border-radius: 1.5rem; border: 1px solid var(--border-color); background-color: var(--bg-alt); text-align: center;">
                    <div style="width: 3.5rem; height: 3.5rem; background-color: rgba(234, 88, 12, 0.1); color: #ea580c; border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto;">
                        <svg style="width: 1.75rem; height: 1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <p style="color: var(--text-main); font-weight: 700; margin: 0;">No payment record found</p>
                    <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0.5rem 0 0 0;">This student currently has no access to course materials.</p>
                </div>
            @endif

            @php
                $canRecordNew = !$latestPayment || $latestPayment->paid_at->copy()->addDays(20)->isPast();
            @endphp

            @if($canRecordNew)
                <div style="padding-top: 1rem;">
                    <form action="{{ route('admin.students.process-payment', $student) }}" method="POST">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 1rem; background-color: #b5501f; color: white; border: none; border-radius: 1rem; font-weight: 800; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2); display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Record New Payment ({{ now()->format('F Y') }})
                        </button>
                    </form>
                </div>
            @else
                <div style="text-align: center; padding: 1rem; background-color: var(--bg-alt); border-radius: 1rem;">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; font-weight: 700;">A payment for this month was recently recorded. You can record the next one in a few weeks.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
