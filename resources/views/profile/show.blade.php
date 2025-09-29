@extends('layouts.dashboard')

@section('dashboard-content')
<div class="profile-page">
    <div class="page-header">
        <div class="header-icon"><i class="fas fa-user"></i></div>
        <div>
            <h1>My Profile</h1>
            <p>View your personal details and uploaded documents</p>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="form-section">
        <h3>Personal Information</h3>
        <ul>
            <li><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</li>
        </ul>
    </div>

    <!-- Verification Documents -->
    <div class="form-section">
        <h3>Verification Documents</h3>
        @if($verification)
            <ul>
                <li>
                    <strong>Driver License / ID:</strong>
                    @if($verification->driver_license)
                        <a href="{{ asset('storage/' . $verification->driver_license) }}" target="_blank">View</a>
                    @else N/A @endif
                </li>
                <li>
                    <strong>Proof of Address:</strong>
                    @if($verification->proof_of_address)
                        <a href="{{ asset('storage/' . $verification->proof_of_address) }}" target="_blank">View</a>
                    @else N/A @endif
                </li>
                <li>
                    <strong>National ID / Passport:</strong>
                    @if($verification->national_id)
                        <a href="{{ asset('storage/' . $verification->national_id) }}" target="_blank">View</a>
                    @else N/A @endif
                </li>
                <li>
                    <strong>Profile Photo:</strong>
                    @if($verification->photo)
                        <img src="{{ asset('storage/' . $verification->photo) }}" width="120">
                    @else N/A @endif
                </li>
                <li>
                    <strong>Verification Video:</strong>
                    @if($verification->verification_video)
                        <video width="320" controls>
                            <source src="{{ asset('storage/' . $verification->verification_video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else N/A @endif
                </li>
                <li>
                    <strong>Additional Documents:</strong>
                    @if($verification->additional_docs)
                        @foreach(json_decode($verification->additional_docs, true) as $doc)
                            <div>
                                <a href="{{ asset('storage/' . $doc) }}" target="_blank">View File</a>
                            </div>
                        @endforeach
                    @else N/A @endif
                </li>
            </ul>
        @else
            <p>No documents uploaded yet.</p>
        @endif
    </div>

    <!-- Edit Button -->
    <div class="form-actions">
        <a href="{{ route('profile.edit') }}" class="btn primary">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
    </div>
</div>
<style>/* Profile Page Styling */
.profile-page {
    background: #fff8f0;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

/* Header */
.page-header {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid #ffd54f;
    padding-bottom: 1rem;
}
.page-header .header-icon {
    background: #d32f2f; /* red */
    color: #fff;
    font-size: 1.5rem;
    border-radius: 50%;
    padding: 1rem;
    margin-right: 1rem;
}
.page-header h1 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
    color: #d32f2f;
}
.page-header p {
    margin: 0;
    color: #666;
    font-size: 0.95rem;
}

/* Sections */
.form-section {
    margin-bottom: 2rem;
    background: #fff;
    padding: 1.2rem;
    border-radius: 12px;
    border-left: 6px solid #ffd54f; /* yellow accent */
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.form-section h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #d32f2f;
}
.form-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.form-section li {
    padding: 0.7rem 0;
    border-bottom: 1px solid #f2f2f2;
    font-size: 0.95rem;
}
.form-section li strong {
    color: #111;
}

/* Uploaded documents */
.form-section a {
    color: #d32f2f;
    text-decoration: none;
    font-weight: 500;
}
.form-section a:hover {
    text-decoration: underline;
}
.form-section img,
.form-section video {
    display: block;
    margin-top: 0.5rem;
    border-radius: 10px;
    border: 2px solid #ffd54f; /* yellow border */
}

/* Actions */
.form-actions {
    text-align: right;
    margin-top: 2rem;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.3rem;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    text-decoration: none;
}
.btn.primary {
    background: #d32f2f; /* red */
    color: #fff;
}
.btn.primary:hover {
    background: #b71c1c; /* darker red */
}
.btn i {
    font-size: 1rem;
}
</style>
@endsection
