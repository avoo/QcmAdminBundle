(function($) {
    $.initAnswer = function () {
        $('#add-answer').click(function() {
            var answerCount = $('#answers_form button').length;
            var answerList = $('#question_form');
            var newWidget = answerList.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, answerCount);

            var newAnswer = $('<div class="alert alert-danger" role="alert"></div>').html(addClose() + newWidget);
            newAnswer.appendTo($('#answers_form'));

            return false;
        });

        var addClose = function() {
            return '<button type="button" class="close" data-dismiss="alert">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>';
        };

        var checkbox = $('#answers_form input[type="checkbox"]');

        checkbox.click(function() {
            if ($(this).is(':checked')) {
                $(this).parents('.alert').removeClass('alert-danger').addClass('alert-success');
            } else {
                $(this).parents('.alert').removeClass('alert-success').addClass('alert-danger');
            }
        });

        checkbox.each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('.alert').removeClass('alert-danger').addClass('alert-success');
            }
        });
    };
})(jQuery);