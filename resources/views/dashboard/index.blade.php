@extends('body.head')

@section('content')


    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-24">
        <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8 card-hover border-t-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-4">
                    <i class="fas fa-user-circle text-2xl text-blue-500 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                </div>
                <p class="text-gray-600">Here's your attendance overview for today.</p>
            </div>
            <div class="hidden md:block">
                <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>
    </div>
        <!-- Fingerprint Section -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8 text-center card-hover">
            <div class="max-w-md mx-auto">
                <i class="fas fa-fingerprint text-5xl text-blue-500 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Fingerprint Authentication</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-center">
                        <span class="text-gray-600 mr-2">Device ID:</span>
                        <span id="deviceId" class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">Loading...</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <span class="text-gray-600 mr-2">Status:</span>
                        <span id="verificationStatus" class="px-2 py-1 rounded-full text-xs font-medium">
                            <span class="inline-block w-2 h-2 rounded-full bg-yellow-500 mr-1"></span>
                            Verifying...
                        </span>
                    </div>
                </div>
                <button onclick="scanFingerprint()" class="mt-6 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-fingerprint mr-2"></i>Scan Fingerprint
                </button>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <!-- Attendance Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-green-500">
                <div class="flex items-center mb-4">
                    <i class="fas fa-calendar-check text-2xl text-green-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Employee Attendance</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Present</span>
                        <span class="font-bold text-green-600 text-lg">{{ $presentDays ?? 0 }} days</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Late</span>
                        <span class="font-bold text-yellow-600 text-lg">{{ $lateDays ?? 0 }} days</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Absent</span>
                        <span class="font-bold text-red-600 text-lg">{{ $absentDays ?? 0 }} days</span>
                    </div>
                </div>
            </div>

            <!-- Vacations Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-blue-500">
                <div class="flex items-center mb-4">
                    <i class="fas fa-umbrella-beach text-2xl text-blue-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Remaining Vacations</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Used</span>
                        <span class="font-bold text-red-600 text-lg">{{ $usedVacationDays ?? 0 }} days</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Remaining</span>
                        <span class="font-bold text-green-600 text-lg">{{ $remainingVacationDays ?? 0 }} days</span>
                    </div>
                </div>
            </div>

            <!-- Total Vacation Days Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-t-4 border-purple-500">
                <div class="flex items-center mb-4">
                    <i class="fas fa-clock text-2xl text-purple-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Total Vacation Days</h3>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-bold text-purple-600">{{ $totalVacationDays ?? 30 }}</p>
                    <p class="text-gray-500 mt-2">days/year</p>
                </div>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center mb-6">
                <i class="fas fa-history text-2xl text-blue-500 mr-3"></i>
                <h2 class="text-2xl font-bold text-gray-800">Recent Attendance</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(isset($recentAttendance) && $recentAttendance->count() > 0)
                            @foreach($recentAttendance as $attendance)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                        {{-- <span>{{ $attendance->date->format('Y-m-d') }}</span> --}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-sign-in-alt text-blue-500 mr-2"></i>
                                        <span>{{ $attendance->check_in }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-sign-out-alt text-blue-500 mr-2"></i>
                                        <span>{{ $attendance->check_out }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->status == 'present')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Present</span>
                                    @elseif($attendance->status == 'late')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Late</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Absent</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No attendance records found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('show');
        }

        async function scanFingerprint() {
            try {
                const button = document.querySelector('button[onclick="scanFingerprint()"]');
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Scanning...';

                // Initialize FingerprintJS
                const fp = await FingerprintJS.load();
                const result = await fp.get();
                const visitorId = result.visitorId;

                // Update UI with device ID
                document.getElementById('deviceId').textContent = visitorId;

                // Send fingerprint to server
                const response = await fetch('/api/verify-device', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        fingerprint: visitorId,
                        device_info: result.components
                    })
                });

                const data = await response.json();

                // Update verification status
                const statusElement = document.getElementById('verificationStatus');
                if (data.verified) {
                    statusElement.innerHTML = '<span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1"></span> Verified';
                    statusElement.classList.add('bg-green-100', 'text-green-800');
                } else {
                    statusElement.innerHTML = '<span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-1"></span> Not Verified';
                    statusElement.classList.add('bg-red-100', 'text-red-800');
                }

                button.disabled = false;
                button.innerHTML = '<i class="fas fa-fingerprint mr-2"></i>Scan Fingerprint';
            } catch (error) {
                console.error('Fingerprint scanning failed:', error);
                document.getElementById('verificationStatus').innerHTML =
                    '<span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-1"></span> Scanning Failed';
            }
        }
    </script>

    <script>
        async function scanFingerprint() {
            const fp = await FingerprintJS.load();
            const result = await fp.get();
            const deviceId = result.visitorId;

            document.getElementById('deviceId').textContent = deviceId;
            document.getElementById('verificationStatus').innerHTML = `
                <span class="inline-block w-2 h-2 rounded-full bg-yellow-500 mr-1"></span>Submitting...`;

            try {
                const response = await fetch("{{ route('fingerprint.attendance') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ device_id: deviceId })
                });

                const data = await response.json();
                document.getElementById('verificationStatus').innerHTML = `
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1"></span>${data.message}`;
            } catch (error) {
                document.getElementById('verificationStatus').innerHTML = `
                    <span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-1"></span>Error occurred`;
            }
        }
        </script>


@endsection