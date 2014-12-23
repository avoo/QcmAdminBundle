(function($) {
    var addClose = function() {
        return '<button type="button" class="close" data-dismiss="alert">' +
        '<span aria-hidden="true">&times;</span>' +
        '<span class="sr-only">Close</span>' +
        '</button>';
    };

    var bindShow = function() {
        $('#answers_form').find('button.close').click(function() {
            $('#add-answer').show();
        });
    };

    $.initAnswer = function (answersMax, strict) {
        $('#add-answer').click(function() {
            var answerCount = $('#answers_form button').length;

            if (answerCount + 1 == answersMax && strict == 1) {
                $('#add-answer').hide();
            }

            var answerList = $('#question_form');
            var newWidget = answerList.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, answerCount);

            var newAnswer = $('<div class="alert alert-danger" role="alert"></div>').html(addClose() + newWidget);
            bindShow();

            newAnswer.appendTo($('#answers_form'));

            return false;
        });

        bindShow();

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
