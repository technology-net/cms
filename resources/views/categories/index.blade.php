@extends('packages/core::layouts.admin')
@section('title')
    @lang('plugin/cms::cms.category.screen')
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('plugin/cms::cms.title'),
                'url' => '#',
            ],
            [
                'label' => trans('plugin/cms::cms.category.screen'),
                'url' => '#',
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="menus-table">
        @include('plugin/cms::categories.include._list')
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
@endsection
