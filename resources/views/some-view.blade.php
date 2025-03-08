// ...existing code...

@if(auth()->user()->hasAnyRole(['admin', 'doctor', 'patient']))
    <p>Welcome, {{ auth()->user()->getRoleNames()->first() }}!</p>
@endif

// ...existing code...
