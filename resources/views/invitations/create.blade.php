<h2>Send Invitation</h2>
@if (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<form method="POST" action="{{ route('invitations.send') }}">
    @csrf
    <label>To:</label>
    <select name="user_id" id="user_id" class="form-select w-full border rounded p-2">
        <option value="">-- Select User --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ isset($selectedUserId) && $selectedUserId == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </select>

    <input type="hidden" name="team_id" value="{{ $team->id }}">

    <button type="submit">Send Invitation</button>
</form>