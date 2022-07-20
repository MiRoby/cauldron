/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

// create global $ and jQuery variables
global.$ = global.jQuery = $;


import greet from './greet';

var $container = $('.js-vote-arrows');
$container.find('a').on('click', function(e) {
    e.preventDefault();
    var $link = $(e.currentTarget);

    $.ajax({
        url: '/comments/10/vote/'+$link.data('direction'),
        method: 'POST'
    }).then(function(data) {
        $container.find('.js-vote-total').text(data.votes);
    });
});

$(document).ready(function() {
    $('body').prepend('<h1>'+greet('dupa')+'</h1>');
 });

 $(document).ready(function(){
    $('body').prepend('<p>'+greet('test')+'</p>');
 });