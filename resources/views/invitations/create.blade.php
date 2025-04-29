<h2>Send Invitation</h2>

<form method="POST" action="{{ route('invitations.send') }}">
    @csrf
    <label>To:</label>
    <select name="receiver_id">
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <input type="hidden" name="team_id" value="1">

    <button type="submit">Send Invitation</button>
</form>
