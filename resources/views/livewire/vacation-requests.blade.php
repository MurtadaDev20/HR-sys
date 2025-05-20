<div>
<div class="pt-24 container mx-auto px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-8">Vacation Approval Requests</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <input wire:model="search" type="text" placeholder="Search requests..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300" />
        <div class="flex space-x-2 justify-end">
            <button wire:click="$set('filter', 'all')" class="px-4 py-2 border rounded-lg {{ $filter === 'all' ? 'bg-blue-500 text-white' : 'text-blue-500 border-blue-500' }}">All</button>
            <button wire:click="$set('filter', 'pending')" class="px-4 py-2 border rounded-lg {{ $filter === 'pending' ? 'bg-yellow-500 text-white' : 'text-yellow-500 border-yellow-500' }}">Pending</button>
            <button wire:click="$set('filter', 'approved')" class="px-4 py-2 border rounded-lg {{ $filter === 'approved' ? 'bg-green-500 text-white' : 'text-green-500 border-green-500' }}">Approved</button>
            <button wire:click="$set('filter', 'rejected')" class="px-4 py-2 border rounded-lg {{ $filter === 'rejected' ? 'bg-red-500 text-white' : 'text-red-500 border-red-500' }}">Rejected</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($this->filteredRequests as $request)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">{{ $request['employeeName'] }}</h3>
                    <span class="text-sm {{ [
                        'pending' => 'text-yellow-500',
                        'approved' => 'text-green-500',
                        'rejected' => 'text-red-500'
                    ][$request['status']] }}">
                        {{ ucfirst($request['status']) }}
                    </span>
                </div>
                <p class="text-gray-600"><span class="font-medium">Department:</span> {{ $request['department'] }}</p>
                <p class="text-gray-600"><span class="font-medium">Duration:</span> {{ $request['duration'] }} days</p>
                <button wire:click="show({{ $request['id'] }})" class="mt-4 w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">View Details</button>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    @if($showModal )
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Vacation Request Details</h3>
                    <button wire:click="close" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
                </div>
                <div class="space-y-4 text-gray-800">
                    <p><span class="font-medium">Name:</span> {{ $selectedRequest['employeeName'] }}</p>
                    <p><span class="font-medium">Department:</span> {{ $selectedRequest['department'] }}</p>
                    <p><span class="font-medium">Start Date:</span> {{ $selectedRequest['startDate'] }}</p>
                    <p><span class="font-medium">End Date:</span> {{ $selectedRequest['endDate'] }}</p>
                    <p><span class="font-medium">Duration:</span> {{ $selectedRequest['duration'] }} days</p>
                    <p><span class="font-medium">Reason:</span> {{ $selectedRequest['reason'] }}</p>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <button wire:click="reject" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Reject</button>
                    <button wire:click="approve" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Approve</button>
                </div>
            </div>
        </div>
    @endif
</div>
</div>