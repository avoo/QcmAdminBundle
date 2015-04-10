(function($) {
    var addClose = function() {
        return '<button type="button" class="close" data-dismiss="alert">' +
        '<span aria-hidden="true">&times;</span>' +
        '<span class="sr-only">Close</span>' +
        '</button>';
    };

    var addPreview = function() {
        return '<button type="button" class="btn btn-default preview" data-dismiss="modal">' +
            Translator.trans('qcm_admin.button.preview') +
        '</button>';
    };

    var bindShow = function() {
        $('#answers_form').find('button.close').click(function() {
            $('#add-answer').show();
        });
    };

    var bindColor = function() {
        var checkbox = $('#answers_form input[type="checkbox"]');

        checkbox.click(function() {
            if ($(this).is(':checked')) {
                $(this).parents('.alert').removeClass('alert-danger').addClass('alert-success');
            } else {
                $(this).parents('.alert').removeClass('alert-success').addClass('alert-danger');
            }
        });
    };

    $.initAnswer = function (answersMax) {
        $('#add-answer').click(function() {
            var answerCount = $('#answers_form button').length;
            var answerList = $('#question_form');
            var newWidget = answerList.attr('data-prototype');

            if (answersMax > 0 && answerCount + 1 == answersMax) {
                $('#add-answer').hide();
            }

            while ($('#qcm_core_question_answers_' + answerCount).length > 0) {
                answerCount++;
            }

            newWidget = newWidget.replace(/__name__/g, answerCount);

            var newAnswer = $('<div class="alert alert-danger" role="alert"></div>').html(addClose() + newWidget + addPreview());

            bindShow();

            newAnswer.appendTo($('#answers_form'));
            bindColor();

            newAnswer.find('.preview').on('click', function() {
                bootbox.alert(newAnswer.find('textarea').val());
                SyntaxHighlighter.highlight();
            });

            return false;
        });

        bindShow();
        bindColor();

        $('#answers_form input[type="checkbox"]').each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('.alert').removeClass('alert-danger').addClass('alert-success');
            }
        });
    };
})(jQuery);
