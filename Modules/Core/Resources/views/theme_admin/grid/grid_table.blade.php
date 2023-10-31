@extends('core::theme_admin.layouts.app')

@section('content')
    <style>
        .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
            direction: ltr;

        }
        nav.flex.items-center.justify-between {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
        }
        .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
            display: block;
            text-align: center;
        }
    </style>
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="mt-4 p-4">

                @if($view_model->filters && count($view_model->filters) > 0 )
                    <form class="" id="filterForm" method="GET" action="" data-base-url="" data-action-export="{{route('admin.core.exports.export')}}">
                        <input type="hidden" name="class" value="{{get_class($view_model)}}">
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($view_model->filters as $filter )
                                {!!  $view_model->generateFilterHtml($filter)  !!}
                            @endforeach
                            <div>
                                <button data-url="" style="margin-top: 25px" class="btn-success btn _submitexportOrfilter _filter_grid" type="submit">اعمال</button>
                                @if($view_model->can_export)
                                    <button class="btn btn-primary _submitexport" data-url="{{route('admin.core.exports.export' )}}" >خروجی</button>
                                @endif
                            </div>
                        </div>
                    </form>
                @endif


                @if($view_model->can_import)
                    <form action="{{route('admin.core.exports.import' )}}" method="post" enctype="multipart/form-data">
                        <br><br><br>
                        @csrf
                        <input type="hidden" name="class" value="{{get_class($view_model)}}">

                        <input type="file" class="" name="file">
                        <button class="btn btn-primary" type="submit" >ورود اطلاعات</button>
                    </form>
                @endif


                <div class="lg:flex md:flex-col gap-2 mt-4">
                    @foreach($view_model->buttons as $btn)
                        <div>
                            <a class="btn {{ @ $btn['class'] }}" href="{{ $btn['url'] }}">{{ $btn['title']  }}</a>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="overflow-x-auto py-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ردیف</th>
                            @foreach($view_model->columns as $column)

                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">{{ $column['title'] }}</th>
                            @endforeach
                            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap"> عملیات </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $view_model->rows as $key => $row )
                            @php
                                $item = $view_model->getRowUpdate($row);
                            @endphp
                            <tr>
                                <td class="border-b whitespace-nowrap">{{ ++$key }}</td>
                                @foreach($view_model->columns as $column)
                                    @php
                                        $item_attr = $column['name'] ;
                                    @endphp
                                    <td class="border-b whitespace-nowrap">{!!   @ $item->$item_attr !!}</td>
                                @endforeach

                                <td class="border-b whitespace-nowrap">
                                    @php
                                        $actions = $view_model->getActionUpdate($view_model->actions , $row);
                                    @endphp
                                    @foreach( $actions as $key=>$action )
                                        @if(@ $action['url']['method'] == 'get')
                                            <a class="btn {{@ $action['class'] }} btn-sm" href="{{ $view_model->getActionUrl( $action['url'] , $item ) }}">{{$action['title']}}</a>
                                        @elseif(@ $action['url']['method'] == 'delete')
                                            <form action="{{ $view_model->getActionUrl( $action['url'] , $item ) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn {{@ $action['class'] }} btn-sm" type="submit">
                                                    {{$action['title']}}
                                                </button>
                                            </form>

                                        @else
                                            <form action="{{ $view_model->getActionUrl( $action['url'] , $item ) }}" method="post">
                                                @csrf
                                                <button class="btn {{@ $action['class'] }} btn-sm" type="submit">
                                                    {{$action['title']}}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $view_model->rows->appends($_GET)->links() }}
        </div>
        <!-- END: Content -->
@endsection
@section('scripts')

    <script>
        jQuery(document).ready(function () {
            $('body').on('click', '._submitexport', function (event) {
                console.log('a')
                event.preventDefault();
                $('#filterForm').attr('action' , $('#filterForm').attr("data-action-export"))
                $('button._ExceleExport').text( 'در حال انجام عملیات ...');
                $('#filterForm').submit();
                $('button._ExceleExport').text( 'خروجی اکسل');

            });
            $('body').on('click', '._submitexportOrfilter', function (event) {
                console.log('a')
                event.preventDefault();
                $('#filterForm').attr('action' , $('#filterForm').attr("data-base-url"))
                $('#filterForm').submit();
            });
        });
    </script>

@endsection


