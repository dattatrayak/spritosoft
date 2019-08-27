function fnEdit(id) {
    alert(id);
    $('[name="hidDataId"]').val(id);
    $(".formClassHid").submit();
}

function fnDelete(id) {
   var r = confirm("Do you want to delete this recoreds?");
    if (r == true) {
       $('[name="hidDeleteId"]').val(id);
     $(".formClassHidele").submit();
    } 
}
function showDataLink(str) {
    window.location = base_url + 'admin/' + str;
}
function showState(stateId, CountryId) {
    $.ajax({
        url: base_url + 'admin/getData/get_states_option',
        dataType: 'json',
        type: 'POST',
        data: {'csrf_spritosoft_name': $("input[name='csrf_spritosoft_name']").val(),
            'CountryId': CountryId},
        success: function (data)
        {
            $('#' + stateId).find('option:not(:first)').remove();
            $.each(data, function (val, text) {
                $('#' + stateId).append($('<option></option>').val(text.id).html(text.name))
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            $('#status').text('Server Error');
        }
    });
}
function showSlug(nextId,str) { 
    var Text = str; 
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    $("#" + nextId).val(Text);
}
$(document).ready(function(){
   $('.only_number').on('keydown',function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()}); 
   $('.not_enter_next_line').bind('keypress', function(e) { if(e.keyCode==13){ e.preventDefault();  }});
});