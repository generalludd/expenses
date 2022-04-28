jQuery.noConflict();

jQuery(document).ready(function ($) {

    new ClipboardJS('.copy[data-clipboard-text]');
    $(function () {
        $('.copy,.payment-row .amt').tooltip({trigger:'click',animation: true,title:"Copied!"}).animate({'fade':500});
    })
    $(document).on("click", ".delete.inline", function (e) {
        e.preventDefault();
        let my_url = $(this).attr("href");
        let my_id = $(this).data("id");
        let my_target = $(this).data('target');
        let form_data = {
            id: my_id,
            ajax: 1,
        };
        let question = confirm("Are you sure you want to delete this? This cannot be undone!");
        if (question) {
            $.ajax({
                url: my_url,
                type: "post",
                data: form_data,
                success: function (data) {
                    $(my_target).html(data);
                },
                failure: function (data) {
                }

            })
        }
    });

    $(document).on('click', ".edit.inline", function (e) {
        e.preventDefault();
        let me = $(this);
        let my_callback = me.attr('href');
        let my_value = me.data("value");
        let my_id = me.data("id");
        let my_name = me.data("field_name");
        let my_user = me.data("user_id");
        let my_target = me.data("target");
        let form_data = {
            id: my_id,
            user_id: my_user,
            ajax: 1,
            field_name: my_name,
            value: my_value,
        };
        $.ajax({
            url: my_callback,
            type: "post",
            data: form_data,
            success: function (data) {
                $(my_target).html(data);
                me.removeClass("edit").addClass("update");
            },
            failure: function (data) {
                console.log(data);
            }
        });

    });
    $(document).on("change", ".ajax.inline select", function (e) {
        let me = $(this);
        let my_id = me.data("id");
        let my_value = me.val();
        let my_name = me.data("name");
        let form_data = {
            id: my_id,
            ajax: 1,
            field_name: my_name,
            value: my_value
        };
        $.ajax({
            url: '/transaction/update_value',
            type: "post",
            data: form_data,
            success: function (data) {
                //my_parent.html(data.my_value);
            },
            failure: function (data) {
                console.log(data);
            }
        })

    });
    $(document).on("change", ".ajax.inline input", function (e) {
        let me = $(this);
        let my_value = me.val();
        let my_id = me.data("id");
        let my_name = me.data("name");
        let form_data = {
            id: my_id,
            ajax: 1,
            field_name: my_name,
            value: my_value
        };
        $.ajax({
            url: '/transaction/update_value',
            type: "post",
            data: form_data,
            success: function (data) {
                me.animate({
                    color: "green"
                }, 1500);
            },
            failure: function (data) {
                console.log(data);
            }
        })

    });
    $(document).on('click', '.batch-update', function (e) {
        e.preventDefault();
        let uri_callback = $(this).data('uri');
        let data = [];
        $('.transaction').each(function (e) {
            data.push($(this).data('id'));
        });
        let form_data = {
            ajax: 1,
            transaction_ids: data,
            return_path: uri_callback
        };
        $.ajax({
            type: "post",
            data: form_data,
            url: $(this).attr('href'),
            success: function (data) {
                $("#popup").html(data);
                $("#my_dialog").modal("show");
            }
        });
    });


    $(document).on("change", ".select-wrapper select", function (e) {
        let my_value = $(this).val();
        let my_name = $(this).attr('name');
        let my_wrapper = $(this).data('wrapper');
        if (my_value === 'other') {
            $('#' + my_wrapper).html("<input type='text' name='" + my_name + "' value=''/>");
        }
    });

    $(document).on("mouseup", ".edit_preference", function (event) {
        let myUser = $('#user_id').val();
        let myType = this.id;
        let myValue = $('#' + this.id).val();
        let myTarget = "stat" + myType;
        $('#' + myTarget).html("").show();
        let myUrl = base_url + "index.php/preference/update/";
        let form_data = {
            user_id: myUser,
            type: myType,
            value: myValue,
            ajax: 1
        };
        $.ajax({
            url: myUrl,
            type: "POST",
            data: form_data,
            success: function (data) {
                $('#' + myTarget).html(data).fadeOut(3000);
            }
        });
    });


    $(document).on("click", ".menu_item_add", function () {
        let myUrl = base_url + "index.php/menu/create_item/";
        $.ajax({
            type: "GET",
            url: myUrl,
            success: function (data) {
                showPopup("Create Menu Item", data, "auto");
            }
        });
    });


    $(document).on('click', "#browser_warning",
        function () {
            $(".notice").fadeOut();
        }
    );

    $(document).on("click", ".new.dialog,.edit.dialog", function (e) {
        e.preventDefault();
        show_popup(this);

    });

});

function showPopup(myTitle, data, popupWidth, x, y) {
    if (!popupWidth) {
        popupWidth = 300;
    }
    let myDialog = jQuery('<div id="popup">').html(data).dialog({
        autoOpen: false,
        title: myTitle,
        modal: true,
        width: popupWidth
    });

    if (x) {
        myDialog.dialog({position: x});
    }


    myDialog.fadeIn().dialog('open', {width: popupWidth});

    return false;
}

function toggle_navigation(me, toggle) {
    if (toggle === "show") {
        jQuery("#navigation").fadeIn();
        jQuery(me).removeClass("show-navigation");
        jQuery(me).addClass("hide-navigation");
        jQuery(me).html("Hide Navigation");
    } else if (toggle === "hide") {
        jQuery("#navigation").fadeOut();
        jQuery(me).removeClass("hide-navigation");
        jQuery(me).addClass("show-navigation");
        jQuery(me).html("Show Navigation");
    }
}

function show_popup(me) {
    let target = jQuery(me).attr("href");
    let form_data = {
        ajax: 1
    };

    let window_width = jQuery(window).width();
    jQuery.ajax({
        type: "get",
        data: form_data,
        url: target,
        success: function (data) {
            jQuery("#popup").html(data);
            jQuery("#my_dialog").modal("show");
        }
    });
}


function delete_entity(me) {
    let target = jQuery(me).attr("href");
    let my_id = me.id.split("_")[1];
    let my_parent = jQuery(me).parents(".row").attr("id");

    let question = confirm("Are you sure you want to delete this? This cannot be undone!");
    if (question) {

        let form_data = {
            ajax: 1,
            id: my_id
        }
        jQuery.ajax({
            type: "post",
            data: form_data,
            url: target,
            success: function (data) {
                if (jQuery(me).hasClass("inline")) {
                    jQuery("#" + my_parent).remove();
                } else if (jQuery(me).hasClass("redirect")) {
                    window.location.href = data;
                } else {
                    jQuery("#popup").html(data);
                    jQuery("#my_dialog").modal("show");
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

function copy_text(my_text) {
    my_text.select();
    my_text.setSelectionRange(0, 999999);
    document.execCommand('copy');


}
