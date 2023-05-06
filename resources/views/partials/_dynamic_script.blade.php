<script>
    function errorMessage(message){
        Snackbar.show({text: message, pos: 'bottom-center'});
    }

    function showMessage(message){
        Snackbar.show({text: message, pos: 'bottom-center'});
    }

    function ajaxMethodCall(selectDiv) {

        var $this = $(selectDiv),
            loadurl = $this.attr('data-href'),
            targ = $this.attr('data-target'),
            id = selectDiv.id || '';

        $.post(loadurl, function(data) {
            $(targ).html(data);
            $('form').append('<input type="hidden" name="active_tab" value="'+id+'" />');
        });

        $this.tab('show');
        return false;
    }

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".calentimDatepickerCurr").calentim({
            showHeader :false,
            singleDate: true,
            autoAlign : true,
            calendarCount: 1,
            showTimePickers: false,
            format : 'DD-MM-Y',
            autoCloseOnSelect : true,
            startEmpty : true,
        });

        $(document).on('mouseenter','table.dataTable .tooltip',function(){
            $(this).parent().addClass('overflow-visible').removeClass('overflow-hidden');
        });
        $(document).on('mouseout','table.dataTable .tooltip',function(){
            $(this).parent().addClass('overflow-hidden').removeClass('overflow-visible');
        });

        $(document).on('click', '.loadRemoteModel', function(e)
        {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url.indexOf('#') == 0) {
                $(url).modal('open');
            }
            else {
                $.get(url, function(data)
                {
                     $('#remoteModelData').html(data);
                     $('#remoteModelData').modal();
                });
            }
        });

        $(document).on('click', '[data-toggle="tabajax"]', function(e) {
            e.preventDefault();
            var selectDiv = this;
            ajaxMethodCall(selectDiv);
        });

        $(document).on('click', '[data--toggle="delete"]', function (e) {
            e.preventDefault();
            let url = $(this).attr('data--url');
            if (url !== undefined) {

                $.confirm({
                    title: 'Are you sure ?',
                    content: $(this).attr('data-title'),
                    type: 'red',
                    buttons: {
                        ok: {
                            text: "Yes",
                            btnClass: 'btn-primary disabled',
                            keys: ['enter'],
                            action: () => {
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        _method: "DELETE"
                                    },
                                    success: (data) => {

                                        if (data.status !== undefined && data.status === true){
                                            if(data.remove_tr === true){
                                                let length=$(this).parents('tr').find('td').length;
                                                let tbody = $(this).parents('table').find('tbody');
                                                $(this).parents('tr').remove();
                                                
                                                if($(this).parents('tbody').find('tr').length == 0){
                                                    tbody.append('<tr><td class="text-center" colspan="'+length+'">{{ trans('messages.no_data_available_in_table') }}</td></tr>');
                                                }
                                            }
                                            $('#table').DataTable().ajax.reload();
                                            // $("#table").data.reload();
                                            showMessage(data.message);
                                        } else if  (data.status !== undefined && data.status === false) {
                                            showMessage(data.message);
                                        } else {
                                            showMessage("Internal server error");
                                        }

                                    },
                                    error: (error) => {
                                        if (error.responseJSON !== undefined && error.responseJSON.message !== undefined) {
                                            showMessage(error.responseJSON.message);
                                        } else {
                                            showMessage("Internal server error");
                                        }
                                    }
                                });
                            }
                        },
                        cancel: () => {
                            console.log('the user clicked cancel');
                        }
                    }
                });
            }
        });
    });
</script>
