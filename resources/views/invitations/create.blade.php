<h2>Send Invitation</h2>

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