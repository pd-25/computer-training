@extends('subadmin.layout.main')

<style>
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --light: #f8f9fa;
        --dark: #212529;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .wallet-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .section-title {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary);
        border-radius: 3px;
    }

    .balance-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .balance-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .balance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .balance-card.total-balance {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .balance-card.transaction-balance {
        background: linear-gradient(135deg, #7209b7, #560bad);
        color: white;
    }

    .card-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2.5rem;
        opacity: 0.2;
    }

    .card-title {
        font-size: 1rem;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    .card-amount {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .card-change {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .add-amount-form {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        margin-top: 20px;
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--primary);
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e1e5ee;
        transition: var(--transition);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }

    .btn-primary {
        background: var(--primary);
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-primary:hover {
        background: var(--secondary);
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .transaction-history {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        margin-top: 30px;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-details h5 {
        margin: 0;
        font-size: 1rem;
    }

    .transaction-details p {
        margin: 5px 0 0;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .transaction-amount {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .transaction-amount.positive {
        color: #28a745;
    }

    .transaction-amount.negative {
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .balance-cards {
            grid-template-columns: 1fr;
        }

        .balance-card {
            padding: 20px;
        }

        .card-amount {
            font-size: 1.7rem;
        }
    }
</style>
@section('title', 'My Wallet')


@section('content')
<section class="section dashboard">
    <div class="wallet-container">

        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif


        <h2 class="section-title">My Wallet</h2>

        <!-- Balance Cards -->
        <div class="balance-cards">
            <div class="balance-card total-balance">
                <i class="fas fa-wallet card-icon"></i>
                <div class="card-title" style="color: white;">Total Balance</div>
                <div class="card-amount">₹{{$myWallet->amount ?? 0}}</div>
                <div class="card-change">
                    <i class="fas fa-arrow-up"></i> Your current wallet balance
                </div>
            </div>

            <div class="balance-card transaction-balance">
                <i class="fas fa-exchange-alt card-icon"></i>
                <div class="card-title" style="color: white;">Total Transactions</div>
                <div class="card-amount">₹{{$totalTransactionAmount ?? 0}}</div>
                <div class="card-change">
                    <i class="fas fa-arrow-up"></i> Your total spending and top-ups
                </div>
            </div>
        </div>

        <!-- Add Amount Form -->
        <div class="add-amount-form">
            <h3 class="form-title">Add Amount to Wallet</h3>
            <form id="addAmountForm" action="{{route('subadmin.topup.request')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="subadmin_id" id="subadmin_id" value="{{auth()->guard('subadmin')->id()}}">
                        <label for="amount" class="form-label">Amount<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter amount" min="1" step="0.01" required>
                        </div>
                        <div class="form-text">Minimum amount: ₹100.00</div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="paymentMethod" class="form-label">NITE QR Code</label>
                        <div class="border" style="width: fit-content;">
                            <img src="https://media.istockphoto.com/id/1347277582/vector/qr-code-sample-for-smartphone-scanning-on-white-background.jpg?s=612x612&w=0&k=20&c=6e6Xqb1Wne79bJsWpyyNuWfkrUgNhXR4_UYj3i_poc0=" alt="NITE QR Code" class="img-fluid" style="max-width: 200px;">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="payment_reciept" class="form-label">Upload Payment Receipt<span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="payment_reciept" name="payment_reciept" accept="image/*,application/pdf" required>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-outline-secondary me-md-2">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Amount</button>
                </div>
            </form>
        </div>

        <!-- Recent Transactions -->
        <div class="transaction-history">
            <h3 class="form-title">Recent Transactions</h3>
            @foreach($transactions as $transaction)
            <div class="transaction-item">
                <div class="transaction-details">
                    <h5><strong>{{ $transaction->student?->enrollment_no ?? 'N/A' }}</strong> <br> <span style="text-transform: capitalize;">{{$transaction->student?->name ?? 'N/A'}}</span></h5>
                    <p>{{$transaction->created_at->format('M d, Y')}} • System</p>
                </div>
                <div class="transaction-amount negative">- ₹{{$transaction->debit_balance}}</div>
                <div class="transaction-amount positive">Avl ₹{{$transaction->avl_balance}}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Auto-hide alerts after 2.5 seconds
        setTimeout(() => {
            document.querySelectorAll("#alert-container .alert").forEach(el => {
                el.remove();
            });
        }, 2500);
    });
</script>
@endsection