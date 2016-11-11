import $ from "jquery";
import "admin-lte/bootstrap/js/bootstrap";

import "admin-lte/dist/js/app";
import "eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css";
import "eonasdan-bootstrap-datetimepicker";
import "font-awesome/css/font-awesome.css";
import "ionicons/dist/css/ionicons.css";
import "bootstrap/dist/css/bootstrap.css";

import "fullcalendar/dist/fullcalendar.css";

import "admin-lte/dist/css/AdminLTE.css";
import "admin-lte/dist/css/skins/skin-blue.min.css";
import "fullcalendar/dist/fullcalendar";
import "./css/theme.css";

import 'summernote/dist/summernote.css';
import 'summernote';
import 'summernote/dist/lang/summernote-fr-FR';

$('.datetimepicker').datetimepicker({
    locale: 'fr'
});


$('.js-calendar').each(function () {
    var $this = $(this);


    $this.fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        //navLinks: true,
        timeFormat: 'H:mm',
        events: {
            url: $this.data('eventsAjaxEndpoint')
        },
        locale: $('html').attr('lang'),
        buttonText: {
            today: $this.data('transButtonToday'),
            month: $this.data('transButtonMonth'),
            week: $this.data('transButtonWeek'),
            day: $this.data('transButtonDay')
        },
    });

});

$('.js-wysiwyg').summernote({
    height: 400,
    lang: 'fr-FR',
    toolbar: [
        ['misc', ['undo', 'redo']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['table', 'link', 'hr']]
    ]
});
