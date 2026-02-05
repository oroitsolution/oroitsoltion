@extends('userlayout.app')
@section('title', 'User Payout History')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-wallet2 me-2"></i>Payout History
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="exportToExcel()">
                            <i class="bi bi-file-earmark-excel me-1"></i>Export
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Summary Cards --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h4 class="text-success">{{ $payoutdata->where('status', 'success')->count() }}</h4>
                                    <small class="text-muted">Successful</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <h4 class="text-warning">{{ $payoutdata->where('status', 'pending')->count() }}</h4>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-danger">
                                <div class="card-body text-center">
                                    <h4 class="text-danger">{{ $payoutdata->where('status', 'failed')->count() }}</h4>
                                    <small class="text-muted">Failed</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <h4 class="text-info">₹{{ number_format($payoutdata->where('status', 'success')->sum('amount'), 2) }}</h4>
                                    <small class="text-muted">Total Paid</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="payoutTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Transaction ID</th>
                                    <th>TXN ID</th>
                                    <th>UTR</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    
                                    <th>Wallet Balance</th>
                                    <th>Date</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($payoutdata as $key => $payout)
                                    <tr data-id="{{ $payout->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <small class="font-monospace">{{ $payout->trx_id }}</small>
                                            <button class="btn btn-sm btn-outline-secondary ms-1" 
                                                    onclick="copyToClipboard('{{ $payout->trx_id }}')"
                                                    title="Copy Transaction ID">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <small class="font-monospace">{{ $payout->cus_trx_id }}</small>
                                        </td>
                                        <td>
                                            @if($payout->utr)
                                                <span class="font-monospace">{{ $payout->utr }}</span>
                                                <button class="btn btn-sm btn-outline-secondary ms-1" 
                                                        onclick="copyToClipboard('{{ $payout->utr }}')"
                                                        title="Copy UTR">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold">₹{{ number_format($payout->amount, 2) }}</span>
                                        </td>
                                        <td>
                                            @if($payout->status === 'success')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Success
                                                </span>
                                            @elseif($payout->status === 'failed')
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Failed
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-clock me-1"></i>{{ ucfirst($payout->status) }}
                                                </span>
                                            @endif
                                        </td>
                                       
                                        <td>
                                            <span class="fw-bold">₹{{ number_format($payout->lastwallet_balance, 2) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($payout->created_at)->format('d M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($payout->created_at)->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-primary btn-sm" 
                                                        onclick="viewSlip('{{ $payout->cus_trx_id }}')" 
                                                        title="View Slip">
                                                    <i class="bi bi-receipt"></i>
                                                    <span class="d-none d-md-inline">Slip</span>
                                                </button>
                                                <button class="btn btn-info btn-sm" 
                                                        onclick="checkStatus('{{ $payout->trx_id }}')" 
                                                        title="Check Status">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                    <span class="d-none d-md-inline">Status</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox display-4"></i>
                                            <p class="mt-3">No payout records found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Slip Modal --}}
<div class="modal fade" id="slipModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-receipt me-2"></i>Payment Slip
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="slipContent">
                {{-- Slip content will be loaded here --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printSlip()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Status Check Modal --}}
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-arrow-clockwise me-2"></i>Status Check
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="statusContent">
                {{-- Status content will be loaded here --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .badge {
        font-size: 0.75em;
    }
    
    .font-monospace {
        font-family: 'Courier New', monospace;
        font-size: 0.85em;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    #payoutTable tbody tr {
        transition: all 0.2s ease;
    }
    
    #payoutTable tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .card.border-success {
        border-left: 4px solid #28a745 !important;
    }
    
    .card.border-warning {
        border-left: 4px solid #ffc107 !important;
    }
    
    .card.border-danger {
        border-left: 4px solid #dc3545 !important;
    }
    
    .card.border-info {
        border-left: 4px solid #17a2b8 !important;
    }
    
    @media (max-width: 768px) {
        .btn-sm span {
            display: none !important;
        }
        
        .d-flex.gap-1 {
            gap: 0.25rem !important;
        }
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('Copied to clipboard!', 'success');
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showToast('Copied to clipboard!', 'success');
        });
    }

    // View Slip Function
    function viewSlip(payoutId) {

    const modalEl = document.getElementById('slipModal');
    const modal   = new bootstrap.Modal(modalEl);
    const content = document.getElementById('slipContent');

    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2 text-muted">Loading payout slip...</p>
        </div>
    `;

    modal.show();

    fetch(`{{ url('/user/payout') }}/${payoutId}/slip`)
        .then(res => {
            if (!res.ok) throw new Error('Failed');
            return res.json();
        })
        .then(data => {
            content.innerHTML = generateSlipHTML(data);
        })
        .catch(() => {
            content.innerHTML = `
                <div class="alert alert-danger text-center">
                    Unable to load payout slip
                </div>
            `;
        });
}


    // Check Status Function
    function checkStatus(trxId) {
        const modal = new bootstrap.Modal(document.getElementById('statusModal'));
        
        // Show loading
        document.getElementById('statusContent').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Checking...</span>
                </div>
                <p class="mt-3 text-muted">Checking transaction status...</p>
            </div>
        `;
        
        modal.show();
        
        // Simulate API call - replace with actual endpoint
        fetch(`/payout/status/${trxId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusContent').innerHTML = generateStatusHTML(data.status);
                } else {
                    document.getElementById('statusContent').innerHTML = `
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Unable to check status at this time
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error checking status:', error);
                document.getElementById('statusContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Error checking transaction status
                    </div>
                `;
            });
    }

    // Generate Slip HTML
    function generateSlipHTML(payout) {
        return `
            <div class="p-3">
                <div class="text-center mb-4">
                    <h4 class="text-primary">Payment Receipt</h4>
                    <small class="text-muted">Transaction #${payout.trx_id}</small>
                </div>
                
                <div class="row mb-3">
                    <div class="col-6"><strong>Amount:</strong></div>
                    <div class="col-6 text-end">₹${parseFloat(payout.amount).toFixed(2)}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6"><strong>Status:</strong></div>
                    <div class="col-6 text-end">
                        <span class="badge bg-${payout.status === 'success' ? 'success' : payout.status === 'failed' ? 'danger' : 'warning'}">
                            ${payout.status.toUpperCase()}
                        </span>
                    </div>
                </div>
              
                <div class="row mb-3">
                    <div class="col-6"><strong>Date:</strong></div>
                    <div class="col-6 text-end">${new Date(payout.created_at).toLocaleDateString()}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6"><strong>Time:</strong></div>
                    <div class="col-6 text-end">${new Date(payout.created_at).toLocaleTimeString()}</div>
                </div>
                ${payout.utr ? `
                <div class="row mb-3">
                    <div class="col-6"><strong>UTR:</strong></div>
                    <div class="col-6 text-end font-monospace">${payout.utr}</div>
                </div>
                ` : ''}
            </div>
        `;
    }

    // Generate Status HTML
    function generateStatusHTML(status) {
        return `
            <div class="p-3">
                <div class="text-center mb-4">
                    <i class="bi bi-info-circle text-info" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Transaction Status</h5>
                </div>
                
                <div class="alert alert-${status.status === 'success' ? 'success' : status.status === 'failed' ? 'danger' : 'warning'}">
                    <h6 class="alert-heading">
                        <i class="bi bi-${status.status === 'success' ? 'check-circle' : status.status === 'failed' ? 'x-circle' : 'clock'} me-2"></i>
                        ${status.status.toUpperCase()}
                    </h6>
                    <p class="mb-0">${status.message || 'Status updated'}</p>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        Last updated: ${new Date().toLocaleString()}
                    </small>
                </div>
            </div>
        `;
    }

    // Print Slip Function
    function printSlip() {
        const slipContent = document.getElementById('slipContent').innerHTML;
        const printWindow = window.open('', '_blank', 'width=400,height=600');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Payment Slip</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        .text-center { text-align: center; }
                        .text-primary { color: #007bff; }
                        .row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                        .badge { padding: 4px 8px; border-radius: 4px; color: white; }
                        .bg-success { background-color: #28a745; }
                        .bg-danger { background-color: #dc3545; }
                        .bg-warning { background-color: #ffc107; color: #000; }
                    </style>
                </head>
                <body>
                    ${slipContent}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    // Export to Excel Function
    function exportToExcel() {
        showToast('Export functionality will be implemented soon!', 'info');
        // You can implement this using libraries like SheetJS or server-side export
    }

    // Toast Notification Function
    function showToast(message, type = 'success') {
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.innerHTML = toastHtml;
        document.body.appendChild(toastContainer);
        
        const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
        toast.show();
        
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }

    // Initialize DataTable (optional enhancement)
    document.addEventListener('DOMContentLoaded', function() {
        // You can initialize DataTable here if needed
        // $('#payoutTable').DataTable();
    });
</script>
@endpush