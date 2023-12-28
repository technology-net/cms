<div class="card">
    <div class="card-header">
        @can('create posts')
            <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                {{ trans('packages/core::common.create') }}
            </a>
        @endcan
        @can('delete posts')
            <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('posts.deleteAll') }}">
                <i class="fas fa-trash"></i>
                {{ trans('packages/core::common.delete') }}
            </button>
        @endcan
    </div>
    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
        <thead>
            <tr>
                @can('delete posts')
                    <th width="3%" class="text-center">
                        <label class="user-checkbox-label">
                            <input class="input-check-all" type="checkbox">
                        </label>
                    </th>
                @endcan
                <th width="8%" class="text-center">{{ trans('plugin/cms::common.thumbnail') }}</th>
                <th width="18%">{{ trans('plugin/cms::common.title') }}</th>
                <th width="26%">{{ trans('plugin/cms::common.short_content') }}</th>
                <th width="7%">{{ trans('plugin/cms::common.sequence') }}</th>
                <th width="10%">{{ trans('plugin/cms::common.category') }}</th>
                <th width="8%%">{{ trans('plugin/cms::common.status') }}</th>
                <th width="10%">{{ trans('plugin/cms::common.created_by') }}</th>
                <th width="10%" class="text-center">{{ trans('plugin/cms::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $item)
                <tr>
                    @can('delete posts')
                        <td class="text-center">
                            <label class="user-checkbox-label">
                                <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                            </label>
                        </td>
                    @endcan
                    <td class="text-left">
                        @php
                            $thumbnail = $item->medias->isNotEmpty() ? getPathImage($item->medias->first()->image_sm) : asset('cms/images/image-default.png');
                            $thumbnail_alt = $item->medias->isNotEmpty() ? $item->medias->first()->name : 'image-default';
                        @endphp
                        <img src="{{ $thumbnail }}" alt="{{ $thumbnail_alt }}">
                    </td>
                    <td class="text-left">{{ $item->title }}</td>
                    <td class="text-left">{!! $item->short_content !!}</td>
                    <td class="text-right">
                        @can('edit posts')
                            <input class="form-control text-right editable" type="number" min="1" value="{{ $item->sequence }}"
                                   name="sequence" data-url="{{ route('posts.editable', $item->id) }}"
                                   data-id="{{ $item->id }}"
                                   validate="true" validate-pattern="required"
                            >
                            <div id="error_sequence-{{ $item->id }}" ></div>
                        @else
                            {{ $item->sequence }}
                        @endcan
                    </td>
                    <td class="text-left">
                        {{ !empty($item->category) ? $item->category->name : '' }}
                    </td>
                    <td class="text-left">
                        {!! postStatusText($item->status) !!}
                    </td>
                    <td class="text-left">{{ getNameUser($item->created_by) }}</td>
                    <td class="text-center">
                        @can('edit posts')
                            <a class="btn btn-sm bg-info" href="{{ route('posts.edit', $item->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endcan
                        @can('delete posts')
                            <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('posts.destroy', $item->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
