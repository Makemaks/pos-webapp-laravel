

$( function() {
    $('.calendar').each(function(){

        jSuites.calendar(document.getElementById(this.id), {
            time:true,
            format:'YYYY-MM-DD HH24:MI:SS',
            placeholder: this.placeholder,
        });
    });
} );

document.querySelector('jsuites-calendar').addEventListener('onchange', function(e) {
    console.log('New value: ' + e.target.value);
});

