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

        .txt_addon_name {
            text-transform: uppercase;
            color: #666;
            font-weight: 600;
        }

        .txt_addon_name:focus, .txt_addon_name:hover {
            color: #111;
        }

        td:not(:first-child) {
            text-align: center;
        }
    </style>
@stop

@section('content')
    <h2> Add ons & Amenities </h2>
    <a class="btn btn-primary" id="btn_create">Create Add on</a>
    <div style="margin: 20px 0;"></div>

    <div id="message" class="alert alert-success" role="alert" style="display: none;">test</div>

    @if ($Addons->count())
        <table class="table table_tour table-striped">
            <thead>
            <tr>
                <th>Addons</th>
                <th width="120px"></th>
                <th width="70px"></th>
            </tr>
            </thead>

            <tbody>
            <?php $i = 0; ?>
            @foreach ($Addons as $addon)

                <?php $i++; ?>
                <tr>
                    <td class="txt_addon_name" contenteditable="true">
                        {{ $addon->name }}
                    </td>
                    <td>
                        <a data-id="{{ $addon->id  }}" class="saveAddonText btn" href="#" style="display: none;">Save</a>
                    </td>
                    <td>
                        <a data-id="{{ $addon->id  }}" class="deleteAddon" href="#">
                            <i class="text-danger fa fa-trash-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <h3> There are no Addons</h3>
        </div>
    @endif

@stop

@section('script')
    <script>
        var base_url = "{{ url() }}";

        $('#btn_create').click(function (e) {
            e.preventDefault();

            $('table tbody').append('<tr><td class="txt_addon_name" id="last_added" contenteditable="true"></td><td><a id="addAddon" class="btn" href="#">Save</a></td><td><a id="deleteUnsavedAddon" href="#"><i class="text-danger fa fa-trash-o fa-2x"></i></a></td></tr>');

            $('html, body').animate({
                scrollTop: $("table tbody tr:last-child").offset().top
            }, 500);

            $('#last_added').focus();
        });
//
//        $('table').on('blur', '#last_added', function () {
//            if($(this).text() == '') {
//                $(this).closest('tr').remove();
//            }
//        });

        $('table').on('click', '#addAddon', function (e) {
            e.preventDefault();

            var btn = $(this);

            var text = $(this).closest('tr').find('.txt_addon_name').text();

            $.ajax({
                url: base_url + "/addon/ajax/create",
                type: 'POST',
                data: {
                    'name': text,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#message').text(response.text).show();

                    $('#deleteUnsavedAddon')
                            .addClass('deleteAddon')
                            .data('id', response.id)
                            .removeAttr('id');

                    btn.removeAttr('id').addClass('saveAddonText');

                    $('.saveAddonText').data('id', response.id);

                    setTimeout(function () {
                        $('#message').hide(500);
                    }, 3000);
                }
            });
        });

        $('table').on('click', '#deleteUnsavedAddon', function (e) {
            e.preventDefault();

            var target = $(this).closest('tr');

            target.hide('slow', function(){ target.remove(); });
        });

        $('tr').on('keypress', '.txt_addon_name', function() {
            $('.saveAddonText').hide();

            $(this).parent().find('.saveAddonText').show();
        });

        $('tr').on('blur', '.txt_addon_name', function() {
            $('.saveAddonText').hide();
        });

        $('table').on('click', '.saveAddonText', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var text = $(this).closest('tr').find('.txt_addon_name').text();

            $.ajax({
                url: base_url + "/addon/ajax/update",
                type: 'POST',
                data: {
                    'id': id,
                    'name': text,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#message').text(response.text).show();

                    setTimeout(function () {
                        $('#message').hide(500);
                    }, 3000);
                }
            });
        });

        $('table').on('click', '.deleteAddon', function(e) {
            e.preventDefault();

            var btn = $(this);

            var id = $(this).data('id');
            var text = $(this).closest('tr').find('.txt_addon_name').text();

            $.ajax({
                url: base_url + "/addon/ajax/destroy",
                type: 'POST',
                data: {
                    'id': id,
                    'name': text,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#message').text(response.text).show();

                    var target = btn.closest('tr');

                    target.hide('slow', function(){ target.remove(); });

                    setTimeout(function () {
                        $('#message').hide(500);
                    }, 3000);
                }
            });
        });
    </script>
@stop
