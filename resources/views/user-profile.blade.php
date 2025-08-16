@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
    <style>
        /* UserProfile Styles */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    color: #333;
  }

  .profile-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eaeaea;
  }

  .profile-header h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #222;
  }

  .profile-header p {
    font-size: 16px;
    color: #666;
  }

  .profile-sections {
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .profile-section {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 30px;
    margin-bottom: 20px;
  }

  .section-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #222;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
  }

  .section-description {
    margin-bottom: 25px;
    color: #666;
    font-size: 15px;
    line-height: 1.5;
  }

  /* Form Elements */
  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
  }

  .form-grid.three-columns {
    grid-template-columns: 1fr 1fr 1fr;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #444;
  }

  .form-input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.2s ease;
    background-color: #f9f9f9;
  }

  .form-input:focus {
    border-color: #3498db;
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
    outline: none;
  }

  .form-input::placeholder {
    color: #aaa;
  }

  .required {
    color: #e74c3c;
    margin-left: 4px;
  }

  /* Document Upload Styling */
  .documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
  }

  .document-upload-container {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    background-color: #fafafa;
    transition: all 0.2s ease;
  }

  .document-upload-container:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
  }

  .document-upload-container h4 {
    margin: 0 0 10px 0;
    font-size: 17px;
    font-weight: 600;
    color: #333;
  }

  .document-description {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
  }

  .document-dropzone {
    border: 2px dashed #ddd;
    border-radius: 6px;
    padding: 20px;
    text-align: center;
    background-color: #f7f9fc;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .document-dropzone:hover {
    border-color: #3498db;
    background-color: #f0f7fd;
  }

  .dropzone-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .dropzone-icon {
    font-size: 36px;
    margin-bottom: 10px;
    color: #97a2b0;
  }

  .dropzone-text {
    margin-bottom: 15px;
    color: #666;
    font-size: 14px;
  }

  .file-input {
    display: none;
  }

  .file-input-label {
    padding: 8px 16px;
    background-color: #3498db;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    font-size: 14px;
    font-weight: 500;
  }

  .file-input-label:hover {
    background-color: #2980b9;
  }

  .file-types {
    margin-top: 12px;
    font-size: 12px;
    color: #999;
  }

  /* Document Preview */
  .document-preview {
    position: relative;
    padding: 15px;
    background-color: #fff;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .doc-preview-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 12px;
  }

  .document-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .document-name {
    font-size: 14px;
    font-weight: 500;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .document-size {
    font-size: 12px;
    color: #888;
  }

  .btn-remove-doc {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(255, 255, 255, 0.8);
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 12px;
    color: #e74c3c;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-remove-doc:hover {
    background-color: #e74c3c;
    color: white;
    border-color: #e74c3c;
  }

  /* Verification Notes */
  .verification-notes {
    background-color: #f8f9fa;
    border-left: 4px solid #3498db;
    padding: 15px 20px;
    border-radius: 4px;
    margin-top: 25px;
  }

  .verification-notes h4 {
    margin: 0 0 10px 0;
    font-size: 16px;
    color: #333;
    font-weight: 600;
  }

  .verification-notes ul {
    margin: 0;
    padding-left: 20px;
  }

  .verification-notes li {
    margin-bottom: 8px;
    font-size: 14px;
    color: #555;
    line-height: 1.5;
  }

  /* Notification Preferences */
  .notification-options {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .notification-option {
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    transition: all 0.2s ease;
  }

  .notification-option:hover {
    background-color: #f0f7fd;
  }

  .toggle-label {
    display: flex;
    align-items: center;
    cursor: pointer;
  }

  .toggle-input {
    display: none;
  }

  .toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    background-color: #e0e0e0;
    border-radius: 13px;
    margin-right: 15px;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .toggle-switch:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: all 0.2s ease;
  }

  .toggle-input:checked + .toggle-switch {
    background-color: #2ecc71;
  }

  .toggle-input:checked + .toggle-switch:before {
    transform: translateX(24px);
  }

  .notification-info {
    display: flex;
    flex-direction: column;
  }

  .notification-name {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 4px;
  }

  .notification-description {
    font-size: 14px;
    color: #666;
  }

  /* Profile Actions */
  .profile-actions {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
    padding-top: 20px;
    margin-top: 30px;
    border-top: 1px solid #eaeaea;
  }

  .btn-primary {
    padding: 12px 24px;
    background-color: #3498db;
    color: white;
    border: none;
    margin-bottom: 50px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .btn-secondary {
    padding: 12px 24px;
    background-color: #f5f5f5;
    color: #333;
    margin-bottom: 50px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-secondary:hover {
    background-color: #e8e8e8;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .form-grid,
    .form-grid.three-columns {
      grid-template-columns: 1fr;
    }

    .documents-grid {
      grid-template-columns: 1fr;
    }

    .profile-section {
      padding: 20px;
    }

    .profile-actions {
      flex-direction: column;
    }

    .btn-primary,
    .btn-secondary {
      width: 100%;
    }
  }
    </style>

    <div class="profile-container">
        <div class="profile-header">
            <h2>My Profile</h2>
            <p>Manage your personal information and verification documents</p>
        </div>

        <div class="profile-sections">
            <!-- Personal Info Section -->
            <section class="profile-section">
                <h3 class="section-title">Personal Information</h3>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" class="form-input" name="firstName" value="John" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" class="form-input" name="lastName" value="Doe" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-input" name="email" value="john@example.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-input" name="phone" value="0712345678">
                        </div>
                    </div>
                </form>
            </section>

            <!-- Document Upload Section -->
            <section class="profile-section">
                <h3 class="section-title">Document Verification</h3>
                <p class="section-description">
                    Please upload the following documents to verify your identity.
                </p>

                <div class="documents-grid">
                    <!-- Driver's License -->
                    <div class="document-upload-container">
                        <h4>Driver's License / ID</h4>
                        <p class="document-description">Front side of your government-issued ID</p>
                        <input type="file" name="driverLicense" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <!-- Proof of Address -->
                    <div class="document-upload-container">
                        <h4>Proof of Address</h4>
                        <p class="document-description">Utility bill, bank statement, or lease agreement</p>
                        <input type="file" name="proofOfAddress" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <!-- Additional Document -->
                    <div class="document-upload-container">
                        <h4>Additional Document (Optional)</h4>
                        <p class="document-description">Insurance card, registration, or other verification</p>
                        <input type="file" name="additionalDoc" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
            </section>
        </div>

        <div class="profile-actions">
            <button type="submit" class="btn-primary">Save All Changes</button>
            <button type="button" class="btn-secondary">Cancel</button>
        </div>
    </div>
@endsection
