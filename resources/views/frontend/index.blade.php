@extends('frontend.layout')

@section('style')

@stop

@section('content')

    <div class="container">
        <div id="message" class="alert alert-danger" role="alert" style="display: none">&nbsp;</div>
    </div>

    <div id="step_1">
        <div id="choose_dates" class="row action_container active">
            <div class="col-sm-12">
                <div class="col-sm-4">
                    <p class="col-sm-12">&nbsp;</p>
                    <h4 class="action_title" id="action_title_1">1 - Choose the dates</h4>
                </div>

                <div class="col-sm-4" id="checkin_container">
                    <p class="col-sm-12" id="checkin_label">Check in </p>
                    <input type="text" id="checkin" name="checkin"
                           class="form-control input-model datepicker ll-skin-latoja" readonly>
                    <span class="hide_on_active"></span>
                </div>
                <div class="col-sm-4" id="checkout_container">
                    <p class="col-sm-12" id="checkout_label">Check out </p>
                    <input type="text" id="checkout" name="checkout"
                           class="form-control input-model datepicker ll-skin-latoja" readonly>
                    <span class="hide_on_active"></span>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-4 pull-right">
                    <p>&nbsp;</p>

                    <a href="#" type="button" class="btn btn_next show_on_active pull-right"
                       id="btn_cancel_update_dates">
                        Cancel
                    </a>
                    <a href="#step1" type="button" class="btn btn-default btn_next show_on_active pull-right"
                       id="btn_next_1">
                        Next
                    </a>
                </div>
            </div>
        </div>

        <div id="select_suits" class="row action_container">
            <div class="col-sm-12">
                <div class="col-sm-8">
                    <h2 class="action_title">2 - select your suite</h2>
                </div>
                <div class="col-sm-4 show_on_active">
                    <button type="button" class="btn btn-default btn_back" id="btn_back_1">
                        Back
                    </button>
                </div>
            </div>
            <div class="col-sm-12">
                @if (count($rooms))
                    @foreach ($rooms as $room)
                        <div class="col-sm-4">
                            <div class="room_list_container">
                                @if( $room['number_room_available'] - $room['number_booked_room'] < 1)
                                    <div class="sold_out_image_title">
                                        <p><span>Sold Out</span></p>
                                        <img class="room_list_image" src="{{ $room['photo'] }}"/>
                                    </div>

                                    <p class="room_name">{{ $room['name'] }}</p>
                                @else
                                    {{--if has promotion--}}
                                    @if($room['price'])
                                        <div class="special_offer_image_title show_on_active">
                                            <p class="special_offer_label">
                                                <span><i class="fa fa-star"></i></span>
                                                <span>Special Offer</span>
                                                <span><i class="fa fa-star"></i></span>
                                            </p>
                                        </div>

                                        <img class="room_list_image" src="{{ $room['photo'] }}"/>
                                        <p class="room_name"> {{ $room['name'] }}</p>
                                        <p class="text-line-through show_on_active room_price">
                                            {{ money_format('%i', $room['standard_rate']) }}
                                        </p>
                                        <p class="red show_on_active room_price" style="font-weight: 600">
                                            {{ money_format('%i', $room['price']) }}
                                        </p>

                                        {{--no promotion--}}
                                    @else
                                        <img class="room_list_image" src="{{ $room['photo'] }}"/>
                                        <p class="room_name">{{ $room['name'] }}</p>
                                        <p class="show_on_active red-darker room_price">
                                            {{ money_format('%i', $room['standard_rate']) }}
                                        </p>
                                        <p class="show_on_active">&nbsp;</p>
                                    @endif

                                    <div class="show_on_active">
                                        <label for="">Select number of room needed</label>
                                        <div style="margin: 0 auto; width: 20px;">
                                            <input class="input_select_room checkbox" name="txt_rooms_selected[]"
                                                   type="checkbox" value="{{ $room['id'] }}">
                                        </div>
                                        <div class="col-sm-12" style="margin-top: 20px;">
                                            <select name="number_of_room" class="number_of_room" style="display: none;">
                                                @for($i=1; $i<$room['number_room_available']; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endif

                            </div>

                        </div>
                    @endforeach
                @endif
            </div>

            <div class="col-sm-12">
                <div class="col-sm-8">
                    &nbsp;
                </div>
                <div class="col-sm-4">
                    <a href="#step2" type="button" class="btn btn-default btn_next" id="btn_next_2"
                       style="display: none;">
                        Continue
                    </a>
                </div>
            </div>
        </div>

        <div class="row step_footer">
            &nbsp;
        </div>

    </div>

    <div id="step_2" style="display: none;">
        <div class="row action_container active">
            <div class="booked_dates section container">
                <div class="col-sm-4">
                    <p class="red">Check in</p>
                    <p class="checkin"></p>
                </div>
                <div class="col-sm-4">
                    <p class="red">Check out</p>
                    <p class="checkout"></p>
                </div>
                <div class="col-sm-4">
                    <p class="red">Total Nights</p>
                    <p class="total_nights"></p>
                </div>
                <div class="edit_dates col-sm-12">
                    <button class="btn" id="btn_edit_dates">Modify your dates</button>
                </div>
            </div>

            <div class="booked_room_list container section no-border-bottom">
                @foreach($rooms as $order => $room)
                    <?php $room_temp_price = ($room['price']) ? $room['price'] : $room['standard_rate'] ?>
                    <div class="col-sm-12 book_room_list_template section row"
                         id="book_room_list_template_{{ $room['id'] }}_1"
                         data-temp="true">
                        <div class="col-sm-12">
                            <div class="col-sm-1 room_order">
                                <span>{{ $order + 1}}</span>
                            </div>

                            <div class="col-sm-4">
                                <p class="room_name">{{ $room['name'] }}</p>
                                <div class="txt_calculation_formula calculation_method"
                                     data-original-price="{{ $room['standard_rate'] }}"
                                     data-promo-price="{{ $room['price'] }}"
                                     data-promo-start-date="{{ $room['promotion_start_date'] }}"
                                     data-promo-close-date="{{ $room['promotion_close_date'] }}">

                                </div>
                            </div>

                            <div class="col-sm-offset-1 col-sm-4">
                                <ul class="nav addon_list" data-room-id="{{ $room['id'] }}">
                                    @if(count($addons_room))
                                        @foreach($addons_room as $addon)
                                            @if($addon['room_id'] == $room['id'])
                                                <li data-id="{{ $addon['addon_id'] }}">
                                                    <label class="checkbox text-right addon_label">
                                                        <input class="input_checkbox checkbox check_addon"
                                                               type="checkbox" value="{{ $addon['addon_id'] }}">
                                                        {{ $addon['name'] }}
                                                        @if($addon['price'] == 0)
                                                            (FREE)
                                                        @else
                                                            ($ {{ money_format('%i', $addon['price']) }})
                                                        @endif

                                                        <span class="hidden" data-id="{{ $addon['addon_id'] }}">
                                                        {{ money_format('%i', $addon['price']) }}
                                                    </span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="col-sm-2 addon_price_calculated math_list">
                                <p class="room_temp_total">
                                    {{ money_format('%i', $room_temp_price) }}
                                </p>

                                <div class="addon_price_math_list"></div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-10">&nbsp;</div>
                            <div class="col-sm-2 math_list">
                                <p class="room_final_total">
                                    {{ money_format('%i', $room_temp_price) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row step_footer">
            <div class="container">
                {{--<div class="container">--}}
                {{--<input type="text" id="total_price_all_rooms"--}}
                {{--class="total_price_all_rooms form-control btn_next text-right" readonly/>--}}
                {{--</div>--}}
                <div class="section col-sm-12 no-border-bottom proceed_booking">
                    <button type="button" class="btn btn_back pull-left show_on_active" id="btn_back_3">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-default btn_next show_on_active" id="btn_next_3">
                        Proceed
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="step_3" style="display: none;">
        <div class="row action_container active">
            <div class="booked_dates section container">
                <div class="col-sm-12">
                    <div class="col-sm-3">
                        <p class="red">Check in</p>
                        <p class="checkin"></p>
                    </div>
                    <div class="col-sm-3">
                        <p class="red">Check out</p>
                        <p class="checkout"></p>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-4">
                            <p class="red">Total Nights</p>
                            <p class="total_nights"></p>
                        </div>
                        <div class="col-sm-4">
                            <p class="red">Total Rooms</p>
                            <p class="total_rooms"></p>
                        </div>
                        <div class="col-sm-4">
                            <p>&nbsp;</p>
                            <p class="total_price_all_rooms"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="final_form_container" class="section container no-border-bottom">
                {!! Form::open(array('url'=>'/booking', 'method'=>'POST', 'id' => 'final_form', 'class' => 'form-inline','role' => 'form')) !!}
                <div class="container">
                    <div class="form-group col-sm-12">
                        <label class="radio">
                            <input class="input_radio radio use_radio_type" name="status" type="checkbox" value="mr"
                                   checked> Mr
                        </label>
                        <label class="radio">
                            <input class="input_radio radio use_radio_type" name="status" type="checkbox" value="mrs">
                            Mrs
                        </label>
                        <label class="radio">
                            <input class="input_radio radio use_radio_type" name="status" type="checkbox" value="ms"> Ms
                        </label>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>First name </p>
                                <p class="required_star">*</p>
                            </label>
                            <input type="text" class="form-control" name="firstname" id="firstname"/>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>Last name </p>
                                <p class="required_star">*</p>
                            </label>
                            <input type="text" class="form-control" name="lastname" id="lastname"/>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>Email address </p>
                                <p class="required_star">*</p>
                            </label>
                            <input type="text" class="form-control" name="email" id="email"/>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>Repeat Email address </p>
                                <p class="required_star">*</p>
                            </label>
                            <input type="text" class="form-control" name="re_email" id="re_email" autocomplete="off"/>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="form-group col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>Country of origin</p>
                            </label>
                            <select name="country" class="form-control" required id="country">
                                <option disabled selected>-- Select your Country</option>

                                <?php
                                $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
                                ?>

                                @for($i = 0;$i < count($countries);$i++)
                                    <option value='{{ $countries[$i] }}'>{{ $countries[$i] }}</option>
                                @endfor
                            </select>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>Telephone</p>
                            </label>
                            <input type="text" class="form-control" name="contact_phone" id="contact_phone"/>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="form-group col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>&nbsp;</p>
                            </label>
                            <label class="checkbox" style="margin-top: 40px;">
                                <input class="input_checkbox checkbox" name="first_time_guest" type="checkbox">
                                <span class="text-uppercase" style="padding-left: 8px; font-weight: 600;">First time guest</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group col-sm-12">
                            <label>
                                <p>Number of guests </p>
                                <p class="required_star">*</p>
                            </label>
                            <input type="text" class="form-control" name="number_of_guests" id="number_of_guests"/>
                            <div class="col-sm-5 messages"></div>
                        </div>
                    </div>
                </div>

                <div style="padding: 30px">&nbsp;</div>

                {!! Form::close() !!}
            </div>
        </div>
        <div class="row step_footer">
            <div class="container">
                <a href="#step3" type="button" class="btn btn-default btn_next show_on_active" id="btn_next_4">
                    Proceed
                </a>
            </div>
        </div>
    </div>

    <div id="data"></div>

@stop

@section('script')
    <script src="{{ url('public/js/accounting.min.js') }}"></script>
    <script type='text/javascript'>

        $(document).ready(function () {
            localStorage.removeItem("skip_room_select");

            $("#checkin").datepicker({
                defaultDate: '+1w',
                minDate: 0,
                firstDay: 0,
                dateFormat: 'MM dd yy',
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    var minDate = $(this).datepicker('getDate');
                    var newMin = new Date(minDate.setDate(minDate.getDate()));
                    $("#checkout").datepicker("option", "minDate", newMin);

                    $("#checkin").next('span').text($("#checkin").val());
                }
            }).datepicker('widget').wrap('<div class="ll-skin-latoja"/>');

            $("#checkout").datepicker({
                defaultDate: "+1w",
                minDate: '+0d',
                changeMonth: true,
                firstDay: 0,
                dateFormat: 'MM dd yy',
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    var maxDate = $(this).datepicker('getDate');
                    var newMax = new Date(maxDate.setDate(maxDate.getDate()));
                    $("#checkin").datepicker("option", "maxDate", newMax);

                    $("#checkout").next('span').text($("#checkout").val());
                }
            }).datepicker('widget').wrap('<div class="ll-skin-latoja"/>');

            setDefaultDatesValue();

            $('.edit_date').click(function () {
                $(this).find('input').focus();
            });

            $("#new_checkin_date").datepicker({
                defaultDate: "+1w",
                minDate: 0,
                firstDay: 0,
                dateFormat: 'MM dd yy',
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    var minDate = $(this).datepicker('getDate');
                    var newMin = new Date(minDate.setDate(minDate.getDate()));
                    $("#new_checkout_date").datepicker("option", "minDate", newMin);

                    $("#new_checkout_date").next('span').text($("#new_checkin_date").val());
                }
            }).datepicker('widget').wrap('<div class="ll-skin-latoja"/>');

            $("#new_checkout_date").datepicker({
                defaultDate: "+1w",
                minDate: '+0d',
                changeMonth: true,
                firstDay: 0,
                dateFormat: 'MM dd yy',
                numberOfMonths: 1,
                onClose: function (selectedDate) {
                    var maxDate = $(this).datepicker('getDate');
                    var newMax = new Date(maxDate.setDate(maxDate.getDate()));
                    $("#new_checkin_date").datepicker("option", "maxDate", newMax);

                    $("#new_checkout_date").next('span').text($("#new_checkout_date").val());

                    setRoomPrice(calcTotalNights());
                }
            }).datepicker('widget').wrap('<div class="ll-skin-latoja"/>');
        });

        function setDefaultDatesValue() {
            $("#checkin").datepicker('setDate', new Date());
            $("#checkin").next('span').text($("#checkin").val());

            $("#checkout").datepicker('setDate', '+1');
            $("#checkout").next('span').text($("#checkout").val());
        }

        function setEditDatesValues() {
            $('#new_checkin_date').val($('#checkin').val());
            $('#new_checkout_date').val($('#checkout').val());
        }

        function scrollTo(element) {
            $('html, body').animate({
                scrollTop: element.offset().top
            }, 500);
        }

        function errorMessage(msg) {
            $('#message').text(msg).show();

            setTimeout(function () {
                $('#message').show();
            }, 3000);

            return false;
        }

        function diffDates(d1, d2) {
            var date1 = moment(new Date(d1));
            var date2 = moment(new Date(d2));

            return date2.diff(date1, 'days') + 1;
        }

        function dateGreaterEqualThan(d1, d2) {
            var date1 = moment(new Date(d1));
            var date2 = moment(new Date(d2));

            return date1.diff(date2, 'days') >= 0;
        }

        function dateSmallerEqualThan(d1, d2) {
            var date1 = moment(new Date(d1));
            var date2 = moment(new Date(d2));

            return date2.diff(date1, 'days') >= 0;
        }

        function calcTotalNights() {
            return diffDates($('#checkin').val(), $('#checkout').val());
        }

        function calcRoomPrice(room_price, total_nights) {
            return formatMoney(total_nights * currencyToNumber(room_price));
        }

        function setRoomPrice(total_nights) {
            $('.room_price').each(function () {
                $(this).text(calcRoomPrice($(this).text(), total_nights));
            });
        }

        function defineSkipStepRoomSelect() {
            localStorage.skip_room_select = "yes";
        }

        function isSkipStepRoomSelect() {
            return (localStorage.getItem("skip_room_select") != null);
        }

        $(document).ready(function () {
            $('#btn_next_1').click(function () {
                if ($("#checkin").val() == '' || $("#checkout").val() == '') {
                    return errorMessage('Check in and Check out date must not be blank.');
                }

                if (isSkipStepRoomSelect()) {
                    openStep_2();
                } else {
                    var next_to_element = $('#select_suits');
                    var current_action_element = $('#choose_dates');

                    $("#checkout, #checkin, #checkin_label, #checkout_label, #action_title_1").hide();
                    next_to_element.addClass('active');
                    current_action_element.removeClass('active');
                }

                setRoomPrice(calcTotalNights());

                setEditDatesValues();

                //scrollTo(next_to_element);

            });

            $('#btn_back_1').click(function (e) {
                e.preventDefault();

                var back_to_element = $('#choose_dates');
                var current_action_element = $('#select_suits');

                $("#checkout, #checkin, #checkin_label, #checkout_label, #action_title_1").show();
                back_to_element.addClass('active');
                current_action_element.removeClass('active');

                scrollTo(back_to_element);

            });
        });

        function resetLocalData() {
            var rooms_selected = [];
            $("input[name='txt_rooms_selected[]']").each(function () {
                if ($(this).is(':checked')) {
                    var arr = {
                        'id': $(this).val(),
                        'number_selected': $(this).parent().parent().find('select.number_of_room').val()
                    };

                    rooms_selected.push(arr);
                }
            });

            var total_rooms = $('.book_room_list_template').length;
            var total_nights = diffDates($('#checkin').val(), $('#checkout').val());
            var total_price_all_rooms = $('.total_price_all_rooms').val();

            var data = {
                'checkin': $('#checkin').val(),
                'checkout': $('#checkout').val(),
                'total_nights': total_nights,
                'total_rooms': total_rooms,
                'total_price_all_rooms': total_price_all_rooms,
                'rooms': rooms_selected
            };

            $('#data').data('local', data);
        }

        function getLocalData() {
            return $('#data').data('local');
        }

        function openStep_1(skip_begining) {
            $('#step_2').hide();
            $('#step_3').hide();
            $('#step_1').show();

            if (typeof skip_begining == 'undefined') {
                var back_to_element = $('#choose_dates');
                var current_action_element = $('#select_suits');

                $("#checkout, #checkin, #checkin_label, #checkout_label, #action_title_1").show();
                back_to_element.addClass('active');
                current_action_element.removeClass('active');
            }
        }

        function openStep_2() {
            var step_1 = $('#step_1');
            var step_2 = $('#step_2');

            step_1.hide();
            step_2.show();

            resetLocalData();

            var data = getLocalData();
            var checkin_date = data.checkin;
            var checkout_date = data.checkout;
            var total_nights = calcTotalNights();

            $('.booked_dates .checkin').text(checkin_date);
            $('.booked_dates .checkout').text(checkout_date);
            $('.booked_dates .total_nights').text(total_nights);

            /* duplicate room list by number of room user selected */
            $('.book_room_list_template').attr('data-temp', 'true');
            for (var i = 0; i < (data.rooms).length; i++) {
                /*
                 * div with id #book_room_list_template_* is created to build layout of room list
                 * this div is temporary as default (temporary has attribute data-temp=true)
                 * when it's temporary it's unusable, so we enable them by setting data-temp=false
                 * */
                $('#book_room_list_template_' + data.rooms[i].id + '_1').attr('data-temp', 'false');
            }

            /*
             * now all template that is not used, it's removed
             * */
            $('.book_room_list_template[data-temp=true]').hide();
            $('.book_room_list_template[data-temp=false]').show();

            /*
             * the addons inside room list that are not selected we set the price to blank
             */
            $.each($('.book_room_list_template[data-temp=false]'), function (k, v) {
                var room = $(this);
                room.data('order', (k));
                room.find('.room_order').text('Room ' + (k + 1));

                $.each(room.find('.addon_list li'), function () {
                    var addon = $(this);
                    var addon_id = addon.data('id');

                    if ($('#addon_id_' + addon_id).length > 0) {
                        $('#addon_id_' + addon_id).remove();
                    }

                    addon
                            .closest('.book_room_list_template')
                            .find('.addon_price_math_list')
                            .append('<p id="addon_id_' + addon_id + '">&nbsp;</p>');

                    $('.check_addon').prop('checked', false);
                });

                /*
                 * show calculation method
                 */
                var calculation_method = $(this).find('.calculation_method');
                var original_price = parseFloat(calculation_method.data('original-price'));
                var promo_price = parseFloat(calculation_method.data('promo-price'));
                var promo_start_date = calculation_method.data('promo-start-date');
                var promo_close_date = calculation_method.data('promo-close-date');

//                console.log(data);
//                console.log(data.rooms[0]);

                var selected_room_id = data.rooms[0].id;

                console.log(selected_room_id);

                $.ajax({
                    type: 'POST',
                    url: "{{  url('get-calculated-room-price') }}",
                    data: {
                        'id': selected_room_id,
                        'checkin': checkin_date,
                        'checkout': checkout_date,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            var calculation_method_content = '';
                            var price_per_room = 0;

                            $.each(response.datas, function (key, data) {
                                price_per_room += (data['total_nights'] * data['price']);
                                calculation_method_content += '<p class="room_calculated_price" data-price="' + (data['total_nights'] * data['price']) + '">';
                                calculation_method_content += '<span>' + data['total_nights'] + ' ' + (data['total_nights'] > 1 ? 'nights' : 'night') + '</span>';
                                calculation_method_content += '<span> x </span>';
                                calculation_method_content += '<span> ' + data['price'] + ' </span>';

                                if (key == 'in_promo') {
                                    calculation_method_content += '<span class="special_offer_label">[special offer]</span>'
                                }

                                calculation_method_content += '</p>';

                                calculation_method_content += '<p class="booking_dates">';
                                calculation_method_content += '<span>' + data['dates'][0] + ' | ' + data['dates'][1] + '</span>';
                                calculation_method_content += '</p>';
                            });

                            calculation_method.html(calculation_method_content);

                            $('.total_room_price, .room_temp_total, .room_final_total').text(formatMoney(price_per_room));

//                            $('.room_calculated_price').each(function() {
//                                $('.total_room_price, .room_temp_total, .room_final_total').text();
//                            });
                        }
                    },
                    error: function () {
                        alert('Sorry!! Something went wrong.');
                    }
                });

//                var calculation_method_content = '';
//                //checkin date is in day of promotion
//                if(dateGreaterEqualThan(checkin_date, promo_start_date) && dateSmallerEqualThan(checkin_date, promo_close_date)) {
//                    console.log('in promotion checking');
//                }
//
//                else if(dateGreaterEqualThan(checkout_date, promo_start_date) && dateSmallerEqualThan(checkout_date, promo_close_date)) {
//                    console.log('in promotion checkout');
//                }
//
//                else {
//                    calculation_method_content += '<p>';
//                    calculation_method_content += '<span>' + total_nights + (total_nights > 1 ? 'nights' : 'night') + '</span>';
//                    calculation_method_content += '<span> x </span>';
//                    calculation_method_content += '<span>'+ original_price +'</span>';
//                    calculation_method_content += '</p>';
//                    calculation_method_content += '<p>'+ checkin_date + ' | ' + checkout_date +'</p>';
//                }
//
//                calculation_method.html(calculation_method_content);

                //$(this).find('span.total_nights').text(total_nights);

//                $(this).find('.total_room_price, .room_temp_total, .room_final_total').text(
//                        formatMoney(parseInt($(this).find('span.total_nights').eq(0).text()) * price_per_room)
//                );

                //re-append new value to .total_nights with label night/nights
                //$(this).find('span.total_nights').text(total_nights + ' ' + ((total_nights > 1) ? 'nights' : 'night'));
            });

            calcTotalAllRoom();
            resetLocalData();

            $('.total_rooms').text(getLocalData().total_rooms);
        }

        function currencyToNumber(currency) {
            return Number(currency.replace(/[^0-9\.]+/g, ""));
        }

        function formatMoney(number) {
            return accounting.formatMoney(number, "", 2, ",", ".");
        }

        function calcTotalAllRoom() {
            var total_price_all_rooms = 0;
            $.each($('.room_final_total'), function () {
                total_price_all_rooms += parseFloat(currencyToNumber($(this).text()));
            });

            $('.total_price_all_rooms').val(total_price_all_rooms.toFixed(2));
        }

        $(document.body).on('click', '#btn_cancel_update_dates', function () {
            openStep_2();
        });

        $('#btn_edit_dates').click(function () {
            openStep_1();
            defineSkipStepRoomSelect();
            $('#btn_next_1').text('Update');
            $('#btn_cancel_update_dates').show();
        });

        $('#btn_back_3').click(function () {
            openStep_1(true);
        });

        $('#btn_next_2').click(function () {
            openStep_2();
        });

        $(function () {
            $('.use_radio_type').change(function () {
                $('.use_radio_type').not(this).attr('checked', false);
            });
        });

        $(function () {
            $('.input_select_room').change(function () {
                //remove other checks to keep only one room type per one reservation
                $('.input_select_room').not(this).attr('checked', false);
                $('.show_on_active').find('select[name="number_of_room"]').hide();

                if ($('.input_select_room:checked').length > 0) {
                    $('#btn_next_2').show();
                } else {
                    $('#btn_next_2').hide();
                }

                if ($(this).is(':checked')) {
                    $(this).closest('.show_on_active').find('select[name="number_of_room"]').show();
                } else {
                    $(this).closest('.show_on_active').find('select[name="number_of_room"]').hide();
                }
            });
        });

        $(function () {
            $(document.body).on('change', '.check_addon', function () {
                var stored_value_element = $(this).parent().find('span');
//                var value = parseFloat(stored_value_element.text()) * parseInt($('.total_nights').eq(0).text());
                var value = parseFloat(stored_value_element.text());
                var id = stored_value_element.data('id');

                if ($(this).is(':checked')) {
                    $(this).closest('.book_room_list_template').find('#addon_id_' + id).text(formatMoney(value));
                } else {
                    $(this).closest('.book_room_list_template').find('#addon_id_' + id).html("&nbsp;");
                }

                var room_temp_total = currencyToNumber($(this).closest('.book_room_list_template').find('.room_temp_total').text());
                var total_addons = 0;

                $.each($(this).closest('.book_room_list_template').find('.addon_price_math_list p'), function () {
                    total_addons += parseFloat(currencyToNumber($(this).text()));
                });

                var room_final_total = parseFloat(room_temp_total) + parseFloat(total_addons);

                $(this).closest('.book_room_list_template').find('.room_final_total').text(formatMoney(room_final_total));

                calcTotalAllRoom();
            });
        });

        $(function () {
            $('#btn_next_3').click(function (e) {
                e.preventDefault();

                var step_2 = $('#step_2');
                var step_3 = $('#step_3');

                step_2.hide();
                step_3.show();

                $.each($('.book_room_list_template ul.addon_list'), function () {
                    var room = $(this);
                    var value = room.data('room-id') + '=>';

                    $.each(room.find('li input:checked'), function () {
                        var addon = $(this);

                        value += addon.val() + ',';
                    });

                    $('#final_form').append('<input type="hidden" name="room_with_addons[]" value="' + value + '">');
                });

                resetLocalData();
                var data = getLocalData();

                $('#final_form').append('<input type="hidden" name="checkin" value="' + data.checkin + '">');
                $('#final_form').append('<input type="hidden" name="checkout" value="' + data.checkout + '">');
                $('#final_form').append('<input type="hidden" name="total_nights" value="' + data.total_nights + '">');
                $('#final_form').append('<input type="hidden" name="total_rooms" value="' + data.total_rooms + '">');
                $('#final_form').append('<input type="hidden" name="total_price_all_rooms" value="' + data.total_price_all_rooms + '">');
            });
        });

        /**
         * Validation form
         */

        $(function () {
            var form = $('#final_form');
            form.validate({
                rules: {
                    firstname: {
                        required: true
                    },
                    lastname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    re_email: {
                        required: true,
                        email: true,
                        equalTo: '#email'
                    },
                    number_of_guests: {
                        required: true,
                        number: true
                    }
                },
                messages: {},
                errorPlacement: function (error, element) {
                    var placement = element.closest('.form-group').find('.messages');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#btn_next_4').on('click', function () {
                if (form.valid()) {
                    form.submit();
                }
            });
        });

    </script>
@stop
