@extends('Doctor.Layouts.layout')

@section('meta_title')
Chromo Xpert | Doctor Dashboard
@endsection

@section('css')


<style>
    :root {
        --primary-color: #2c3e50; /* Dark blue for headers and accents */
        --secondary-color: #3498db; /* Bright blue for buttons and highlights */
        --success-color: #27ae60; /* Green for approved status */
        --warning-color: #f1c40f; /* Yellow for pending status */
        --danger-color: #e74c3c; /* Red for rejected status */
        --background-color: #ecf0f1; /* Light background */
        --card-background: #ffffff; /* White card background */
        --text-color: #34495e; /* Dark text for readability */
        --muted-color: #7f8c8d; /* Muted text for secondary info */
        --sidebar-width: 250px;
        --purple-sidebar: #9c27b0; /* Purple for sidebar */
    }

    body {
        background: var(--background-color);
        font-family: 'Roboto', sans-serif;
        color: var(--text-color);
        line-height: 1.6;
        overflow-x: hidden;
    }

    /* Assume standard layout structure: .wrapper > .sidebar + .main-panel > .content */
    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: var(--sidebar-width);
        background: var(--purple-sidebar);
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1000;
        transition: transform 0.3s ease-in-out;
        overflow-y: auto;
    }

    .main-panel {
        flex: 1;
        margin-left: var(--sidebar-width);
        transition: margin-left 0.3s ease-in-out;
    }

    .content-page {
        padding: 1rem;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;
    }

    /* Header in main-panel */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .navbar-toggler {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--primary-color);
        cursor: pointer;
    }

    h1 {
        font-size: clamp(1.75rem, 5vw, 2.25rem);
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    p.subtitle {
        color: var(--muted-color);
        font-size: clamp(0.95rem, 2.5vw, 1.1rem);
        margin-bottom: 2rem;
    }

    h4 {
        font-size: clamp(1.25rem, 4vw, 1.5rem);
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
    }

    .report-card {
        background: var(--card-background);
        border-radius: 0.75rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        break-inside: avoid;
        height: 100%;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .stats-card {
        background: var(--card-background);
        border-radius: 0.75rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .stats-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .stats-count {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }

    .stats-pending .stats-icon,
    .stats-pending .stats-title,
    .stats-pending .stats-count {
        color: var(--warning-color);
    }

    .stats-approved .stats-icon,
    .stats-approved .stats-title,
    .stats-approved .stats-count {
        color: var(--success-color);
    }

    .stats-rejected .stats-icon,
    .stats-rejected .stats-title,
    .stats-rejected .stats-count {
        color: var(--danger-color);
    }

    .patient-name {
        color: var(--secondary-color);
        font-weight: 700;
        font-size: clamp(1.1rem, 3vw, 1.2rem);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .report-meta {
        font-size: 0.95rem;
        color: var(--muted-color);
        margin-bottom: 1rem;
    }

    .report-meta span {
        display: block;
        margin-bottom: 0.25rem;
    }

    .report-details {
        border-top: 1px solid #e5e7eb;
        padding-top: 1rem;
        margin-bottom: 1rem;
    }

    .report-details ul {
        padding-left: 1.25rem;
        margin: 0;
        list-style-type: disc;
    }

    .report-details li {
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        word-break: break-word;
    }

    .status-pending {
        color: var(--warning-color);
        font-weight: 600;
    }

    .status-approved {
        color: var(--success-color);
        font-weight: 600;
    }

    .status-rejected {
        color: var(--danger-color);
        font-weight: 600;
    }

    .priority-low {
        color: var(--success-color);
        font-weight: 600;
    }

    .priority-medium {
        color: var(--warning-color);
        font-weight: 600;
    }

    .priority-high {
        color: var(--danger-color);
        font-weight: 600;
    }

    .action-row {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        border: none;
        min-height: 44px; /* Better touch target */
        flex: 1;
        min-width: 80px;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-view {
        color: var(--secondary-color);
        background: transparent;
        text-decoration: underline;
        min-height: auto;
        flex: none;
        padding: 0.25rem 0.5rem;
    }

    .btn-view:hover {
        color: #2980b9;
    }

    .btn-approve {
        background-color: var(--success-color);
        color: #fff;
    }

    .btn-approve:hover {
        background-color: #219653;
        transform: translateY(-2px);
    }

    .btn-sign {
        background-color: #f1c40f;
        color: #fff;
    }

    .btn-sign:hover {
        background-color: #d4ac0d;
        transform: translateY(-2px);
    }

    .btn-reject {
        background-color: var(--danger-color);
        color: #fff;
    }

    .btn-reject:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 1rem;
        box-sizing: border-box;
    }

    .modal-content {
        background: var(--card-background);
        padding: 1.5rem;
        border-radius: 0.75rem;
        max-width: min(500px, 90vw);
        width: 100%;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--muted-color);
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rejection-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .rejection-form label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .rejection-form textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        resize: vertical;
        min-height: 100px;
        box-sizing: border-box;
    }

    .rejection-form textarea:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    /* Search and Filter Styles */
    .search-filter-container {
        background: var(--card-background);
        border-radius: 0.75rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        z-index: 1;
        position: relative;
    }

    .search-filter-row {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .search-filter-row {
            flex-direction: row;
            align-items: end;
        }
    }

    .search-box {
        flex: 1;
        position: relative;
        min-width: 0; /* Prevents flex item overflow */
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted-color);
        z-index: 1;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        color: var(--text-color);
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .filter-select {
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        color: var(--text-color);
        background-color: white;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%237f8c8d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px;
        flex: 1;
        min-width: 120px;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    /* Tabs Styles */
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }

    .nav-tabs .nav-link {
        color: var(--text-color);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: var(--secondary-color);
        border-bottom-color: var(--secondary-color);
    }

    .nav-tabs .nav-link.active {
        color: var(--secondary-color);
        border-bottom-color: var(--secondary-color);
    }

    .badge {
        font-size: 0.8rem;
        margin-left: 0.5rem;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 2rem;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .pagination-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.3rem;
        background-color: white;
        color: var(--text-color);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination-btn:hover:not(:disabled) {
        background-color: #f8f9fa;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-pages {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .page-number {
        min-width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 0.3rem;
        background-color: white;
        color: var(--text-color);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .page-number:hover {
        background-color: #f8f9fa;
    }

    .page-number.active {
        background-color: var(--secondary-color);
        color: white;
        border-color: var(--secondary-color);
    }

    .no-results {
        text-align: center;
        padding: 2rem;
        background: var(--card-background);
        border-radius: 0.75rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .no-results-icon {
        font-size: 3rem;
        color: #e5e7eb;
        margin-bottom: 1rem;
    }

    /* Enhanced Responsive Design */
    @media (max-width: 480px) {
        .content-page {
            padding: 0.5rem;
        }
        
        .search-filter-container {
            padding: 1rem;
        }
        
        .report-card, .stats-card {
            padding: 1rem;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .filter-select {
            flex: 1 1 100%;
            min-width: 100%;
        }
        
        .action-row {
            gap: 0.5rem;
            flex-direction: column;
        }
        
        .btn {
            padding: 0.75rem 1rem;
            font-size: 1rem;
            min-height: 48px;
            width: 100%;
        }
        
        .btn-view {
            width: 100%;
            justify-content: center;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
        }
        
        .pagination-container {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .pagination-pages {
            order: -1;
            width: 100%;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .pagination-btn {
            width: 100%;
            max-width: 200px;
            justify-content: center;
        }
        
        .page-number {
            min-width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .stats-card {
            padding: 1.5rem 1rem;
        }

        .stats-icon {
            font-size: 2.5rem;
        }

        .stats-count {
            font-size: 2rem;
        }

        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .navbar-toggler {
            display: block;
        }
        
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.open {
            transform: translateX(0);
        }
        
        .main-panel {
            margin-left: 0 !important;
        }
        
        .search-filter-row {
            gap: 0.75rem;
        }
        
        .action-row {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn {
            flex: none;
            width: 100%;
        }
        
        .btn-view {
            flex: none;
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
        }
        
        .modal-content {
            margin: 0.5rem;
            padding: 1rem;
            max-width: 95vw;
        }
        
        .page-header {
            justify-content: space-between;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .action-row {
            justify-content: space-between;
        }
        
        .btn {
            flex: 1;
            min-width: auto;
        }
        
        .btn-view {
            flex: none;
        }
    }

    /* Print styles */
    @media print {
        .search-filter-container,
        .action-row,
        .pagination-container,
        .sidebar,
        .nav-tabs {
            display: none;
        }
        
        .report-card, .stats-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ddd;
        }
        
        .main-panel {
            margin-left: 0;
        }

        .tab-pane {
            display: block !important;
        }
    }

    /* Overlay for mobile sidebar */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .sidebar-overlay.active {
        display: block;
    }

    @media (max-width: 768px) {
        .sidebar-overlay.active {
            display: block;
        }
    }
</style>

@endsection

@section('content')
<div class="content-page mt-5">
    <div class="content container-fluid">
        <div class="page-header">
            <h1>Welcome to Chromo Xpert, Doctor</h1>
            <button class="navbar-toggler" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <p class="subtitle">Effortlessly review and manage patient lab reports with our intuitive dashboard.</p>

        <!-- Stats Cards Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card stats-pending h-100">
                    <i class="fas fa-hourglass-half stats-icon"></i>
                    <h3 class="stats-title">Pending</h3>
                    <h2 class="stats-count">{{ $pendingReports ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-approved h-100">
                    <i class="fas fa-check stats-icon"></i>
                    <h3 class="stats-title">Approved</h3>
                    <h2 class="stats-count">{{ $approvedReports ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-rejected h-100">
                    <i class="fas fa-times stats-icon"></i>
                    <h3 class="stats-title">Rejected</h3>
                    <h2 class="stats-count">{{  $rejectedReports ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="reportTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-pane" type="button" role="tab" aria-controls="pending-pane" aria-selected="true">
                    Pending <span class="badge bg-warning">{{ $pendingReports ?? 0 }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-pane" type="button" role="tab" aria-controls="approved-pane" aria-selected="false">
                    Approved <span class="badge bg-success">{{ $approvedReports ?? 0 }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected-pane" type="button" role="tab" aria-controls="rejected-pane" aria-selected="false">
                    Rejected <span class="badge bg-danger">{{ $rejectedReports ?? 0 }}</span>
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="reportTabsContent">
            <!-- Pending Tab -->
            <div class="tab-pane fade show active" id="pending-pane" role="tabpanel" aria-labelledby="pending-tab">
                <!-- Search and Filter for Pending -->
                <div class="search-filter-container mt-3">
                    <div class="search-filter-row">
                        <div class="search-box">
                            <i class="fas fa-search search-icon mt-2"></i>
                            <input type="text" id="pendingSearch" class="search-input" placeholder="Search pending reports by patient name, report ID, or test type...">
                        </div>
                        <div class="filter-group">
                            <select id="pendingPriorityFilter" class="filter-select">
                                <option value="">All Priorities</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            <select id="pendingSortFilter" class="filter-select">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="patient">Patient Name (A-Z)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="pendingContainer" class="row g-4 mb-5">
                    @if(isset($pendingReportsData) && $pendingReportsData->count() > 0)
                        @foreach ($pendingReportsData as $report)
                            <div class="col-xl-4 col-lg-6 col-md-12" 
                                 data-patient="{{ $report->appointment->pet->name }}"
                                 data-tests="{{ $report->tests->pluck('name')->implode(', ') }}"
                                 data-priority="{{ $report->priority }}"
                                 data-date="{{ $report->created_at->format('Y-m-d H:i:s') }}">
                                <div class="report-card h-100">
                                    <div class="patient-name">Patient: {{ $report->appointment->pet->name }}</div>
                                    <div class="report-meta">
                                        <span>Report ID: {{ $report->test_result_code ?? "-" }}</span>
                                        <span>Date: {{ $report->appointment->appointment_date }}</span>
                                    </div>
                                    <div class="report-details">
                                        <ul>
                                            <li>
                                                Test:
                                                @if(!empty($report->tests))
                                                    @foreach($report->tests as $test)
                                                        {{ $test->name }}
                                                    @endforeach
                                                @endif
                                            </li>
                                            <li>Status: <span class="status-pending">Pending</span></li>
                                            <li>Priority: <span class="priority-{{ strtolower($report->priority) }}">{{ ucfirst($report->priority) }}</span></li>
                                        </ul>
                                    </div>

                                    {{-- Redirect button --}}
                                    <div class="action-row mb-1">
                                        <button class="btn btn-view"
                                            onclick="window.location.href='{{ url('doctor/reports/view/' . $report->test_result_code) }}'">
                                            View Report
                                        </button>
                                    </div>

                                    <div class="action-row">
                                        <button class="btn btn-approve" onclick="approveReport('{{ $report->test_result_code }}')">Approve</button>
                                        <button class="btn btn-reject" onclick="openRejectionModal('{{ $report->test_result_code }}')">Reject</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 no-results">
                            <i class="fas fa-hourglass-half no-results-icon"></i>
                            <h4>No Pending Reports</h4>
                            <p>All pending reports will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approved Tab -->
            <div class="tab-pane fade" id="approved-pane" role="tabpanel" aria-labelledby="approved-tab">
                <!-- Search and Filter for Approved -->
                <div class="search-filter-container mt-3">
                    <div class="search-filter-row">
                        <div class="search-box">
                            <i class="fas fa-search search-icon mt-2"></i>
                            <input type="text" id="approvedSearch" class="search-input" placeholder="Search approved reports by patient name, report ID, or test type...">
                        </div>
                        <div class="filter-group">
                            <select id="approvedPriorityFilter" class="filter-select">
                                <option value="">All Priorities</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            <select id="approvedSortFilter" class="filter-select">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="patient">Patient Name (A-Z)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="approvedContainer" class="row g-4 mb-5">
                    @if(isset($approvedReportsData) && $approvedReportsData->count() > 0)
                        @foreach ($approvedReportsData as $report)
                            <div class="col-xl-4 col-lg-6 col-md-12" 
                                 data-patient="{{ $report->appointment->pet->name }}"
                                 data-tests="{{ $report->tests->pluck('name')->implode(', ') }}"
                                 data-priority="{{ $report->priority }}"
                                 data-date="{{ $report->created_at->format('Y-m-d H:i:s') }}">
                                <div class="report-card h-100">
                                    <div class="patient-name">Patient: {{ $report->appointment->pet->name }}</div>
                                    <div class="report-meta">
                                        <span>Report ID: {{ $report->test_result_code ?? "-" }}</span>
                                        <span>Date: {{ $report->appointment->appointment_date }}</span>
                                    </div>
                                    <div class="report-details">
                                        <ul>
                                            <li>
                                                Test:
                                                @if(!empty($report->tests))
                                                    @foreach($report->tests as $test)
                                                        {{ $test->name }}
                                                    @endforeach
                                                @endif
                                            </li>
                                            <li>Status: <span class="status-approved">Approved</span></li>
                                            <li>Priority: <span class="priority-{{ strtolower($report->priority) }}">{{ ucfirst($report->priority) }}</span></li>
                                        </ul>
                                    </div>

                                    {{-- Redirect button --}}
                                    <div class="action-row mb-1">
                                        <button class="btn btn-view"
                                            onclick="window.location.href='{{ url('doctor/reports/view/' . $report->test_result_code) }}'">
                                            View Report
                                        </button>
                                    </div>

                                    
                                    @if(empty($report->signed_by_id))
                                        <div class="action-row">
                                            <button class="btn btn-sign" onclick="signReport('{{ $report->test_result_code }}')">Sign</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 no-results">
                            <i class="fas fa-check no-results-icon"></i>
                            <h4>No Approved Reports</h4>
                            <p>All approved reports will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Rejected Tab -->
            <div class="tab-pane fade" id="rejected-pane" role="tabpanel" aria-labelledby="rejected-tab">
                <!-- Search and Filter for Rejected -->
                <div class="search-filter-container mt-3">
                    <div class="search-filter-row">
                        <div class="search-box">
                            <i class="fas fa-search search-icon mt-2"></i>
                            <input type="text" id="rejectedSearch" class="search-input" placeholder="Search rejected reports by patient name, report ID, or test type...">
                        </div>
                        <div class="filter-group">
                            <select id="rejectedPriorityFilter" class="filter-select">
                                <option value="">All Priorities</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            <select id="rejectedSortFilter" class="filter-select">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="patient">Patient Name (A-Z)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="rejectedContainer" class="row g-4 mb-5">
                    @if(isset($rejectedReportsData) && $rejectedReportsData->count() > 0)
                        @foreach ($rejectedReportsData as $report)
                            <div class="col-xl-4 col-lg-6 col-md-12" 
                                 data-patient="{{ $report->appointment->pet->name }}"
                                 data-tests="{{ $report->tests->pluck('name')->implode(', ') }}"
                                 data-priority="{{ $report->priority }}"
                                 data-date="{{ $report->created_at->format('Y-m-d H:i:s') }}">
                                <div class="report-card h-100">
                                    <div class="patient-name">Patient: {{ $report->appointment->pet->name }}</div>
                                    <div class="report-meta">
                                        <span>Report ID: {{ $report->test_result_code ?? "-" }}</span>
                                        <span>Date: {{ $report->appointment->appointment_date }}</span>
                                    </div>
                                    <div class="report-details">
                                        <ul>
                                            <li>
                                                Test:
                                                @if(!empty($report->tests))
                                                    @foreach($report->tests as $test)
                                                        {{ $test->name }}
                                                    @endforeach
                                                @endif
                                            </li>
                                            <li>Status: <span class="status-rejected">Rejected</span></li>
                                            <li>Priority: <span class="priority-{{ strtolower($report->priority) }}">{{ ucfirst($report->priority) }}</span></li>
                                        </ul>
                                    </div>

                                    {{-- Redirect button --}}
                                    <div class="action-row mb-1">
                                        <button class="btn btn-view"
                                            onclick="window.location.href='{{ url('doctor/reports/view/' . $report->test_result_code) }}'">
                                            View Report
                                        </button>
                                    </div>

                                    <div class="action-row">
                                        <button class="btn btn-approve" onclick="reApproveReport('{{ $report->test_result_code }}')">Re-Approve</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 no-results">
                            <i class="fas fa-times no-results-icon"></i>
                            <h4>No Rejected Reports</h4>
                            <p>All rejected reports will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pagination Controls (Hidden for now) -->
        <div class="pagination-container mb-5" style="display: none;">
            <button id="prevPage" class="pagination-btn">
                <i class="fas fa-chevron-left"></i> Previous
            </button>
            <div id="paginationNumbers" class="pagination-pages">
                <!-- Page numbers will be dynamically inserted here -->
            </div>
            <button id="nextPage" class="pagination-btn">
                Next <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Modal for Viewing Report -->
    <div class="modal" id="reportModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h3>Report Details</h3>
            <p><strong>Patient:</strong> <span id="modal-patient"></span></p>
            <p><strong>Report ID:</strong> <span id="modal-report-id"></span></p>
            <p><strong>Details:</strong> Detailed report information goes here...</p>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="modal" id="rejectionModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeRejectionModal()">&times;</span>
            <h3>Reject Report</h3>
            <p>Please provide a reason for rejection:</p>
            <form id="rejectionForm" class="rejection-form">
                <input type="hidden" id="rejectReportId" name="report_id">
                <label for="rejectionReason">Rejection Reason:</label>
                <textarea id="rejectionReason" name="reason" placeholder="Enter the reason for rejecting this report..." required></textarea>
                <div class="action-row">
                    <button type="button" class="btn btn-view" onclick="closeRejectionModal()">Cancel</button>
                    <button type="submit" class="btn btn-reject">Submit Rejection</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
    // Sidebar toggle function
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }

    // Close sidebar on overlay click or escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            closeModal();
            closeRejectionModal();
        }
    });

    // Modal Functionality (for view report - keeping original)
    function openModal(patientName, reportId) {
        document.getElementById('modal-patient').textContent = patientName;
        document.getElementById('modal-report-id').textContent = reportId;
        document.getElementById('reportModal').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeModal() {
        document.getElementById('reportModal').style.display = 'none';
        document.body.style.overflow = ''; // Restore scrolling
    }

    // Rejection Modal Functionality
    function openRejectionModal(reportId) {
        document.getElementById('rejectReportId').value = reportId;
        document.getElementById('rejectionReason').value = ''; // Clear previous input
        document.getElementById('rejectionModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('rejectionReason').focus();
    }

    function closeRejectionModal() {
        document.getElementById('rejectionModal').style.display = 'none';
        document.body.style.overflow = '';
        document.getElementById('rejectionForm').reset();
    }

    // Approve Report AJAX
    function approveReport(reportId) {
        if (confirm('Are you sure you want to approve this report?')) {
            fetch(`/doctor/reports/approve/${reportId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Report approved successfully!');
                    location.reload(); // Reload to update tabs and stats
                } else {
                    alert('Error approving report: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while approving the report.');
            });
        }
    }

    // Re-Approve Report (for rejected)
    function reApproveReport(reportId){
        if (confirm('Are you sure you want to re-approve this rejected report?')) {
            fetch(`/doctor/reports/approve/${reportId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Report re-approved successfully!');
                    location.reload(); // Reload to update tabs and stats
                } else {
                    alert('Error re-approving report: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while re-approving the report.');
            });
        }
    }

   // Sign Report AJAX
    function signReport(reportId) {
        if (confirm('Are you sure you want to sign this report?')) {
            fetch(`/doctor/reports/sign/${reportId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Report signed successfully!');
                    // Optionally, remove the card or reload the page
                    const card = document.querySelector(`[data-report-id="${reportId}"]`);
                    if (card) {
                        card.remove();
                    }
                    // Update stats if needed (you can add logic here)
                    location.reload(); // Simple reload for now
                } else {
                    alert('Error signing report: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while signing the report.');
            });
        }
    }





    // Handle Rejection Form Submit
    document.getElementById('rejectionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const reportId = document.getElementById('rejectReportId').value;
        const reason = document.getElementById('rejectionReason').value.trim();

        if (!reason) {
            alert('Please provide a rejection reason.');
            return;
        }

        fetch(`/doctor/reports/reject/${reportId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Report rejected successfully!');
                closeRejectionModal();
                location.reload(); // Reload to update tabs and stats
            } else {
                alert('Error rejecting report: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while rejecting the report.');
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const reportModal = document.getElementById('reportModal');
        const rejectionModal = document.getElementById('rejectionModal');
        if (event.target === reportModal) {
            closeModal();
        } else if (event.target === rejectionModal) {
            closeRejectionModal();
        }
    }

    // Tab-specific Filtering and Sorting
    function initTabFilter(containerId, searchId, priorityId, sortId) {
        let tabReports = Array.from(document.querySelectorAll(`#${containerId} > .col-xl-4, #${containerId} > .col-lg-6, #${containerId} > .col-md-12`));

        function filterTab() {
            const search = document.getElementById(searchId).value.toLowerCase();
            const priorityFilter = document.getElementById(priorityId).value;
            const sortFilter = document.getElementById(sortId).value;

            let filtered = tabReports.filter(card => {
                const patient = card.dataset.patient.toLowerCase();
                const tests = card.dataset.tests.toLowerCase();
                const matchesSearch = !search || patient.includes(search) || tests.includes(search);
                const matchesPriority = !priorityFilter || card.dataset.priority === priorityFilter;
                return matchesSearch && matchesPriority;
            });

            // Sort
            if (sortFilter === 'newest') {
                filtered.sort((a, b) => new Date(b.dataset.date) - new Date(a.dataset.date));
            } else if (sortFilter === 'oldest') {
                filtered.sort((a, b) => new Date(a.dataset.date) - new Date(b.dataset.date));
            } else if (sortFilter === 'patient') {
                filtered.sort((a, b) => a.dataset.patient.localeCompare(b.dataset.patient));
            }

            // Clear container
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            // Append filtered and sorted cards
            filtered.forEach(card => container.appendChild(card));

            // Show no results if empty
            if (filtered.length === 0) {
                const noResults = document.createElement('div');
                noResults.className = 'col-12 no-results';
                noResults.innerHTML = `
                    <i class="fas fa-search no-results-icon"></i>
                    <h4>No reports found</h4>
                    <p>Try adjusting your search or filters.</p>
                `;
                container.appendChild(noResults);
            }
        }

        // Initial filter
        filterTab();

        // Event listeners
        document.getElementById(searchId).addEventListener('keyup', filterTab);
        document.getElementById(priorityId).addEventListener('change', filterTab);
        document.getElementById(sortId).addEventListener('change', filterTab);
    }

    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        initTabFilter('pendingContainer', 'pendingSearch', 'pendingPriorityFilter', 'pendingSortFilter');
        initTabFilter('approvedContainer', 'approvedSearch', 'approvedPriorityFilter', 'approvedSortFilter');
        initTabFilter('rejectedContainer', 'rejectedSearch', 'rejectedPriorityFilter', 'rejectedSortFilter');
    });
</script>
@endsection