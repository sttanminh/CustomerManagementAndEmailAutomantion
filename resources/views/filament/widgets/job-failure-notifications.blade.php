<div class="p-4 bg-white shadow rounded-lg dark:bg-gray-800">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">📢 Job Failure Notifications</h3>
    
    @if(count($notifications) > 0)
        <ul class="mt-2 space-y-2">
            @foreach($notifications as $notification)
                <li class="p-2 rounded-lg 
                    bg-red-100 dark:bg-red-900 
                    text-red-700 dark:text-red-300">
                    
                    <strong class="text-red-600 dark:text-red-400">{{ $notification->data['title'] }}</strong>
                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                    <small class="text-gray-500 dark:text-gray-400">🕒 {{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 dark:text-gray-400">No job failure notifications.</p>
    @endif
</div>
