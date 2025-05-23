@extends('backend.layouts.app')

@section('title')
    {{ __('Manage Plan') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Loan Plans') }}</h2>
                            @can('loan-create')
                                <a href="{{ route('admin.plan.loan.create') }}" class="title-btn">
                                    <i data-lucide="plus-circle"></i>
                                    {{ __('Add New') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Plan Name') }}</th>
                                            <th scope="col">{{ __('Min. Amount') }}</th>
                                            <th scope="col">{{ __('Max. Amount') }}</th>
                                            <th scope="col">{{ __('Per Installment') }}</th>
                                            <th scope="col">{{ __('Total Installment') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plans as $plan)
                                            <tr>
                                                <td><strong>{{ $plan->name }}</strong></td>
                                                <td>
                                                    <strong>{{ $currencySymbol }}{{ $plan->minimum_amount }}</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ $currencySymbol }}{{ $plan->maximum_amount }} </strong>
                                                </td>
                                                <td>
                                                    <strong>{{ $plan->per_installment }}{{ __('%') }}</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ $plan->total_installment }} {{ __('Times') }}</strong>
                                                </td>
                                                <td>
                                                    <div @class([
                                                        'site-badge', // common classes
                                                        'success' => $plan->status,
                                                        'danger' => !$plan->status,
                                                    ])>
                                                        {{ $plan->status ? 'Active' : 'Deactivated' }}</div>
                                                </td>
                                                <td>
                                                    @can('loan-plan-edit')
                                                        <a href="{{ route('admin.plan.loan.edit', $plan->id) }}"
                                                            class="round-icon-btn primary-btn">
                                                            <i data-lucide="edit-3"></i>
                                                        </a>
                                                    @endcan
                                                    @can('loan-plan-delete')
                                                        <span type="button" id="deleteModal" data-id="{{ $plan->id }}"
                                                            data-name="{{ $plan->name }}">
                                                            <button class="round-icon-btn red-btn" data-bs-toggle="tooltip"
                                                                title="Delete Plan" data-bs-original-title="Delete Plan">
                                                                <i data-lucide="trash-2"></i>
                                                            </button>
                                                        </span>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('loan-plan-delete')
                            <!-- Modal for Delete Plan -->
                            <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content site-table-modal">
                                        <div class="modal-body popup-body">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <div class="popup-body-text centered">
                                                <div class="info-icon">
                                                    <i data-lucide="alert-triangle"></i>
                                                </div>
                                                <div class="title">
                                                    <h4>{{ __('Are you sure?') }}</h4>
                                                </div>
                                                <p>
                                                    {{ __('You want to delete') }} <strong id="data-name"></strong>
                                                    {{ __('Plan?') }}
                                                </p>
                                                <div class="action-btns">
                                                    <form id="deleteForm" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="site-btn-sm primary-btn me-2">
                                                            <i data-lucide="check"></i>
                                                            Confirm
                                                        </button>
                                                        <a href="" class="site-btn-sm red-btn" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"><i
                                                                data-lucide="x"></i>{{ __('Cancel') }}</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Delete Plan End-->
                        @endcan
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        (function($) {
            "use strict";

            $('body').on('click', '#deleteModal', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#data-name').html(name);
                var url = '{{ route('admin.plan.loan.destroy', ':id') }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#delete').modal('toggle')

            })

        })(jQuery);
    </script>
@endsection
