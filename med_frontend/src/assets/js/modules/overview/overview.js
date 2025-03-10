import { getCSRFToken } from "../../global-functions";

export class OverviewIntegration {
    constructor() {
        const classWrapper = this;

        $("#overviewDateRange").on('change', function() {
            const start_date = $("#overviewDateRange_start").val(); 
            const end_date = $("#overviewDateRange_end").val();

            const url = $("#overviewWidgets").data('url'); 

            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken()
                },
                method: 'POST',
                data: { start_date, end_date },
                success: function (response) {
                    $("#overviewWidgets").replaceWith(response.widgets);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
        
        classWrapper.updateTabCounters();

        $(document).on('DOMSubtreeModified', '#OverviewResentCasesTabContent', function () {
            classWrapper.updateTabCounters();
        });

    }

    updateTabCounters() {
        $('#OverviewResentCasesTabContent .tab-pane').each(function () {
            var $tabPane = $(this);
            var itemCount = $tabPane.find('span.new-item').length;
            var targetId = '#' + $tabPane.attr('id');
            var $tabButton = $('.nav-link[data-bs-target="' + targetId + '"]');

            $tabButton.find('.counter').remove();

            if (itemCount > 0) {
                $tabButton.append('<span class="counter">' + itemCount + '</span>');
            }
        });
    }
}