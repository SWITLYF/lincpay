@extends('backend.layouts.app')
@section('title')
    {{ __('Edit Page') }}
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
                            <h2 class="title">{{ __('Update Page') }}</h2>
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

                <div
                    class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}"
                    id="{{$key}}"
                    role="tabpanel"
                    aria-labelledby="pills-informations-tab"
                >

                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="title">{{ __('Activity and Contents') }}</h3>
                            @if($key == 'en')
                                <form action="{{ route('admin.page.delete.now') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="page_code" value="{{ $code }}">
                                    <a href="{{ route('dynamic.page',$code) }}" target="_blank" class="site-btn-sm primary-btn"> <i data-lucide="eye"></i> {{ __('View Page') }}</a>
                                    <button type="submit" class="site-btn-sm red-btn"><i data-lucide="trash"></i> {{ __('Delete') }}</button>
                                </form>
                            @endif
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="page_code" value="{{ $code }}">
                                <input type="hidden" name="page_locale" value="{{$key}}">


                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Page Title') }}<i data-lucide="info"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    title=""
                                                                                                    data-bs-original-title="Page Title will show on Breadcrumb"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="box-input" placeholder="New Page Name" value="{{ $data->title ?? $title }}">
                                    </div>

                                </div>

                                @if($key != 'en')
                                    <input type="hidden" name="section_id" value="{{$data->section_id}}">
                                @endif

                                @if($key == 'en')
                                <div class="site-input-groups row mb-0">
                                        <label for="" class="col-sm-3 col-label">{{ __('Content Come From') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="The Contents will come from a section. Don't need any? Leave it blank"></i></label>
                                        <div class="col-sm-9">
                                            <div class="site-input-groups">
                                                <div class="site-input-groups">
                                                    <select name="section_id[]" id="section_id" class="form-select" multiple>
                                                        @foreach($landingSections as $section)
                                                            <option @selected(is_array(json_decode($data->section_id)) && in_array($section->id,json_decode($data->section_id))) value="{{$section->id}}">{{ $section->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Page Contents') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Leave it blank if you don't need any custom content"></i></label>
                                    <div class="col-sm-9">
                                        <div class="site-editor fw-normal">
                                    <textarea class="summernote"
                                            name="content">{!! $data->content !!}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="site-input-groups row mb-4">
                                    <label for="" class="col-sm-3 col-label"></label>
                                    <div class="col-sm-9">
                                        <hr>
                                    </div>
                                </div>


                                <div class="site-input-groups row">
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
                                        <textarea name="meta_description" id="" cols="30" rows="5" class="form-textarea">{{ $data->meta_description }}</textarea>
                                    </div>
                                </div>

                                <div class="site-input-groups row @if($key != 'en') hidden @endif">
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

                                <div class="row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('backend/js/choices.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            "use strict";

            new Choices('#section_id', {
                removeItemButton: true
            });
        })
    </script>
@endsection
