(function($) {
    var elementsBind = [
        $('#qcm_core_user_session_configuration_maxQuestions'),
        $('#qcm_core_user_session_configuration_timeout')
    ];

    $.initUserSession = function(locale) {
        $('#datetimepicker').datetimepicker({
            language: locale,
            format: 'YYYY-MM-DD H:mm'
        });

        initQuestionTime();
    };

    var initQuestionTime = function () {
        $(elementsBind).each(function(key, element) {
            element.on('change keyup', function() {
                calculate();
            });
        });

        $('form#user-session-configuration').on('submit', function() {
            var firstAlert = !$('#user-session-warning').hasClass('alert');

            if (true == firstAlert) {
                calculate();

                return false;
            }

            return true;
        })
    };

    var calculate = function() {
        var maxQuestions = $('#qcm_core_user_session_configuration_maxQuestions');
        var number = $('#qcm_core_user_session_configuration_timeout').val()/maxQuestions.val();

        number = number.toFixed(0) + '';
        var x = number.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        var total = x1 + x2;

        if (total > 60) {
            var alert = 'alert-success';
        } else if (total <= 30) {
            var alert = 'alert-danger';
        } else {
            var alert = 'alert-warning';
        }

        $('#user-session-warning').removeClass('alert-success alert-danger alert-warning');
        $('#user-session-warning').addClass('alert ' + alert).html(Translator.trans('qcm_admin.user_session.alert', {'maxQuestions': maxQuestions.val(), 'timeout': (x1 + x2)}));
    };

    $.timeoutChoice = function(id) {
        var element = $('#' + id + ' option:selected').val();

        $('#' + id + ' option').each(function() {
            var choice = $(this).val();
            if (choice != '') {
                $('.' + choice).hide();
            }
        });

        if (element != '') {
            $('.' + element).show();
        }

        $('#' + id).on('change', function() {
            var element = $(this).val();

            $('#' + id + ' option').each(function() {
                var choice = $(this).val();
                if (choice != '') {
                    $('.' + choice).hide();
                }
            });

            if (element != '') {
                $('.' + element).show();
            }
        });
    };

    var addClose = function() {
        return '<button type="button" class="close" data-dismiss="alert">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>';
    };

    var bindShow = function() {
        $('#categories_form').find('button.close').click(function() {
            $('#add-category').show();
        });
    };

    $.initCategories = function () {
        $('#add-category').click(function() {
            var answerCount = $('#categories_form button').length;
            var answerList = $('#user-session-configuration');
            var newWidget = answerList.attr('data-categories');
            newWidget = newWidget.replace(/__name__/g, answerCount);

            var newAnswer = $('<div class="alert alert-danger" role="alert"></div>').html(addClose() + newWidget);
            bindShow();

            newAnswer.appendTo($('#categories_form'));

            return false;
        });

        bindShow();
    };
})(jQuery);
