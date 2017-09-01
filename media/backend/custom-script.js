$(document).ready(function () {
    /* Marketing page script start */
    $('.addSenderModalAdd').on('click', '.addContactBtn', function(){
         var total_user = $('#total_user').val();
             var a = 1;
              var i = parseInt(total_user) + parseInt(a);
        $('.addNewContactWrap').show();
        var newContactRow = '<tr>'+
                '<td>'+
                  '<input type="text" class="form-control"  name="first_name[]" id="first_name'+i+'">' +
                '</td>'+
                '<td>'+
                  '<input type="text" class="form-control"  name="last_name[]" id="last_name'+i+'">'+
                '</td>'+
                '<td>'+
                  '<input type="text" class="form-control"  name="email[]" id="email'+i+'">'+
                '</td>'+
                  '<td>'+
                  '<select name="country_code[]" id="country_code"><option value="">Select Code</option> '+
                  '<option value="+971">(+971)Dubai</option>'+
                  '<option value="+91">(+91)IND</option>'+
                  '<option value="+61">(+61)AUS</option>'+
                  '<option value="+55">(+61)BRA</option>'+
                   '<option value="+855">(+855) Cambodia</option>'+
                   '</select>'+
                '</td>'+
                
                '<td>'+
                 
                  '<input type="text" class="form-control"  name="mobile[]" id="mobile'+i+'">'+
                '</td>'+
                
                '<td>'+
                  '<button  class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>'+
                '</td>'+
              '</tr>';
        $('.addNewContactWrap tbody').append(newContactRow);
        
    });
    $('.addNewContactWrap table').on('click', '.btn', function(){
        $(this).closest('tr').remove();
    });
    $('.addNewContactWrap').on('click', '.cancelNewConatct', function(){
        $('.addNewContactWrap').hide();
    });
    
    
    
    
    
    $('.addSenderModaledit').on('click', '.addContactBtn', function(){
        
          $('.addNewContactWrapedit').css('display','block');
         var total_user = $('#total_user_edit').val();
             var a = 1;
              var i = parseInt(total_user) + parseInt(a);
        $('.addNewContactWrap').show();
        var newContactRow = '<tr id="deleteTR'+i+'">'+
                '<td>'+
                  '<input type="text" class="form-control"  name="first_name_edit[]" id="first_name_edit'+i+'">' +
                '</td>'+
                '<td>'+
                  '<input type="text" class="form-control"  name="last_name_edit[]" id="last_name_edit'+i+'">'+
                '</td>'+
                '<td>'+
                  '<input type="text" class="form-control"  name="email_edit[]" id="email_edit'+i+'">'+
                '</td>'+
                  '<td>'+
                  '<select name="country_code_edit[]" id="country_code_edit"><option value="">Select Code</option> '+
                  '<option value="+971">(+971)Dubai</option>'+
                  '<option value="+91">(+91)IND</option>'+
                  '<option value="+61">(+61)AUS</option>'+
                  '<option value="+55">(+61)BRA</option>'+
                   '<option value="+855">(+855)Cambodia</option>'+
                   '</select>'+
                '</td>'+
                 '<td>'+
                  '<input type="text" class="form-control"  name="mobile_edit[]" id="mobile_edit'+i+'">'+
                '</td>'+
                '<td>'+
                  '<button type="button"  class="btn btn-danger btn-sm" onClick="deleterow('+i+')"><i class="fa fa-trash"></i></button>'+
                '</td>'+
              '</tr>';
        $('.addNewContactWrap tbody').append(newContactRow);
        
    });
    
    
//     $('.addNewContactWrapedit table').on('click', '.btn', function(){
//        $(this).closest('tr').remove();
//    });
//    $('.addNewContactWrap').on('click', '.cancelNewConatct', function(){
//        $('.addNewContactWrap').hide();
//    });
    
    
    
    /* Marketing page script end */
    
});

// function is used to set languages
function setlang(id){
    var id = id.options[id.selectedIndex].value;
    $.ajax({
        url: setLanguageURL,
        data: {lang_id: id},
        type: "POST",
        success: function(data) {
            if (data != '') {
                window.location.reload();
            }
        }
    });
}