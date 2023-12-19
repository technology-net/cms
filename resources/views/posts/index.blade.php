@extends('packages/core::layouts.admin')
@section('title')
    @lang('plugin/cms::cms.post.screen')
@stop

@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('plugin/cms::cms.title'),
                'url' => '#',
            ],
            [
                'label' => trans('plugin/cms::cms.post.screen'),
                'url' => '#',
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="menus-table">
        @include('plugin/cms::posts.include._list')
    </div>
@endsection
