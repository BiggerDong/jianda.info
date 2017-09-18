$(document).ready(function () {
    function formatTopic (topic) {
        return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" +
        topic.name ? topic.name : "Laravel"   +
            "</div></div></div>";
    }

    function formatTopicSelection (topic) {
        return topic.name || topic.text;
    }

    $(".js-example-placeholder-multiple").select2({
        tags: false,
        placeholder: '  话题：选择相关话题',
        minimumInputLength: 2,
        ajax: {
            url: '/api/topics',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: data
                };
            },
            cache: true
        },
        templateResult: formatTopic,
        templateSelection: formatTopicSelection,
        escapeMarkup: function (markup) { return markup; }
    });
})