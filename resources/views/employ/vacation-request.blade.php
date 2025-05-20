@extends('body.head')

@section('content')
    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-24">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Request Vacation</h2>

                <!-- Vacation Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-check text-blue-500 mr-2"></i>
                            <span class="font-medium text-gray-700">Total Vacation Days</span>
                        </div>
                        <p class="text-2xl font-bold text-blue-600">{{ $totalVacationDays }} days</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-clock text-green-500 mr-2"></i>
                            <span class="font-medium text-gray-700">Remaining Days</span>
                        </div>
                        <p class="text-2xl font-bold text-green-600">{{ $remainingVacationDays }} days</p>
                    </div>
                </div>

                <!-- Vacation Request Form -->
                <form id="vacationForm" class="space-y-6" action="{{ route('vacation-request.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" id="startDate" name="startDate"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required >
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" id="endDate" name="endDate"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>
                    </div>

                    <div>
                        <label for="vacationType" class="block text-sm font-medium text-gray-700 mb-1">Type of
                            Vacation</label>
                        <select id="vacationType" name="vacationType"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                            @foreach ($typeVacation as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (days)</label>
                        <input type="number" id="duration" name="duration"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            readonly>
                    </div> --}}

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <textarea id="reason" name="reason" rows="4"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Please provide a reason for your vacation request..." required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Requests -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Requests</h3>
                <div class="space-y-4" id="recentRequests">
                    <!-- Recent requests will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </main>

    {{-- <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('show');
        }

        function calculateDuration() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);

            if (startDate && endDate && startDate <= endDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('duration').value = diffDays;
            }
        }
    </script> --}}
    {{-- <script>
        // Sample data for recent requests
        const recentRequests = [{
                id: 1,
                startDate: "2024-04-15",
                endDate: "2024-04-17",
                duration: 3,
                reason: "Family trip",
                status: "approved"
            },
            {
                id: 2,
                startDate: "2024-05-01",
                endDate: "2024-05-05",
                duration: 5,
                reason: "Personal time off",
                status: "pending"
            }
        ];

        function renderRecentRequests() {
            const container = document.getElementById('recentRequests');
            container.innerHTML = '';

            recentRequests.forEach(request => {
                const statusColors = {
                    pending: 'bg-yellow-100 text-yellow-800',
                    approved: 'bg-green-100 text-green-800',
                    rejected: 'bg-red-100 text-red-800'
                };

                const card = document.createElement('div');
                card.className = 'border rounded-lg p-4';
                card.innerHTML = `
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-medium text-gray-800">${request.startDate} to ${request.endDate}</p>
                        <p class="text-sm text-gray-600">${request.duration} days</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm ${statusColors[request.status]}">
                        ${request.status}
                    </span>
                </div>
                <p class="text-gray-600">${request.reason}</p>
            `;
                container.appendChild(card);
            });
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderRecentRequests();

            // Form submission
            document.getElementById('vacationForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // In a real application, this would make an API call
                alert('Vacation request submitted successfully!');
                this.reset();
                document.getElementById('duration').value = '';
            });
        });
    </script> --}}
@endsection
