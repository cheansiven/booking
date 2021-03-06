@extends('template')

@section('style')
    <style>
        #message {
            bottom: 20px;
            position: fixed;
            z-index: 99;
            width: inherit;
            font-size: 14px;
        }

        label {
            font-weight: normal;
        }

        label[for="num_ava_room"] {
            float: left;
            text-align: right;
            max-width: 115px;
            padding-right: 5px;
        }

        label[for="rate_price"] {
            text-align: right;
        }

        .btn.btn-danger {
            background-color: #ff0b00;
            border-color: #ff0b00;
            font-weight: bold;
        }

        td a.btn-remove, .btn-remove {
            color: #fe2e2e;
            text-transform: uppercase;
        }

        td h3 {
            margin: 5px;
        }

        .modal-footer svg {
            width: 28px;
            height: 28px;
            float: left;
            margin-top: 2px;
            padding-top: 5px;
        }

        .modal-footer .col-sm-8 {
            text-align: left;
        }

        .modal-footer p {
            padding-left: 45px;
        }

        #room_available_list table td:first-child {
            vertical-align: middle;
        }
    </style>
@stop

@section('content')
    <div class="C_Room_Header">
        <div id="room_photo" class="photo_container">
            <img class="C_Room_img" src="{{ url($room[0]->photo) }}"/>
            <div type="button" class="btn-camera" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                 data-target="#uploadRoomImageModal" id="showUploadRoomImageModal">
                <i class="fa fa-camera"></i>
            </div>
        </div>
        <h1 data-id="{{ $room[0]->id }}" id="room_name">
            <span>{{ $room[0]->name }}</span>
            <a href="#" id="edit_room_name" class="edit_label">[edit]</a>
        </h1>
    </div>

    {{--upload image modal--}}
    <div class="modal fade" id="uploadRoomImageModal" tabindex="-1" role="dialog"
         aria-labelledby="uploadRoomImageModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ $room[0]->name }}</h4>
                </div>
                <div class="modal-body">
                    <div id="validation-errors"></div>
                    <div class="upload_form">
                        <i class="fa fa-photo"></i>
                        <form class="form-horizontal" id="upload" enctype="multipart/form-data" method="post"
                              action="{{ url('rooms/upload/image') }}" autocomplete="off">
                            <input type="file" name="image" id="image"/>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        </form>

                        <div id="image_preview_remove">
                            <p><i class="fa fa-upload"></i> Re-Upload</p>
                        </div>
                        <div id="image_preview" style="display:none"></div>

                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-8">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                             id="Layer_1" x="0px" y="0px" width="300px" height="300px" viewBox="0 0 300 300"
                             enable-background="new 0 0 300 300" xml:space="preserve">
                            <path fill-rule="evenodd" clip-rule="evenodd" fill="#231F20"
                                  d="M22.761 247.331l119.534-206.91c4.24-7.389 12.049-7.328 16.409 0.181l120.321 207.214c4.239 7.327-0.425 13.201-8.72 13.201l-238.216-0.062C22.583 260.954 18.584 254.598 22.761 247.331z"/>
                            <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="275.9277" y1="178.8818"
                                            x2="23.0259" y2="138.8261">
                                <stop offset="0" stop-color="#FFCA05"/>
                                <stop offset="1" stop-color="#FFCA05"/>
                            </linearGradient>
                            <polygon fill-rule="evenodd" clip-rule="evenodd" fill="url(#SVGID_1_)"
                                     points="37.292 248.087 264.439 248.146 150.561 52.022 "/>
                            <path fill-rule="evenodd" clip-rule="evenodd" fill="#231F20"
                                  d="M150.704 234.315c-8.298 0-15.004-6.766-15.004-15.062 0-8.295 6.706-15 15.004-15 8.295 0 15.06 6.705 15.06 15C165.764 227.55 158.999 234.315 150.704 234.315L150.704 234.315zM132.759 130.324c0.017-9.812 8.012-17.795 17.826-17.795 9.866 0 17.859 7.973 18.177 17.659 0.004 0.035 0.003 0.065-0.001 0.101l-3.642 52.934c-0.001 0.019-0.001 0.035-0.001 0.055 -0.133 8.104-6.543 14.503-14.474 14.503 -7.874 0-14.337-6.396-14.354-14.324 0-0.021-0.002-0.042-0.004-0.063l-3.525-53.002C132.761 130.368 132.759 130.347 132.759 130.324z"/>
                        </svg>
                        <p>
                            The image should be jpg or png format only and the size
                            must be 297px x 198px
                        </p>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelRoomPic">Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="btnSaveRoomPic" data-id="{{ $room[0]->id }}"
                            disabled>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--end of modal--}}

    <div id="room_form_container" class="container">

        <div id="message" class="alert " role="alert" style="display: none;">&nbsp;</div>

        {!! Form::model($room, ['method' => 'PATCH', 'action' => ['RoomController@update', $room[0]->id] ]) !!}

        @include('errors.form_error')

        <div class="C_Room_Form row">
            <div class="paddingtop row">
                {!! Form::label('max_num', 'Max.Number of rooms available:',['class'=>'col-sm-2']) !!}
                <div class="col-sm-2">
                    @if(count($room)>0)
                        {!! Form::text('max_room', $room[0]->max_room, ['required' => 'required','class'=> 'form-control']) !!}
                    @else
                        {!! Form::text('max_room', null, ['required' => 'required','class'=> 'form-control']) !!}
                    @endif
                </div>

                <div class="col-sm-3">
                    <div class="pull-right">
                        <label class="pull-left text-right" style='max-width: 182px; padding-right: 5px'>
                            standard (rack) rate <br> <span class="text-lowercase">in us dollars</span>
                        </label>

                        <div class="pull-left" style="max-width: 90px;">
                            <input type="text" name="standard_rate"
                                   value="{{ $room[0]->standard_rate }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-sm-offset-1 hidden">
                    @if ($includes->count())
                        @foreach ($includes as $include)
                            @if(count($room_include)>0)
                                @if($room_include[0]["value"]== $include->value)
                                    {!! Form::radio('include', $include->id, true, ['id'=> $include->value ,'class'=>'col-sm-1']) !!}
                                @else
                                    {!! Form::radio('include', $include->id, false, ['id'=> $include->value ,'class'=>'col-sm-1']) !!}
                                @endif
                                {!! Form::label($include->value, $include->value ,['class'=>'col-sm-11']) !!}
                            @else
                                {!! Form::radio('include', $include->id, false, ['id'=> $include->value ,'class'=>'col-sm-1']) !!}
                                {!! Form::label($include->value, $include->value ,['class'=>'col-sm-11']) !!}
                            @endif

                        @endforeach
                    @endif
                </div>
            </div>

            <div class="row" id="capacity_list">

                <label class="col-sm-2">Max. Capacity</label>

                <div class="col-sm-10">
                    @for($i=0;$i<4;$i++)
                        @if(count($room)>0)
                            @if($i < (int)$room[0]->max_capacity)
                                {!! Form::checkbox('capacity[]', "1", true, ['class' => 'check','id' => $i]) !!}
                                <label for='{{ $i }}' class="checkbox">
                                    <i class="fa fa-male fa-2x"></i>
                                </label>
                            @else
                                {!! Form::checkbox('capacity[]', "1", null, ['class' => 'check','id' => $i]) !!}
                                <label for='<?php echo $i; ?>' class="checkbox">
                                    <i class="fa fa-male fa-2x"></i>
                                </label>
                            @endif
                        @else
                            {!! Form::checkbox('capacity[]', "1", null, ['class' => 'check','id' => $i]) !!}
                            <label for='<?php echo $i; ?>' class="checkbox">
                                <i class="fa fa-male fa-2x"></i>
                            </label>
                        @endif

                    @endfor
                </div>
            </div>

            <div class="submit_btn row">
                {!! Form::submit("Save All", array('class' => 'btn btn-danger')) !!}
            </div>

            <div class="row" id="tabs_container">
                <ul id="myTab" class="nav nav-tabs col-sm-12">
                    <li class="active">
                        <a href="#prices" data-toggle="tab"> PRICES & RATES </a>
                    </li>
                    <li>
                        <a href="#rooms" data-toggle="tab">OPEN/CLOSE ROOMS</a>
                    </li>
                    <li>
                        <a href="#addons" data-toggle="tab">ADD ONS</a>
                    </li>
                    <li>
                        <a href="#more" data-toggle="tab">....</a>
                    </li>
                </ul>

                <div id="myTabContent" class="tab-content row">
                    <div class="tab-pane fade in active" id="prices">
                        <div id="rate_list">
                            @if(count($rates))
                                @foreach($rates as $index => $rate)
                                    @if($rate['close_date'] >= date('Y-m-d'))

                                        <div id="room_{{  $index }}" class="rate_list_item col-sm-12">
                                            <h3 data-id="{{ $rate['id'] }}" class="rate_number col-sm-2"> Set price
                                                #{{ $index + 1 }}</h3>

                                            <div class="col-sm-2">
                                                <div class="pull-right">
                                                    <label for="rate_price" class="paddingtop"
                                                           style="text-align: right; float:left; padding-right: 5px;">
                                                        SET PRICE
                                                        <br>
                                                        <span class="text-lowercase">in us dollars</span>
                                                    </label>
                                                    <div class="paddingtop" style="max-width: 90px; float:left">
                                                        <input class="form-control rate_price" type="text"
                                                               value="{{ $rate['price'] }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 paddingtop invisible" id="include_list">
                                                @if(count($includes))
                                                    @foreach($includes as $include)
                                                        @if($rate["include_id"] == $include->id)
                                                            <div class="radio">
                                                                <label for="rate_{{ $i }}_{{ $include->value }}"
                                                                       style="width:92%;">
                                                                    <input id="rate_{{ $i }}_{{ $include->value }}"
                                                                           class="col-sm-2 rate_include" type="radio"
                                                                           value="{{ $include->id }}" checked/>
                                                                    {{ $include->value }}
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="radio">
                                                                <label for="rate_{{ $i }}_{{ $include->value }}"
                                                                       style="width:92%;">
                                                                    <input id="rate_{{ $i }}_{{ $include->value }}"
                                                                           class="col-sm-2 rate_include"
                                                                           name="rate_include{{ $i + 1 }}"
                                                                           type="radio"
                                                                           value="{{ $include->id }}"/>
                                                                    {{ $include->value }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="col-sm-3 center paddingtop">
                                                <input type="text" name="rate_duration_dates[]"
                                                       value="{{ $rate['start_date'] }} - {{ $rate['close_date'] }}"
                                                       class="form-control rate_duration_dates" disabled>
                                            </div>

                                            <div class="col-sm-1 center paddingtop">
                                                <a href="#" class="btn btn-remove remove_rate"
                                                   data-rate-id="{{ $rate['id'] }}">Remove</a>
                                            </div>

                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <div class="col-sm-12">&nbsp;</div>

                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary more_day" onClick="addrate()">
                                add one more series
                            </button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="rooms">
                        <div id="room_available_list" class="col-sm-12">
                            <table class="table">
                                <thead>
                                <th></th>
                                <th>NUMBER OF ROOMS AVAILABLE</th>
                                <th>DURATION AVAILABLE</th>
                                <th></th>
                                </thead>
                                
                                @if($room[0]->room_available->count())

                                    @foreach($room[0]->room_available as $i => $room_available)
                                        <input type="hidden" name="room_available_id[]"
                                               value="{{ $room_available->id }}">
                                        <tr>
                                            <td class="text-center">{{ ($i + 1) }}</td>
                                            <td>
                                                <input class="form-control" name="number_room_available[]" type="text"
                                                       value="{{ $room_available->number_room_available }}">
                                            </td>
                                            <td>
                                                <input type="text" name="room_available_duration_dates[]"
                                                       value="{{$room_available->start_date }} - {{ $room_available->close_date }}"
                                                       class="form-control room_available_duration_dates" readonly/>
                                            </td>
                                            <td class="center">
                                                <a href="#" class="btn btn-remove remove_room_available"
                                                   data-id="{{ $room_available->id }}">Remove</a>
                                            </td>
                                        </tr>

                                        {{--<div id="room'+roomNum+'" class="col-sm-12 room_available_list_container">--}}
                                        {{--<h3 class="col-sm-3"> Open / Close </h3>--}}
                                        {{--<div class="col-sm-2 paddingtop">--}}
                                        {{--<div class="pull-right">--}}
                                        {{--<label for="num_ava_room">--}}
                                        {{--NUMBER OF <br> ROOMS AVAILABLE:--}}
                                        {{--</label>--}}

                                        {{--<input class="form-control" name="number_room_available[]" type="text"--}}
                                        {{--value="{{ $room_available->number_room_available }}"--}}
                                        {{--style="max-width: 65px;">--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-sm-4 col-sm-offset-2 center paddingtop">--}}
                                        {{--<input type="text" name="room_available_duration_dates[]"--}}
                                        {{--value="{{$room_available->start_date }} - {{ $room_available->close_date }}"--}}
                                        {{--class="form-control room_available_duration_dates" disabled/>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-sm-1 center paddingtop">--}}
                                        {{--<a href="#" class="btn btn-remove remove_room_available"--}}
                                        {{--data-id="{{ $room_available->id }}">Remove</a>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                    @endforeach

                                @endif
                            </table>
                        </div>

                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary more_day" onClick="addRoomAvailable()"
                                    style="margin-bottom: 200px;">
                                add one more series
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="addons">
                        <h3 class="col-sm-offset-1 col-sm-11" style="float:left;">
                            Add Ons
                            <span class="paddingtop" style="font-size: 12px">
                                if the service is not available, leave empty; If FREE, enter 0.
                            </span>
                        </h3>

                        @if (count($addons))
                            @foreach ($addons as $addon)

                                <div class="col-sm-offset-1 col-sm-3">
                                    <label for="num_ava_room" class="col-sm-4 paddingtop">{{ $addon['name']}}</label>
                                    <div class="col-sm-8 paddingtop">
                                        {!! Form::text('addon_raw_value[]', $addon['price'],
                                            [
                                                'class'=> 'form-control addon_value',
                                                'data-id' => $addon['id'],
                                                'data-addon-room-id' => $addon['addon_room_id']
                                            ])
                                        !!}
                                        <input type="hidden" name="addon_value[]">
                                    </div>
                                </div>

                            @endforeach
                        @endif

                    </div>

                    <div class="tab-pane fade" id="more">
                        <h3 class="col-sm-offset-1">Coming Soon</h3>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div>
@stop

@section('script')
    <script src="{{ URL::asset('/public/js/jquery-dateFormat.min.js') }}"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script>
        (function () {
            $.fn.setDatePickers = function () {
                var start_date = new Date();

                var current_element = $(this);

                var same_element_lengths = ($(current_element.selector).length);

                $(this).focus(function () {
                    var start_date = new Date();

                    if ((same_element_lengths - 2) > -1) {
                        var last_same_element = $(current_element.selector).eq(($(current_element.selector).length) - 2);

                        var dates = last_same_element.val();

                        if (dates) {
                            dates = dates.split(' - ');

                            if (dates.length > 0) {
                                var last_close_date = new Date(dates[1]);
                                start_date.setDate(last_close_date.getDate() + 1);
                            }
                        }
                    }

                    start_date = $.format.date(start_date, "MM/dd/yyyy");

                    var close_date = new Date(start_date);
                    close_date.setDate(close_date.getDate() + 1);

                    close_date = $.format.date(close_date, "MM/dd/yyyy");

                    console.log($(this));

                    $(this).daterangepicker({
                        autoUpdateInput: false,
                        locale: {
                            cancelLabel: 'Clear'
                        },
                        startDate: start_date,
                        minDate: start_date,
                        endDate: close_date
                    }, function (start, end, label) {
                        if (start.format('MM/DD/YYYY') < start_date) {
                            return false;
                        }
                    });

                    $(this).on('apply.daterangepicker', function (ev, picker) {
                        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                    });

                    $(this).on('cancel.daterangepicker', function () {
                        $(this).val('');
                    });
                });
            };
        })(jQuery);
    </script>

    <script type="text/javascript">
        function setMessage(text, type) {
            if (typeof type == 'undefined') {
                type = 'alert-danger';
            }

            //show
            $('#message').text(text).removeClass(function (index, css) {
                return (css.match(/(^|\s)alert-\S+/g) || []).join(' ');
            }).addClass(type).slideDown(200);

            setTimeout(function () {
                //remove
                $('#message').slideUp(500).text('');

                setTimeout(function () {
                    $('#message').removeClass(function (index, css) {
                        return (css.match(/(^|\s)alert-\S+/g) || []).join(' ');
                    });
                }, 500);

            }, 5000);
        }

        var rateNum = "{{ count($rates) }}";
        var roomNum = 0;
        var addonNum = 0;

        function addrate() {
            var empty_field = 0;
            $('.rate_duration_dates').each(function () {
                if ($(this).val() == false) {
                    empty_field++;
                }
            });

            if (empty_field > 0) {
                setMessage("You cannot add another rate while one is not completed correctly.");
                return false;
            }

            rateNum++;
            var display =
                    '<div id="room' + rateNum + '" class="rate_list_item col-sm-12 section-container">'
                    + '<h3 class="col-sm-2 rate_number" data-id="0">Set price #' + rateNum + ' </h3>'
                    + '<div class="col-sm-2">'
                    + '<div class="pull-right">'
                    + '<label for="rate_price" class="paddingtop" style="text-align: right; float:left; padding-right: 5px;"> SET PRICE <br> <span class="text-lowercase">in us dollars</span></label>'
                    + '<div class="paddingtop" style="max-width: 90px; float:left">'
                    + '<input class="form-control rate_price" type="text">'
                    + '</div>'
                    + '</div>'
                    + '</div>'; // close col-sm-2 set price container div

            display += '<div class="col-sm-4 paddingtop">';

            @if(count($includes))
                    @foreach($includes as $include)
                    display += '<div class="radio">'
                    + '<label for="rate_' + rateNum + '_{{ $include->value }}" style="width:92%;">'
                    + '<input id="rate_' + rateNum + '_{{ $include->value }}" class="col-sm-2 rate_include" type="radio" value="{{ $include->id }}"/>'
                    + '{{ $include->value }}'
                    + '</label>'
                    + '</div>';
            @endforeach
                    @endif

                    display += '</div>'; //close include list div

            display += '<div class="col-sm-3 center paddingtop">'
                    + '<input type="text" name="rate_duration_dates[]" class="form-control rate_duration_dates duration_dates"/>'
                    + '</div>' //close float right div date pickers
                    + '<div class="col-sm-1 center paddingtop">'
                    + '<a href="#" class="btn btn-remove remove_unsaved_rate">Remove</a>'
                    + '</div>'
                    + '</div>'; //close container

            $("#rate_list").append(display);

            $('.rate_duration_dates').setDatePickers();
        }

        $(document.body).on('click', '.remove_unsaved_rate', function (e) {
            e.preventDefault();

            $(this).closest('.rate_list_item').remove();
        });

        $(document.body).on('click', '.remove_rate', function (e) {
            e.preventDefault();

            var btn = $(this);

            var rate_id = $(this).data('rate-id');

            $.ajax({
                url: "{{ url('rooms/ajax/remove-rate') }}",
                type: 'POST',
                data: {
                    'id': rate_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function () {
                    btn.closest('.rate_list_item').remove();
                },
                error: function () {
                    alert('Sorry!! Something went wrong.');
                }
            });
        });

        $(document.body).on('click', '.remove_unsaved_room_available', function (e) {
            e.preventDefault();

            $(this).closest('.room_available_list_container').remove();
        });

        $(document.body).on('click', '.remove_room_available', function (e) {
            e.preventDefault();

            var btn = $(this);

            var room_available_id = $(this).data('id');

            if (confirm("Click OK to confirm removing?")) {
                $.ajax({
                    url: "{{ url('rooms/ajax/remove-room-available') }}",
                    type: 'POST',
                    data: {
                        'id': room_available_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function () {
                        btn.closest('tr').remove();
                    },
                    error: function () {
                        alert('Sorry!! Something went wrong.');
                    }
                });
            }
        });

        function addRoomAvailable() {
            roomNum++;

//            var display = '<div id="room_' + roomNum + '" class="col-sm-12 paddingtop room_available_list_container">'
//                    + '<h3 class="col-sm-3"> Open / Close </h3>'
//                    + '<div class="col-sm-2 paddingtop">'
//                    + '<label for="num_ava_room">'
//                    + 'NUMBER OF <br> ROOMS AVAILABLE</label>'
//                    + '<input class="form-control" name="number_room_available[]" type="text" style="max-width: 65px;">'
//                    + '</div>'
//                    + '<div class="col-sm-4 col-sm-offset-2">'
//                    + '<input type="text" name="room_available_duration_dates[]" class="form-control room_available_duration_dates" readonly/>'
//                    + '</div>'
//                    + '<div class="col-sm-1 center">'
//                    + '<a href="#" class="btn btn-remove remove_unsaved_room_available">Remove</a>'
//                    + '</div>'
//                    + '</div>';


//            $("#room_available_list").append(display);

            var length_items = $('#room_available_list table tr').length;

            var display = '<tr>';
            display += '<td class="center">' + length_items + '</td>';
            display += '<td><input class="form-control" name="number_room_available[]" type="text"></td>';
            display += '<td><input type="text" name="room_available_duration_dates[]" class="form-control room_available_duration_dates" readonly/></td>';
            display += '<td class="center"><a href="#" class="btn btn-remove remove_unsaved_room_available">Remove</a></td>';
            display += '</tr>';

            $("#room_available_list table").append(display);

            $('.room_available_duration_dates').setDatePickers();
        }

        $('form').submit(function () {

            $('.submit_btn').attr('disabled', true);

            var form = $(this);

            $('.addon_value').each(function () {
                if ($(this).val()) {
                    var addon_value = $(this).data('id') + '_' + $(this).data('addon-room-id') + '_' + $(this).val();
                    $(this).parent().find('input[name="addon_value[]"]').val(addon_value);
                } else {
                    $(this).parent().find('input[name="addon_value[]"]').remove();
                }
            });

            $('.rate_list_item').each(function () {
                var values = '';

                var rate_id = $(this).find('.rate_number').attr('data-id');
                var rate_price = $(this).find('.rate_price').val();
                var rate_include = $(this).find('.rate_include:checked').val();
                var rate_duration_dates = $(this).find('.rate_duration_dates').val();

                values = 'id=>' + rate_id + ','
                        + 'price=>' + rate_price + ','
                        + 'include=>' + rate_include + ','
                        + 'duration_dates=>' + rate_duration_dates;

                form.append('<input type="hidden" name="rate[]" value="' + values + '">');
            });
        });

        $(function () {
            $(document.body).on('click', '.btn btn-remove', function (e) {
                e.preventDefault();

                $(this).closest('.section-container').remove();
            });
        });

        $(function () {
            function closeEditBox() {
                var room_name_container = $('#room_name');

                room_name_container.prepend('<span>' + $('#txt_new_room_name').data('current-value') + '<span>');
                $('#edit_room_name').show();

                $('#btn_cancel_edit_room_name').remove();
                $('#btn_save_room_name').remove();
                $('#txt_new_room_name').remove();
            }

            $('#edit_room_name').click(function (e) {
                e.preventDefault();

                var btn = $(this);
                var parent = btn.closest('h1');
                var current_value = parent.find('span').text();

                parent.append('<input type="text" name="new_room_name" id="txt_new_room_name" data-current-value="' + current_value + '"/>');
                parent.append('<button class="btn btn-success disabled" id="btn_save_room_name">Save</button><button class="btn btn-danger" id="btn_cancel_edit_room_name">Cancel</button>');
                parent.find('input').val(current_value).focus();
                parent.find('span').remove();
                btn.hide();
            });

            $('h1').on('keyup', '#txt_new_room_name', function () {
                if ($(this).val() == '' || $(this).val() == $(this).data('current-value')) {
                    $('#btn_save_room_name').addClass('disabled');
                } else {
                    $('#btn_save_room_name').removeClass('disabled');
                }
            });

            $('h1').on('click', '#btn_save_room_name', function () {
                var new_name = $('#txt_new_room_name').val();

                var btn = $(this);
                var parent = btn.closest('h1');
                var id = parent.data('id');

                $.ajax({
                    url: "{{ url('rooms/ajax/update-name') }}",
                    type: 'POST',
                    data: {
                        'id': id,
                        'new_name': new_name,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            $('#txt_new_room_name').data('current-value', response.saved_name);
                            closeEditBox();
                        }
                    },
                    error: function () {
                        alert('Sorry!! Something went wrong.');
                    }
                });
            });

            $('h1').on('click', '#btn_cancel_edit_room_name', function () {
                closeEditBox();
            });

        });

        //upload room image
        $(function () {
            $(document).ready(function () {
                var options = {
                    beforeSubmit: showRequest,
                    success: showResponse,
                    dataType: 'json'
                };
                $('body').delegate('#image', 'change', function () {
                    $('#image_preview').show();
                    $('#upload').ajaxForm(options).submit();
                });
            });
            function showRequest(formData, jqForm, options) {
                $("#validation-errors").hide().empty();
                $("#image_preview").css('display', 'none');
                return true;
            }

            function showResponse(response, statusText, xhr, $form) {
                if (response.success == false) {
                    var arr = response.errors;
                    $.each(arr, function (index, value) {
                        if (value.length != 0) {
                            $("#validation-errors").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                        }
                    });
                    $("#validation-errors").show();

                    $('#btnSaveRoomPic').attr('disabled', 'disabled');
                } else {
                    $('#btnSaveRoomPic').attr('disabled', false);
                    $("#image_preview").html("<img src='" + response.file + "' />");
                    $("#image_preview").css('display', 'block');
                }
            }
        });

        //save room picture
        $(function () {
            $('#btnSaveRoomPic').click(function () {
                var img = $("#image_preview img").attr('src');
                var id = $(this).data('id');

                $.ajax({
                    url: "{{ url('rooms/ajax/update-pic-name') }}",
                    type: 'POST',
                    data: {
                        'id': id,
                        'image': img,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('.C_Room_img').attr('src', response.saved_photo);
                        $('#uploadRoomImageModal').modal('hide');
                        $('#image_preview').hide();
                    },
                    error: function () {
                        alert('Sorry!! Something went wrong.');
                    }
                });
            });
        });

        //cancel saving room picture
        function removePic() {
            var img = $("#image_preview img").attr('src');

            if (img) {

                $.ajax({
                    url: "{{ url('rooms/ajax/cancel-room-pic') }}",
                    type: 'POST',
                    data: {
                        'image': img,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $("#image_preview img").remove();
                        $('#image_preview').hide();
                    },
                    error: function () {
                        alert('Sorry!! Something went wrong.');
                    }
                });
            }
        }

        $(function () {
            $('#btnCancelRoomPic').click(function () {
                removePic();
            });

            $('#image_preview_remove').click(function () {
                removePic();

                $('#image').trigger('click');
            });
        });

        $('#showUploadRoomImageModal').click(function () {
            $('#image_preview img').remove();
            $('#btnSaveRoomPic').attr('disabled', 'disabled');
        });

        $(function () {
            $('.upload_form').hover(function () {
                if ($('#image_preview img').length > 0) {
                    $('#image_preview_remove').stop().show();
                }
            }, function () {
                $('#image_preview_remove').stop().hide();
            });
        });

    </script>
@stop
