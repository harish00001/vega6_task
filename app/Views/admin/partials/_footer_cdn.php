<script src="<?=base_url('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?=base_url('admin-assets/libs/simplebar/simplebar.min.js')?>"></script>
<script src="<?=base_url('admin-assets/libs/node-waves/waves.min.js')?>"></script>
<script src="<?=base_url('admin-assets/libs/feather-icons/feather.min.js')?>"></script>
<script src="<?=base_url('admin-assets/js/pages/plugins/lord-icon-2.1.0.js')?>"></script>



<script src="<?=base_url('admin-assets/libs/choices/choices.min.js')?>"></script>
<script src="<?=base_url('admin-assets/libs/flatpicker/flatpicker.min.js')?>"></script>
<script src="<?=base_url('admin-assets/libs/tostify/tostify.min.js')?>"></script>

<!-- apexcharts -->
<script src="<?=base_url('admin-assets/libs/apexcharts/apexcharts.min.js')?>"></script>

<!-- Vector map-->
<script src="<?=base_url('admin-assets/libs/jsvectormap/js/jsvectormap.min.js')?>"></script>
<script src="<?=base_url('admin-assets/libs/jsvectormap/maps/world-merc.js')?>"></script>

<!--Swiper slider js-->
<script src="<?=base_url('admin-assets/libs/swiper/swiper-bundle.min.js')?>"></script>

<!-- Dashboard init -->
<script src="<?=base_url('admin-assets/js/pages/dashboard-ecommerce.init.js')?>"></script>

<!-- App js -->
<script src="<?=base_url('admin-assets/js/app.js')?>"></script>

<!-- Notification Lib -->
<script src="<?= base_url('admin-assets/libs/awesome-notification/index.var.js') ?>"></script>
<script src="<?= base_url('admin-assets/libs/awesome-notification/indexvar.js') ?>"></script>

<!-- Globle easy custom JS -->
<script src="<?= base_url('admin-assets/js/easy.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    var afterView = ''
    //     function tabActive(fld) {
    //     $('ul.tabList li').removeClass('active');
    //     $(fld).parent().addClass('active');
    //     var id = $(fld).parent().data('id');
    //     $('.tabBox').removeClass('active');
    //     $('#tab' + id).addClass('active');
    // }

    function baseURL() {
        var setUrl = $('input#setUrl').val();
        if (setUrl == undefined || setUrl == '') {
            url = window.location.href.split("?")[0].split("#")[0];
        } else {
            url = setUrl;
        }

        if (!url || (url && url.length === 0)) {
            return "";
        }
        return url ? url : "";
    }

    function changeTab(tabId) {
        var tabButtons = document.querySelectorAll('.nav-link[data-id]');
        var tabPanes = document.querySelectorAll('.tab-pane[data-tab]');

        // Deactivate all tab buttons and tab panes
        tabButtons.forEach(button => button.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('show', 'active'));

        // Activate the selected tab button and tab pane
        var selectedButton = document.querySelector('.nav-link[data-id="' + tabId + '"]');
        var selectedPane = document.querySelector('.tab-pane[data-tab="' + tabId + '"]');

        // Check if both the selected button and pane exist
        if (selectedButton && selectedPane) {
            selectedButton.classList.add('active');
            selectedPane.classList.add('show', 'active');
        } else {
            console.error('Tab ID ' + tabId + ' not found.');
        }
    }


    function getAddRec() {
        var frmText = $('.frm').text();
        var frmTextArr = frmText.split(' ');
        if (frmTextArr[0].toLowerCase() == 'add') {
            $('.frm').text($('.frm').text().replace('Edit', 'Add'));
            $('#dataFrm').trigger("reset");
            $('#dataFrm').find('select').trigger('change');
            // $('#dataFrm').find('select').select2();
            $('#dataFrm').removeClass('editActive').addClass('addActive');
            $("#checkconnection").hide();
            $("#database_showbox").hide();
            $("#checksshconn").show();
            $("#checkdbconn").show();

            if (afterView != undefined) {
                if (typeof afterView === 'function')
                    afterView();
            }
        }
        changeTab(2);
    }

    //Get List
    function getList(order_by, sort_by, commonCls) {
        console.trace("where")
        if (order_by != null && order_by != undefined) {
            $('#order_by').val(order_by);
        } else {
            var order_by = $('#order_by').val();
        }

        if (sort_by != null && sort_by != undefined) {
            $('#sort_by').val(sort_by);
        } else {
            var sort_by = $('#sort_by').val();
        }
        var page = baseURL();
        var target = $('#dataList');
        var recToShow = $('#recToShow').val();
        var pageNo = $('#pageNo').val();
        var form = $('#srchFrm').serializeArray();
        $('.list-filters').find('span.badge').html('');
        var filterCnt = 0;
        for (var i = 0; i < form.length; i++) {
            if ($.inArray(form[i].name, ['list_type', 'list_id', 'recToShowH', 'pageNoH', 'sortNameH', 'sortTypeH']) === -1 && form[i].value != '') {
                filterCnt++;
            }
        }
        if (filterCnt > 0) {
            $('.list-filters').find('span.badge').html(filterCnt);
        }
        $.ajax({
            url: page + '/getList',
            data: {
                'recToShow': recToShow,
                'pageNo': pageNo,
                'search': form,
                order_by: order_by,
                sort_by: sort_by
            },
            type: 'POST',
            beforeSend: function() {
                $(".loaderAjax").show();
            },
            success: function(data) {
                $(".loaderAjax").fadeOut("slow");
                $('#3tab').css('display', 'none');

                if (data) {
                    target.empty().html(data);
                    if ($('div.pagination-content').length > 0 && $('#paging').length > 0) {

                        $('div.pagination-content').html($('#paging').find('td').find('.pagination'));

                    }
                    getList.called = true;
                } else {
                    alert("Try Again");
                }

                if (data) {
                    target.empty().html(data);
                    getList.called = true;
                } else {
                    alert("Try Again");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $(".loaderAjax").fadeOut("slow");
                // getNotify('Erro', "Error: " + errorThrown, 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert( "Error: " + errorThrown);
            }
        });
    }
    //Pagination
    function pagination(count, type, fld) {

        var page = $(fld).closest('.listTableWrap').find('.paginationVal').val();
        var countF = '';
        if (count == 'F') {
            countF = 1;
        } else if (count == 'P') {
            countF = parseInt(page) - 1;
        } else if (count == 'N') {
            countF = parseInt(page) + 1;
        } else if (count == 'L') {
            var total = $(fld).closest('.listTableWrap').find('.pagination').data('page');
            countF = total;
        } else {
            countF = count;
        }

        if (type == 'AJAX') {
            $(fld).attr('class', 'btn mythemecolor');
            $(fld).parents('.content-wrapper').find('.paginationVal').val(countF);
            $(fld).parents('.content-wrapper').find('.srchFrm *[name="search"]').trigger('click');
        } else if (type == 'LINK') {
            $(fld).closest('.listTableWrap').find('input[name="pageNo"]').val(countF);
            $(fld).closest('form').submit();
        }
    }

    $('th.sorting').on('click', function(e) {
        var currTh = this;
        $('th.sorting').each(function(index, elem) {
            if (currTh != elem) {
                $(elem).removeClass('sorting_asc').removeClass('sorting_dsc');
            }
        });
        var orderby = $(currTh).data('column');
        $('#order_by').val(orderby);
        if ($(currTh).hasClass('sorting_asc')) {
            $(currTh).removeClass('sorting_asc').addClass('sorting_dsc');
            $('#sort_by').val('desc');
        } else if ($(currTh).hasClass('sorting_dsc')) {
            $(currTh).removeClass('sorting_dsc').addClass('sorting_asc');
            $('#sort_by').val('asc');
        } else {
            $(currTh).addClass('sorting_asc');
            $('#sort_by').val('asc');
        }
        getList();
    });

    //Get Edit Record
function getEditRec(id) {
    $('#id').val(id);
    var page = baseURL();
    if (id == '') return false;
    $.ajax({
        type: 'POST',
        url: page + '/getEditRec',
        data: {
            'id': id
        },
        dataType: "json",
        beforeSend: function() {
            $(".loaderAjax").show();
        },
        success: function(result) {
            $(".loaderAjax").fadeOut("slow");
            $('#3tab').css('display', 'block');
            changeTab(2);
            $('.frm').text($('.frm').text().replace('Add', 'Edit'));
            $('#dataFrm').removeClass('addActive').addClass('editActive');
            $('#editBtn').attr('onClick', 'editRec(' + id + ')');
            // $('#printpdf').attr('onClick', 'printPdf(' + id + ')');
            $('[type="checkbox"]').prop('checked', false);

            $.each(result.data, function(i, item) {
                
                var fld = $('#dataFrm').find('*[name="' + i + '"]');
                var type = fld.attr('type');
                if (type == 'password') {
                    fld.attr('placeholder', '*****');
                    fld.removeAttr('required');
                    fld.val('');
                    fld.rules('remove', 'required');
                } else if (type == 'checkbox') {
                    if (item == 1) { fld.prop('checked', true); }
                } else if (type == 'radio') {
                    $('input[name="' + i + '"]' + "[value='" + item + "']").prop("checked", true);
                } else if (type != 'radio') {
                    fld.val(item);
                }
                fld.trigger('change');
            });
            // $('#dataFrm').find('select').select2();
            getEditRec.called = true;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $(".loaderAjax").fadeOut("slow");
            // getNotify('Erro',"Error: " + errorThrown, 'danger');
            new AWN({
                                position: 'top-right'
                            }).alert( "Error: " + errorThrow);
        }
    });
}
function goToList() {
    // debugger;
    // console.log('here');
    $('#3tab').css('display', 'none');
    $('.frm').trigger("reset");
    // location.reload();
    getList();
    changeTab(1);
    $('.frm').text($('.frm').text().replace('Edit', 'Add'));
    $('#dataFrm').removeClass('editActive').addClass('addActive');
    $("#dataFrm").validate().resetForm();
    $("#dataFrm").find('.form-label, .form-control').removeClass('errorJS');
}


//Add Record
function addRec() {
    var page = baseURL();
    var validate = validationCheck('#dataFrm');
    if (validate != 1) return false;
    if (!$('#dataFrm').valid()) {
        return false;
    }
    var formElem = document.getElementById('dataFrm');
    var formData = new FormData(formElem);

    $.ajax({
        type: 'POST',
        url: page + '/addRec',
        data: formData,
        processData: false,
        contentType: false,
        // async: false,
        dataType: "json",
        beforeSend: function () {
            $(".loaderAjax").show();
        },
        success: function (result) {
            $(".loaderAjax").fadeOut("slow");
            if (result.statusCode == 200) {
                addRec.called = true;
                goToList();
                getNotify('Record added sucessfully', 'success');
                new AWN({
                                position: 'top-right'
                            }).success('Record added sucessfully');
            } else if (result.statusCode == 422) {
                // getNotify('Details already exist', 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert('Details already exist');
            } else if (result.statusCode == 401) {
                // getNotify('Access Denied', 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert('Access Denied');
            } else if (result.statusCode == 400) {
                // getNotify(result.error, 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert(result.error);
            } else {
                // getNotify("Failed Please Try Again", 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert("Failed Please Try Again");
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $(".loaderAjax").fadeOut("slow");
            // getNotify("Error: " + errorThrown, 'danger');
            new AWN({
                                position: 'top-right'
                            }).alert( "Error: " + errorThrown);
        }
    });
}

function validationCheck(form) {
    var response = 1;
    $(form + " input," + form + " select").each(function (index) {
        var attr = $(this).attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            if ($(this).val() == '' || $(this).val() == 'NULL' || $(this).val() == 'null' || $(this).val() == null) {
                $(this).parent().addClass('has-error');
                $(this).prop('placeholder', '*Required');
                // getNotify('Please fill all required field', 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert(  $(this).parent().find('tabal').val()+'Please fill all required field');
                response = 0;
                // return false;
            } else {
                var typ = $(this).data('type');
                var val = $(this).val();
                if (typ == 'email') {
                    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                    if (!filter.test(val)) {
                        $(this).parent().addClass('has-error');
                        // getNotify('Invalid Email', 'danger');
                        new AWN({
                                position: 'top-right'
                            }).alert( 'Invalid Email');
                        response = 0;
                        // return false;
                    }
                } else if (typ == 'number') {
                    if (!val.match(/^\d+$/)) {
                        $(this).parent().addClass('has-error');
                        // getNotify('Numeric Value Only', 'danger');
                        new AWN({
                                position: 'top-right'
                            }).alert( 'Numeric Value Only');
                        response = 0;
                        // return false;
                    }
                }
                $(this).parent().removeClass('has-error');
                // return true;
            }
        } else if ($(this).val() != '') {
            var typ = $(this).data('type');
            var val = $(this).val();
            if (typ == 'email') {
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (!filter.test(val)) {
                    $(this).parent().addClass('has-error');
                    // getNotify('Invalid Email', 'danger');
                    new AWN({
                                position: 'top-right'
                            }).alert( 'Invalid Email');
                    response = 0;
                    // return false;
                }
            } else if (typ == 'number') {
                if (!val.match(/^\d+$/)) {
                    $(this).parent().addClass('has-error');
                    // getNotify('Numeric Value Only', 'danger');
                    new AWN({
                                position: 'top-right'
                            }).alert( 'Numeric Value Only');
                    response = 0;
                    // return false;
                }
            }
            $(this).parent().removeClass('has-error');
        }
    });
    return response;
}
//Edit Record
function editRec(id) {
    // alert("D")
    var page = baseURL();
    var validate = validationCheck('#dataFrm');
    if (validate != 1) return false;
    if (!$('#dataFrm').valid()) {
        return false;
    }
    var formElem = document.getElementById('dataFrm');
    var formData = new FormData(formElem);
    formData.append('editId', id);
    // console.log(formData)
    $.ajax({
        type: 'POST',
        url: page + '/editRec',
        data: formData,
        processData: false,
        contentType: false,
        // async: false,
        dataType: "json",
        beforeSend: function () {
            $(".loaderAjax").show();
        },
        success: function (result) {
            $(".loaderAjax").fadeOut("slow");
            if (result.statusCode == 200) {
                editRec.called = true;
                goToList();
                // getNotify('Record updated sucessfully', 'success');
                new AWN({
                                position: 'top-right'
                            }).success( 'Record updated sucessfully');

            } else if (result.statusCode == 422) {
                // getNotify('Details already exist', 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert( 'Details already exist');
            } else if (result.statusCode == 401) {
                // getNotify('Access Denied', 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert( 'Access Denied');
            } else if (result.statusCode == 400) {
                // getNotify(result.error, 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert( result.error);
            } else {
                // getNotify("Failed Please Try Again", 'danger');
                new AWN({
                                position: 'top-right'
                            }).alert("Failed Please Try Again");
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $(".loaderAjax").fadeOut("slow");
            // getNotify("Error: " + errorThrown, 'danger');
            new AWN({
                                position: 'top-right'
                            }).alert( "Error: " + errorThrown);
        }
    });
}





function checkNumericValue(e) {
    var val = e.target.value;
    if (!val.match(/^\d+$/)) {
        e.target.value = '';
    }
}
function numericFldKeyUp(e) {
    var code = e.keyCode;
    if ((code == 17 || code == 86) || (code == 17 || code == 67) || (code == 17 || code == 187) ||
        (code >= 48 && code <= 57) ||
        (code >= 96 && code <= 105) || ([8, 9, 37, 39, 46, 107].indexOf(code) != -1)) {
        return true;
    } else {
        e.preventDefault();
        e.target.value = '';
        return false;
    }
}
function capitaliseFldKeyUp(e) {
    e.target.value = e.target.value.toUpperCase();
    return true;
}

    $(document).ajaxComplete(function(event, XMLHttpRequest, ajaxOptions) {
        if (getList.called == true) {
            $('#paging').remove();
        }

    });



</script>
