////////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: main.js
////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
  //Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  //Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {
    //Add a click event on each of them
    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () {
        // Get the target from the "data-target" attribute
        var target = $el.dataset.target;
        var $target = document.getElementById(target);
        //Toggle the class on both the "navbar-burger" and the "navbar-menu"
        $el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  }
});


//Modals
var buttons = Array.from(document.getElementsByClassName('modal-button'));
for (var i = 0; i < buttons.length; i++) {
  var button = buttons[i];
  var target = document.querySelector(button.dataset.target);
  button.addEventListener("click", function(e) {
    target.classList.toggle('is-active');
  }, false);
}
  var buttons = Array.from(document.getElementsByClassName('modal-button-delay'));
for (var i = 0; i < buttons.length; i++) {

  var button = buttons[i];
  var target = document.querySelector(button.dataset.target);
  button.addEventListener("click", function(e) {
    setTimeout(function(){
    target.classList.toggle('is-active');
    },1000);
  }, false);
}

//Next we create the code for adding new room action.
$('#add_new_room').on('click',function(e){
  e.preventDefault();
  var room_number = $('input[name=room_number]').val();
  var address = $('input[name=address]').val();

  //We validate the data.
  if(room_number.length == 0 || address.length == 0){
    swal('','All fields are required.','warning');
  }else{ //Here we proceed with the adding.
    $.post('ajax_add_room.php',{'room_number':room_number,'address':address},function(e){
      console.log(e);
      var resp = JSON.parse(e);

      //Next we parse the returned data and check if it was added.
      if(resp.success){
        $('button.delete').click();
        if($(document).find('button.delete.modal-button') > 0) { 
         $('button.delete.modal-button').trigger('click');
        }

        $('input[name=room_number]').val('');
        $('input[name=address]').val('');

        swal({
          type: 'success',
          title: 'Room was successfully added',
          showConfirmButton: false,
          timer: 2000
        });

        //Next we compose the html that will be appended.
        var new_tr = "<tr ref='"+resp.data+"'>";
            new_tr += "<td class='has-text-centered'><strong>"+room_number+"</strong></td>";
            new_tr += "<td class='has-text-centered'>"+address+"</td>";
            new_tr += "<td class='has-text-centered'><a href='editroom.php?ref="+resp.data+"'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i></a>&nbsp;<a href='' ref='"+resp.data+"' class='delete_a'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a> </td>";

        //Then we append the new record in the table behind.
        $('#rooms_tbl').find('tbody').append(new_tr);
        }else{ 
        if(resp.msg.length > 0){
          swal('Failed!',resp.msg,'warning');
        }else{
          swal('Failed!','Something went wrong please try again later.','warning');
        }
      }
    });
  }
}) 


$('.view_stat').on('click',function(){
  var ref = $(this).attr('ref');
  var tr = $('tr[ref='+ref+']');
  var room_num = tr.find('#room_num').text();
  var address = tr.find('#address').text();
  var updated_by = tr.find('#last_update').val();
  var date = tr.find('#date').val();
  var hrs = tr.find('#hrs').val();
  var stat = tr.find('#stat').val();
  var status = (stat == '0') ? 'Pending' : 'Clean';
  var desc = tr.find('#desc').val();

  $('.modal-card-title').find('strong').text(' Room: '+room_num+' - '+address);
  $('.modal-card-body').find('.description').html(desc);
  $('.modal-card-body').find('label#stat').text(status);
  $('.modal-card-body').find('label#updated_by').text(updated_by);
  $('.modal-card-body').find('label#update_date').text(date);
  $('.modal-card-body').find('label#update_hrs').text(hrs);
  $('#cleaning_performed').attr('ref', ref);

   if(stat == '0'){
    $('#cleaning_performed').attr('checked', false);
   }else{
    $('#cleaning_performed').attr('checked', true);
  }
});


//Here we detect if the checkbox has been checked or unchecked to update the cleaning status.
$(document).on('change','#cleaning_performed',function(){
  var do_clean = $(this).is(':checked');
  var room_ref = $(this).attr('ref');
  console.log(room_ref);

  //Then we send the update to the backend.
  $.post('./updatecleaning.php',{'ref':room_ref,'status':do_clean},function(resp){
    var response = JSON.parse(resp);
    if(response.success == '1'){
      var stat_room_cleaned = parseInt($('p#stat_room_cleaned').text());
      var stat_room_tocleaned = parseInt($('p#stat_room_toclean').text());
      if(do_clean){
        $('tr[ref='+room_ref+']').find('label#stat_desc').text('Cleaned ');
        $('tr[ref='+room_ref+']').find('#stat').val('1');
        $('p#stat_room_cleaned').text(stat_room_cleaned + 1);
        $('p#stat_room_toclean').text(stat_room_tocleaned - 1);
      }else{
        $('tr[ref='+room_ref+']').find('label#stat_desc').text('Pending ');
        $('tr[ref='+room_ref+']').find('#stat').val('0');
        $('p#stat_room_toclean').text(stat_room_tocleaned + 1);
        $('p#stat_room_cleaned').text(stat_room_cleaned - 1);
      }

      $('footer.modal-card-foot').find('button').click();
      swal('Success!','Cleaning status was updated.','success');
    }else{
      swal('Failed!','Please try again later','warning');
    }
  });
});


//Here we detect if delete room has been clicked.
$(document).on('click','.delete_a',function(e){
  e.preventDefault();
      var ref = $(this).attr('ref');
    //Then we run a confirm dialog. 
      swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false,
    },function () {
      //Next we send the data to php for processing.
      $.post('ajax_delete_room.php',{'ref':ref},function(resp){
        if(resp){ // if successful deletion
          $('tr[ref='+ref+']').remove();
          swal(
            'Deleted!',
            'The room has been deleted.',
            'success'
          );
        }else{ //If not successfulL.
           swal('Failed!','Please try again later','warning');
        }
      })
    })
});


//Here we detect if delete user has been clicked. 
$(document).on('click','.delete_users',function(e){
  e.preventDefault();
      var ref = $(this).attr('ref');
    //Then we run a confirm dialog. 
      swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false
    },function () {
      //Next we send the data to php for processing.
    $.post('ajax_delete_user.php',{'ref':ref},function(resp){
      if(resp){ //If successful deletion.
        $('tr[ref='+ref+']').remove();
        swal(
          'Deleted!',
          'The user has been deleted.',
          'success'
        );
      }else{ //if not successful
        swal('Failed!','Please try again later','warning');
      }
    })
  })
});