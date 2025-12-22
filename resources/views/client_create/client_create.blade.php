@extends('layouts.app')
@section('title', 'Add New Client')
@section('content')
<div class="container-fluid client-create">

  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Dashboard</li>
      <li class="breadcrumb-item">Clients</li>
      <li class="breadcrumb-item active">Add Client</li>
    </ol>
  </nav>

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="page-title">Add New Client</h2>
      <p class="text-muted">
        Enter the details below to register a new client in the system.
      </p>
    </div>

    <div class="action-buttons">
      <a href="{{ route('admin.clients') }}" class="btn btn-light">Cancel</a>
      <button form="clientForm" class="btn btn-primary">Save Client</button>
    </div>
  </div>

  {{-- Form --}}
  <!-- trial, route can change later -->
  <!-- clients.create -->
  <form id="clientForm" method="POST" action="{{ route('clients.store') }}">
    @csrf

    <div class="card form-card">
      <div class="card-body">

        {{-- Client & Company --}}
        <h5 class="section-title">
          <i class="bi bi-building"></i>
          Client & Company Information
        </h5>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">
              Client Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="client_name" class="form-control" placeholder="e.g. Acme Corp">
          </div>

          <div class="col-md-6">
            <label class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" placeholder="Legal Entity Name">
          </div>
        </div>

        <hr>

        {{-- Contact Person --}}
        <h5 class="section-title">
          <i class="bi bi-person"></i>
          Contact Person Details
        </h5>

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Contact Person</label>
            <input type="text" name="contact_person" class="form-control" placeholder="Full Name">
          </div>
          <div class="col-md-4">
            <label class="form-label">Contact Person Email</label>
            <input type="email" name="contact_person_email" class="form-control" placeholder="contact@company.com">
          </div>
          <div class="col-md-4">
            <label class="form-label">Contact Person Phone</label>
            <input type="text" name="contact_person_phone" class="form-control" placeholder="+1 (555) 000-0000">
          </div>
        </div>

        <hr>

        {{-- Location --}}
        <h5 class="section-title">
          <i class="bi bi-geo-alt"></i>
          Location Details
        </h5>

        <div class="mb-3">
          <label class="form-label">Company Address</label>
          <input type="text" name="company_address" class="form-control" placeholder="Headquarters Address">
        </div>

        <div class="mb-3">
          <label class="form-label">Billing Address</label>
          <input type="text" name="billing_address" class="form-control"
            placeholder="Billing Street Address (if different)">
        </div>
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Country</label>
            <input type="text" name="country" class="form-control" placeholder="Country">
          </div>
          <div class="col-md-3">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control" placeholder="City">
          </div>
          <div class="col-md-3">
            <label class="form-label">State / Province</label>
            <input type="text" name="state_province" class="form-control" placeholder="State">
          </div>
          <div class="col-md-3">
            <label class="form-label">Zip / Postal Code</label>
            <input type="text" name="zip_postal_code" class="form-control" placeholder="Zip Code">
          </div>
        </div>

        <hr>

        {{-- Notes --}}
        <h5 class="section-title">
          <i class="bi bi-journal-text"></i>
          Additional Notes
        </h5>

        <div class="mb-3">
          <label class="form-label">Internal Notes</label>
          <textarea class="form-control" rows="4" name="internal_notes"
            placeholder="Enter any specific requirements or notes about this client..."></textarea>
        </div>

        {{-- Active --}}
        <div class="form-check form-switch">
          <input class="form-check-input" name="is_active" type="checkbox" checked>
          <label class="form-check-label">
            Mark Client as Active
          </label>
        </div>

      </div>

      {{-- Footer --}}
      <div class="card-footer d-flex justify-content-end gap-2">
        <a href="{{ route('admin.clients') }}" class="btn btn-light">Cancel</a>
        <button class="btn btn-primary">Save Client</button>
      </div>
    </div>
  </form>
</div>
@endsection