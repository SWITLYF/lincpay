@extends('backend.layouts.app')
@section('title')
    {{ __('How It Works') }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/css/choices.min.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('How It Works Page') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-tab-bars">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                @foreach($languages as $language)
                    <li class="nav-item" role="presentation">
                        <a
                            href=""
                            class="nav-link  {{ $loop->index == 0 ?'active' : '' }}"
                            id="pills-informations-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#{{$language->locale}}"
                            type="button"
                            role="tab"
                            aria-controls="pills-informations"
                            aria-selected="true"
                        ><i data-lucide="languages"></i>{{$language->name}}</a
                        >
                    </li>
                @endforeach


            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">

            @foreach($groupData as $key => $value)

                @php
                    $data = new Illuminate\Support\Fluent($value);
                @endphp

                <div class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}" id="{{$key}}" role="tabpanel" aria-labelledby="pills-informations-tab">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Titles') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="page_code" value="howitworks">
                                <input type="hidden" name="page_locale" value="{{$key}}">
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Page Title') }}<i data-lucide="info"
                                                                                                      data-bs-toggle="tooltip"
                                                                                                      title=""
                                                                                                      data-bs-original-title="Page Title will show on Breadcrumb"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="box-input" value="{{ $data->title }}">
                                    </div>
                                </div>

                                @if($key == 'en')
                                <div class="site-input-groups row mb-0">
                                    <label for="" class="col-sm-3 col-label">{{ __('Content Come From') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="The Contents will come from a Section"></i></label>
                                    <div class="col-sm-9">
                                        <div class="site-input-groups">
                                            <div class="site-input-groups">
                                                <select name="section_id[]" id="section_id" class="form-select" multiple>
                                                    <option value="" disabled>{{ __('--Select Section if Need--') }}</option>
                                                    @foreach($landingSections as $section)
                                                        <option @selected(is_array(json_decode($data->section_id)) && in_array($section->id,json_decode($data->section_id))) value="{{ $section->id }}">{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row mb-4">
                                    <label for="" class="col-sm-3 col-label"></label>
                                    <div class="col-sm-9">
                                        <hr>
                                    </div>
                                </div>

                                <div class="site-input-groups row mt-4">
                                    <label for="" class="col-sm-3 col-label">{{ __('Seo Keywords') }}<i data-lucide="info"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        title=""
                                                                                                        data-bs-original-title="Page Seo Keywords"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="meta_keywords" class="box-input"
                                               value="{{ $data->meta_keywords }}">
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Seo Description') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Page Seo Description"></i></label>
                                    <div class="col-sm-9">
                                        <textarea name="meta_description" cols="30" rows="5" class="form-textarea">{{ $data->meta_description }}</textarea>
                                    </div>
                                </div>
                                @if($key == 'en')
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label pt-0">{{ __('Page Status') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Manage Page Visibility"></i></label>
                                        <div class="col-sm-3">
                                            <div class="site-input-groups">
                                                <div class="switch-field">
                                                    <input type="radio" id="active" name="status" @if($status) checked
                                                           @endif value="1"/>
                                                    <label for="active">{{ __('Show') }}</label>
                                                    <input type="radio" id="deactivate" name="status" @if(!$status) checked
                                                           @endif value="0"/>
                                                    <label for="deactivate">{{ __('Hide') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit"
                                                class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            @php
                $landingContent =\App\Models\LandingContent::where('type','howitworks')->where('locale',app()->getLocale())->get();
            @endphp
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Contents') }}</h3>
                    <div class="card-header-links">
                        <a href="" class="card-header-link" type="button" data-bs-toggle="modal"
                            data-bs-target="#addNew">{{ __('Add New') }}</a>
                    </div>
                </div>
                <div class="site-card-body">
                    <div class="site-table table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col">{{ __('Description') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($landingContent as $content)
                                <tr>
                                    <td>
                                        <img class="avatar" src="{{ asset($content->icon)}}" alt="">
                                    </td>
                                    <td>
                                        {{ $content->title }}
                                    </td>
                                    <td>{{ $content->description }}</td>
                                    <td>
                                        <button class="round-icon-btn primary-btn editContent" type="button"
                                                data-id="{{ $content->id }}">
                                            <i data-lucide="edit-3"></i>
                                        </button>
                                        <button class="round-icon-btn red-btn deleteContent" type="button"
                                                data-id="{{ $content->id }}">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('backend.page.include.__add_new_howitworks')
        @include('backend.page.include.__edit')
        @include('backend.page.include.__delete')
    </div>

@endsection
@section('script')

    <script src="{{ asset('backend/js/choices.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            "use strict";

            new Choices('#section_id', {
                removeItemButton: true,
                shouldSort: false
            });

            $('.editContent').on('click',function (e) {
                "use strict";
                e.preventDefault();
                var id = $(this).data('id');

                var url = '{{ route("admin.page.content-edit", ":id") }}';
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // Handle the response HTML
                        $('#target-element').html(response.html);
                        $('#editContent').modal('show');
                    },
                    error: function(xhr) {
                        // Handle any errors that occurred during the request
                        console.log(xhr.responseText);
                    }
                });
            });

            $('.deleteContent').on('click',function (e) {
                "use strict";
                e.preventDefault();
                var id = $(this).data('id');
                $('#deleteId').val(id);
                $('#deleteContent').modal('show');
            });
        })
    </script>
@endsection
