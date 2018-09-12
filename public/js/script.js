$("form[name='form']").submit(function(event){
    event.preventDefault();
    submitForm();
});

function submitForm(){
    $( "#warn" ).fadeOut();
    $( "#message" ).fadeOut();
    val = !$.isNumeric($("#form_sekValue").val().replace(',','.'));
    if(val === true){
        $( "#warn" ).html('Use value only').fadeIn();
    }else{
        $( "#message" ).text('Wait a moment ...').fadeIn();
        var currency = 'sek';
        $.ajax({
            type: "POST",
            url: "/api/" + currency,
            data: "",
            success : function(text){
                formSuccess(text);
            }
        });
    }
}
function round(value, decimals) {

    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function formSuccess(pln){
    if(pln == 'error'){
        $( "#warn" ).html('System error - connection problem').fadeIn();
    }else {
        sekVal = $("#form_sekValue").val().replace(',','.');
        plnVal = round(pln*sekVal,2);
        text = sekVal + " SEK is " + plnVal + " PLN";
        $( "#message" ).text(text);
        $( "#message" ).fadeIn();
    }
}
