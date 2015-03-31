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
        var alert = 'alert-warning';

        if (total > 60) {
            alert = 'alert-success';
        } else if (total <= 30) {
            alert = 'alert-danger';
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

    var bindShow = function(id) {
        $('#categories_form').find('button.close').click(function() {
            $('#add-category').show();
            $('#' + id + ' option[value="' + $(this).parents('li').data('id') + '"]').show();
        });
    };

    var hideOption = function(id) {
        $.grep($('#categories_form').find('li'), function (input) {
            $('#' + id + ' option[value="' + $(input).data('id') + '"]').hide();
        });

        $('#' + id + ' option:eq(0)').attr('selected', 'selected');
    };

    $.initCategories = function (id, categoriesId) {
        var filter = [];
        $(categoriesId).each(function(key, id) {
            filter.push('[value="' + id + '"]');
        });

        $('#categories_form').find('input[type="checkbox"]').filter(filter.join(',')).prop('checked', true);

        $('#add-category').click(function() {
            var element = $('#' + id + ' option:selected');

            if (element.val() == '') {
                return;
            }

            var answerList = $('#user-session-configuration');
            var newWidget = answerList.attr('data-categories');
            newWidget = newWidget.replace(/__name__/g, element.val());

            var name = element.text();
            var newAnswer = $('<li class="list-group-item alert" role="alert" data-id="' + element.val() + '"></li>').html(addClose() + name + newWidget);

            newAnswer.appendTo($('#categories_form'));
            bindShow(id);
            hideOption(id);

            return false;
        });

        bindShow(id);
        hideOption(id);
    };
})(jQuery);
