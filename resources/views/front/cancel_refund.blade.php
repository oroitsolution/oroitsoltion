@extends('frontlayout.app')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card shadow-sm border-0">
                <div class="card-body p-5">

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Cancellation & Refund Policy</h2>
                        <p class="text-muted mb-0">
                            Applicable to All Users
                        </p>
                        
                    </div>

                    <!-- Introduction -->
                    <p>
                        This Cancellation & Refund Policy outlines the terms under which
                        <strong>ORO IT SOLUTION PVT. LTD.</strong> processes order cancellations
                        and refunds for services and transactions carried out on our platform.
                        By using our services, you agree to the terms stated below.
                    </p>

                    <!-- 1. Order Cancellation by User -->
                    <h5 class="mt-4 fw-semibold">1. Order Cancellation by User</h5>
                    <p>
                        If a user initiates the cancellation of an order from their account,
                        the order will be marked as <strong>Cancelled</strong> on our system.
                        Any amount deducted for the cancelled order shall be refunded to the
                        user’s original payment method or respective account, subject to
                        successful verification.
                    </p>

                    <!-- 2. Failed or Unsuccessful Transactions -->
                    <h5 class="mt-4 fw-semibold">2. Failed or Unsuccessful Transactions</h5>
                    <p>
                        In cases where a transaction fails due to technical issues, bank-related
                        problems, network failures, or any other unforeseen conditions, the
                        deducted amount (if any) will be refunded to the user’s respective
                        account automatically.
                    </p>

                    <!-- 3. Refund Processing -->
                    <h5 class="mt-4 fw-semibold">3. Refund Processing Timeline</h5>
                    <p>
                        Refunds are initiated after confirmation of cancellation or transaction
                        failure. The credited amount may take <strong>5–7 working days</strong>
                        (or as per banking norms) to reflect in the user’s account, depending
                        on the payment provider or bank.
                    </p>

                    <!-- 4. Mode of Refund -->
                    <h5 class="mt-4 fw-semibold">4. Mode of Refund</h5>
                    <p>
                        All refunds will be processed through the original mode of payment used
                        for the transaction, unless otherwise specified or required by law.
                    </p>

                    <!-- 5. Partial or Delayed Refunds -->
                    <h5 class="mt-4 fw-semibold">5. Partial or Delayed Refunds</h5>
                    <p>
                        In rare cases, refunds may be delayed due to bank processing times,
                        holidays, or compliance checks. Users are advised to contact support
                        if the refund is not received within the stated timeline.
                    </p>

                    <!-- 6. Non-Refundable Scenarios -->
                    <h5 class="mt-4 fw-semibold">6. Non-Refundable Scenarios</h5>
                    <p>
                        Completed and successfully processed services may not be eligible
                        for refunds unless explicitly stated or required under applicable laws.
                    </p>

                    <!-- 7. Policy Updates -->
                    <h5 class="mt-4 fw-semibold">7. Changes to This Policy</h5>
                    <p>
                        ORO IT SOLUTION PVT. LTD. reserves the right to modify or update this
                        Cancellation & Refund Policy at any time. Any changes will be effective
                        immediately upon posting on this page.
                    </p>

                    <!-- Contact -->
                    <h5 class="mt-4 fw-semibold">8. Contact & Support</h5>
                    <p class="mb-0">
                        For any questions or concerns regarding cancellations or refunds,
                        please contact our support team:
                    </p>
                    <p class="mt-2">
                        <strong>ORO IT SOLUTION PVT. LTD.</strong><br>
                        Email: support@oroitsolution.com
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
