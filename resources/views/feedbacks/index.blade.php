@extends('layouts.app')

@section('title', 'Manage Feedback')

@section('content')
<div class="container py-5">
    <!-- Header Section with Gradient Background -->
    <div class="card border-0 shadow-lg rounded-lg overflow-hidden mb-5">
        <div class="card-header p-0">
            <div class="bg-gradient-to-r from-indigo-700 to-purple-600" style="background: linear-gradient(to right, #4f46e5, #6366f1);">
                <div class="d-flex justify-content-between align-items-center py-4 px-4">
                    <div>
                        <h2 class="mb-0 fw-bold text-white">Feedback for Teams</h2>
                        <p class="text-white-50 mb-0">Evaluate team performance and collaboration</p>
                    </div>
                    <a href="{{ route('feedbacks.received') }}" class="btn btn-light d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#4f46e5" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
                        </svg>
                        <span style="color: #4f46e5; font-weight: 500;">View Feedback I Received</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($allTeams->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="rounded-circle mx-auto d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; background-color: #f3f4f6;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#9ca3af" class="bi bi-people" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                            </svg>
                        </div>
                    </div>
                    <h5 class="fw-bold text-gray-700 mb-2">No Teams Yet</h5>
                    <p class="text-muted px-4 mx-auto" style="max-width: 500px;">You haven’t joined any teams yet. Once you join a team, you’ll be able to provide feedback.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                <th class="py-3 px-4 text-dark fw-semibold">Team</th>
                                <th class="py-3 px-4 text-dark fw-semibold">Competition</th>
                                <th class="py-3 px-4 text-dark fw-semibold">Feedback Status</th>
                                <th class="py-3 px-4 text-dark fw-semibold text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allTeams as $team)
                                <tr class="border-bottom" style="border-color: #f3f4f6;">
                                    <!-- Team Column -->
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background-color: #4f46e5; color: white; font-weight: 600;">
                                                {{ substr($team->name, 0, 1) }}
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-semibold">{{ $team->name }}</h6>
                                                <span class="text-muted small">
                                                    @if($team->status_team == 'active')
                                                        <span class="text-success">● Active</span>
                                                    @elseif($team->status_team == 'finished')
                                                        <span class="text-primary">● Completed</span>
                                                    @else
                                                        <span class="text-secondary">● {{ ucfirst($team->status_team) }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Competition Column -->
                                    <td class="py-3 px-4">
                                        @if($team->competition_name)
                                            <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#4f46e5" class="bi bi-trophy" viewBox="0 0 16 16">
                                                    <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
                                                </svg>
                                                <span class="ms-2">{{ $team->competition_name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Feedback Status Column -->
                                    <td class="py-3 px-4">
                                        @if($team->status_team !== 'finished')
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill text-bg-light border px-3 py-2 d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                                    </svg>
                                                    <span class="ms-1 small fw-medium">Team not yet completed</span>
                                                </div>
                                            </div>
                                        @elseif(in_array($team->id, $givenFeedback))
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill px-3 py-2 d-flex align-items-center" style="background-color: #ecfdf5; color: #047857; border: 1px solid #d1fae5;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                    </svg>
                                                    <span class="ms-1 small fw-medium">Feedback provided</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill px-3 py-2 d-flex align-items-center" style="background-color: #fff1f2; color: #be123c; border: 1px solid #ffe4e6;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                                    </svg>
                                                    <span class="ms-1 small fw-medium">Feedback not yet provided</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Action Column -->
                                    <td class="py-3 px-4 text-end">
                                        @if($team->status_team !== 'finished')
                                            <button disabled class="btn btn-sm px-3" style="background-color: #f3f4f6; color: #9ca3af;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill me-1" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                                </svg>
                                                Not Available
                                            </button>
                                        @elseif(in_array($team->id, $givenFeedback))
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('feedbacks.edit', ['team_id' => $team->id]) }}" class="btn btn-sm px-3" style="background-color: #fffbeb; color: #d97706; border: 1px solid #fef3c7;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill me-1" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('feedbacks.destroyByTeam', ['team_id' => $team->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the feedback?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm px-3" style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fee2e2;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill me-1" viewBox="0 0 16 16">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <a href="{{ route('feedbacks.create', ['team_id' => $team->id]) }}" class="btn btn-sm px-3" style="background-color: #4f46e5; color: white;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-text-fill me-1" viewBox="0 0 16 16">
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.5a1 1 0 0 0-.8.4l-1.9 2.533a1 1 0 0 1-1.6 0L5.3 12.4a1 1 0 0 0-.8-.4H2a2 2 0 0 1-2-2V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
                                                </svg>
                                                Give Feedback
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection