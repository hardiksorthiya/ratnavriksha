@extends('backend.layout.app')

@section('title', 'Contact Enquiries')
@section('page_heading', 'Contact Enquiries')

@section('content')
    <div class="dash-card mb-4">
        <h2 class="dash-title mb-1">Contact Enquiries</h2>
        <p class="dash-subtitle mb-0">Messages submitted from the contact page form</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card panel-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiries as $enquiry)
                            <tr>
                                <td>{{ $enquiries->firstItem() + $loop->index }}</td>
                                <td class="text-nowrap">
                                    {{ $enquiry->created_at->format('d M Y') }}<br>
                                    <span class="text-muted-small">{{ $enquiry->created_at->format('h:i A') }}</span>
                                </td>
                                <td>{{ $enquiry->name }}</td>
                                <td>
                                    @if ($enquiry->email)
                                        <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($enquiry->phone)
                                        <a href="tel:{{ preg_replace('/\s+/', '', $enquiry->phone) }}">{{ $enquiry->phone }}</a>
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>{{ $enquiry->subject ?? '—' }}</td>
                                <td title="{{ $enquiry->comment }}">
                                    {{ $enquiry->comment ? \Illuminate\Support\Str::limit($enquiry->comment, 60) : '—' }}
                                </td>
                                <td>
                                    <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Delete this enquiry?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted-small">No contact enquiries yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($enquiries->hasPages())
            <div class="card-footer">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>
@endsection
