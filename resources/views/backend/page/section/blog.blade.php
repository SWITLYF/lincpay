@extends('backend.layouts.app')
@section('title')
    {{ __('Blog Section') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Blog Section') }}</h2>
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
                            <h3 class="title">{{ __('Contents') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section_code" value="blog">
                                <input type="hidden" name="section_locale" value="{{$key}}">

                                @if($key == 'en')
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-2 col-label pt-0">{{ __('Section Activity') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Manage Section Visibility"></i></label>
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


                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-2 col-label">{{ __('Blog Title Small') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_title_small" class="box-input"
                                            value="{{ $data->blog_title_small }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-2 col-label">{{ __('Blog Title Big') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_title_big" class="box-input"
                                            value="{{ $data->blog_title_big }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit"
                                                class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="section-design-nb">
                        <strong>{{ __('NB:') }}</strong>{{ __('Blogs will come from') }}
                        <a href="{{ route('admin.page.edit','blog') }}">{{ __('Blog Page') }}</a>
                    </div>
                </div>

            @endforeach

        </div>
    </div>

@endsection
