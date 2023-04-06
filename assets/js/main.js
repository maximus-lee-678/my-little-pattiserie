$(document).ready(function () {
    console.log("TESTTESTSETSTET");
// Enable fields for user to update
  $("#edit-changes").click(function () {
    $(".editable").removeAttr("disabled");
  });
  
// Show order status
  $("#check-button").click(function () {
    var order_id = $("#order_id").val();  
    $.ajax({
      type: "POST",
      url: "./includes/order-status.inc.php",
      data: {order_id: order_id},
      success: function(data) {
        $("#display-order-status").addClass("mt-4 alert alert-success alert-dismissible text-center");
        $("#display-order-status").html(data);
      }
    });  
  });

   //Clear order status modal when closed
    $('#orderStatus').on('hidden.bs.modal', function () {
        $("order_id").val("").end();
        $("#display-order-status").html("");
        $("#display-order-status").removeClass("mt-4 alert alert-success alert-dismissible text-center");

    });
    
  
  // 
//  $(document).on('click', "a[data-role=update]", function(){
//      alert($(this).data('id'));
//      var id = $(this).data("id");
//        
//  });
  
   $(document).on('click', "a[data-role=update]", function(){
      var cart_id = $(this).data("id");
      console.log(cart_id);
      $.ajax({
        type:"POST",
        url: "./includes/order-details.inc.php",
        data: {cart_id: cart_id},
        success: function(data) {   
            console.log(data);
        }
      });   
  });
  

  
  
});