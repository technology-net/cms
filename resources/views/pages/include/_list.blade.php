<div class="table-responsive table-has-actions table-has-filter ">
    <div class="form-inline no-footer">
        <div class="dt-buttons btn-group">
            <a href="{{ route('pages.create') }}" class="btn btn-success">
                <span class="mdi mdi-plus"></span>
                {{ trans('plugin/cms::common.create') }}
            </a>
            <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('pages.deleteAll') }}">
                <span class="mdi mdi-trash-can-outline"></span>
                {{ trans('plugin/cms::common.delete') }}
            </button>
        </div>
    </div>
    <table class="table table-striped table-secondary table-hover vertical-middle bg-white mt-3" role="grid" aria-describedby="">
        <thead>
            <tr role="row">
                <th class="text-left no-column-visibility sorting_disabled user-checkbox" aria-label="Check box">
                    <label class="user-checkbox-label">
                        <input class="input-check-all" data-set=".dataTable .checkboxes" type="checkbox">
                    </label>
                </th>
                <th width="8%" title="{{ trans('plugin/cms::common.thumbnail') }}" class="text-center" tabindex="0"
                    aria-label="">{{ trans('plugin/cms::common.thumbnail') }}
                </th>
                <th width="25%" title="{{ trans('plugin/cms::common.title') }}" class="text-left" tabindex="0"
                    aria-label="">{{ trans('plugin/cms::common.title') }}
                </th>
                <th width="25%" title="{{ trans('plugin/cms::common.slug') }}" class="text-left" tabindex="0"
                    aria-label="">{{ trans('plugin/cms::common.slug') }}
                </th>
                <th width="8%" title="{{ trans('plugin/cms::common.sequence') }}" class="text-left" tabindex="0"
                    aria-label="">{{ trans('plugin/cms::common.sequence') }}
                </th>
                <th width="8%" title="{{ trans('plugin/cms::common.status') }}" class="text-left" tabindex="0"
                    aria-label="">{{ trans('plugin/cms::common.status') }}
                </th>
                <th width="12%" title="{{ trans('plugin/cms::common.created_by') }}" class="text-left" tabindex="0"
                    aria-label="">{{ trans('plugin/cms::common.created_by') }}
                </th>
                <th width="10%" title="Operations" class="text-center sorting_disabled user-checkbox"
                     aria-label="Operations">{{ trans('plugin/cms::common.operations') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @if($pages->isNotEmpty())
                @foreach($pages as $key => $item)
                    <tr role="row" class="{{ $key % 2 ? 'odd' : 'even'}}">
                        <td class="text-left no-column-visibility dtr-control">
                            <div class="text-left">
                                <div class="checkbox checkbox-primary table-checkbox">
                                    <label class="user-checkbox-label">
                                        <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td class="text-left">
                            @php
                                $thumbnail = $item->medias->isNotEmpty() ? 'storage' . $item->medias->first()->image_sm : 'cms/images/image-default.png';
                                $thumbnail_alt = $item->medias->isNotEmpty() ? $item->medias->first()->name : 'image-default';
                            @endphp
                            <img src="{{ asset($thumbnail) }}" alt="{{ $thumbnail_alt }}">
                        </td>
                        <td class="text-left">{{ $item->title }}</td>
                        <td class="text-left">{!! $item->slug !!}</td>
                        <td>
                            <input class="form-control text-right editable" type="number" min="1" value="{{ $item->sequence }}"
                                   name="sequence" data-url="{{ route('pages.editable', $item->id) }}"
                                   label="{{ trans('plugin/cms::common.sequence') }}" data-id="{{ $item->id }}"
                                   validate="true" validate-pattern="required"
                            >
                            <div id="error_sequence-{{ $item->id }}" ></div>
                        </td>
                        <td class="text-left">
                            {!! postStatusText($item->status) !!}
                        </td>
                        <td class="text-left">{{ getNameUser($item->created_by) }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm bg-info" title="View user's profile"
                               href="{{ route('pages.edit', $item->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px" viewBox="2 2 20 20">
                                    <title>{{ trans('plugin/cms::common.edit') }}</title>
                                    <path d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"/>
                                </svg>
                            </a>
                            <button class="btn btn-sm bg-danger btn-delete" title="Delete" role="button" data-url="{{ route('pages.destroy', $item->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px" viewBox="2 2 20 20">
                                    <title>{{ trans('plugin/cms::common.delete') }}</title>
                                    <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
