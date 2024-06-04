$(document).ready(function() {

    checkPrize();

    $(document).on('click', '.check-prize-button', function(event) {
        checkPrize();
    });

    $(document).on('click', '.get-prize-button', function(event) {
        getPrize();
    });
});

function checkPrize()
{
    $.get( "/prize-check", { apiToken: apiToken, lang: $('select[name=lang]').val() }, function(data) 
    {
        message = data.statusMessage;

        if (data.statusCode === 200)
        {
            payload = JSON.parse(data.payload);
            message +=  '<br><br>Prize details:<br><br>'+
                        'Prize ID: <b>'+payload.prize.id+'</b><br>'+
                        'Prize code: <b>'+payload.prize.code+'</b><br>'+
                        'Prize name: <b>'+payload.prize.code+'</b><br>'+
                        'Prize description: <b>'+payload.prize.description+'</b><br>'+
                        'Partner id: <b>'+payload.prize.partner.id+'</b><br>'+
                        'Partner code: <b>'+payload.prize.partner.code+'</b><br>'+
                        'Partner name: <b>'+payload.prize.partner.name+'</b><br>'+
                        'Partner url: <b>'+payload.prize.partner.url+'</b><br>';
        }

        $('.message').html(message);

    }, "json");
}

function getPrize()
{
    $.get( "/prize-get", { apiToken: apiToken, lang: $('select[name=lang]').val() }, function(data) 
    {
        message = data.statusMessage;

        if (data.statusCode === 200)
        {
            payload = JSON.parse(data.payload);
            message +=  '<br><br>Prize details:<br><br>'+
                        'Prize ID: <b>'+payload.prize.id+'</b><br>'+
                        'Prize code: <b>'+payload.prize.code+'</b><br>'+
                        'Prize name: <b>'+payload.prize.code+'</b><br>'+
                        'Prize description: <b>'+payload.prize.description+'</b><br>'+
                        'Partner id: <b>'+payload.prize.partner.id+'</b><br>'+
                        'Partner code: <b>'+payload.prize.partner.code+'</b><br>'+
                        'Partner name: <b>'+payload.prize.partner.name+'</b><br>'+
                        'Partner url: <b>'+payload.prize.partner.url+'</b><br>';
        }

        $('.message').html(message);

    }, "json");
}