$("form[name='form']").submit(function(event){
    event.preventDefault();
    submitForm();
});

function submitForm(){
    $( "#warn" ).fadeOut();
    $( "#message" ).fadeOut();
    sekVal = $("#form_sekValue").val().replace(',','.');
    val = !$.isNumeric(sekVal);
    if(val === true){
        $( "#warn" ).html('Use value only').fadeIn();
    }else{
        $( "#message" ).text('Wait a moment ...').fadeIn();
        var currency = 'sek';
        var amount = sekVal;
        $.ajax({
            type: "POST",
            url: "/api/" + currency + "/" + amount,
            data: "",
            success : function(text){
                formSuccess(text);
            }
        });
    }
}

function formSuccess(plnVal){
    if(plnVal == 'error'){
        $( "#warn" ).html('System error - connection problem').fadeIn();
    }else {
        sekVal = $("#form_sekValue").val().replace(',','.');
        text = sekVal + " SEK is " + plnVal + " PLN";

        $( "#message" ).text(text);
        $( "#message" ).fadeIn();
    }
}
