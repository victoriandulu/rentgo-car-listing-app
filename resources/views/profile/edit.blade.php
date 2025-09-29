@extends('layouts.dashboard')
@section('dashboard-content')
<div class="profile-page">
    <div class="page-header">
        <div class="header-icon">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h1>My Profile</h1>
            <p>Manage your personal information and verification documents</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Personal Information -->
        <div class="form-section">
            <div class="section-header">
                <i class="fas fa-user-edit"></i>
                <h3>Personal Information</h3>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="form-section">
            <div class="section-header">
                <i class="fas fa-file-shield"></i>
                <h3>Document Verification</h3>
            </div>
            <div class="upload-grid">

                <!-- Driver License -->
                <div class="upload-item">
                    <h4>Driver's License / ID</h4>
                    <input type="file" name="driver_license" accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <!-- Proof of Address -->
                <div class="upload-item">
                    <h4>Proof of Address</h4>
                    <input type="file" name="proof_of_address" accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <!-- Additional Documents (Multiple) -->
                <div class="upload-item">
                    <h4>Additional Documents</h4>
                    <input type="file" name="additional_docs[]" multiple accept=".pdf,.jpg,.jpeg,.png">
                    @if(auth()->user()->additional_docs)
                        <ul>
                            @foreach(json_decode(auth()->user()->additional_docs, true) as $doc)
                                <li>{{ basename($doc) }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- National ID -->
                <div class="upload-item">
                    <h4>National ID / Passport</h4>
                    <input type="file" name="national_id" accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <!-- Photo -->
                <div class="upload-item">
                    <h4>Profile Photo</h4>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png">
                </div>

                <!-- Video -->
                <div class="upload-item">
                    <h4>Verification Video</h4>
                    <input type="file" name="verification_video" accept=".mp4,.mov,.avi">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn primary"><i class="fas fa-save"></i> Save Changes</button>
            <a href="{{ url()->previous() }}" class="btn secondary"><i class="fas fa-arrow-left"></i> Cancel</a>
        </div>
    </form>
</div>
<style>
.profile-page {
    font-family: 'Inter', sans-serif;
}

.page-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--rentgo-light-red);
}

.header-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--rentgo-red);
    margin-bottom: 0.5rem;
}

.page-header p {
    color: var(--rentgo-dark);
    opacity: 0.8;
}

.alert {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.alert.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 15px;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.section-header i {
    color: var(--rentgo-red);
    font-size: 1.2rem;
}

.section-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--rentgo-red);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    color: var(--rentgo-dark);
    margin-bottom: 0.5rem;
}

.form-group input {
    padding: 0.75rem;
    border: 2px solid var(--rentgo-light-red);
    border-radius: 8px;
    transition: var(--transition);
}

.form-group input:focus {
    outline: none;
    border-color: var(--rentgo-red);
    box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
}

.error-text {
    color: var(--rentgo-red);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.upload-grid {
    display: grid;
    gap: 1rem;
}

.upload-item {
    border: 2px dashed var(--rentgo-light-red);
    border-radius: 10px;
    padding: 1rem;
}

.upload-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.upload-info i {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--rentgo-red);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.upload-info h4 {
    font-weight: 600;
    color: var(--rentgo-red);
    margin-bottom: 0.25rem;
}

.upload-info p {
    font-size: 0.875rem;
    color: var(--rentgo-dark);
    opacity: 0.7;
}

.file-uploaded {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #155724;
    background: #d4edda;
    padding: 0.5rem;
    border-radius: 5px;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.upload-item input[type="file"] {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--rentgo-light-red);
    border-radius: 5px;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: var(--transition);
    border: none;
}

.btn.primary {
    background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
    color: white;
}

.btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-soft);
}

.btn.secondary {
    background: white;
    color: var(--rentgo-dark);
    border: 2px solid var(--rentgo-light-red);
}

.btn.secondary:hover {
    background: var(--rentgo-light-red);
    text-decoration: none;
    color: var(--rentgo-dark);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }
}

</style>


@endsection
