@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Point Order Invoice') }}</div>

                <div class="card-body">
                    <p>Dear {{ $invoice->PointOrder->Employer->name }},</p>
                    <p>Thank for Shopping with Us!</p>
                    <p>If you have any questions, our support team is ready to assist you.</p>
                </div>
                <div class="card-footer">
                    <p>Thanks for choosing us!</p>
                    <p>Best Regards,</p>
                    <p>The Infinity Careers Team</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
