$(document).ready(function () {
    $('#generate-link').on('click', function (e) {
        var dest = $('#destination').val();
        if (dest.length) {
            $.post('/generate', {'destination': dest}, function (res) {
                if (res.code) {
                    var link = window.location.protocol + '//'
                        + window.location.host + '/' + res.code; 
                    $('#result').html(
                        '<span>Your link:</span> <a href="' + link + '" target="_blank">' + link + '</a>'
                    );
                    $('#destination').val('');
                } else {
                    $('#result').text(res.error);
                }
            }, 'json');
        }
    });
});