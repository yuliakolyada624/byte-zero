import { jsPagination } from "../js-pagination";
import { updateTotalResults, getCSRFToken } from "../../global-functions";

export class CasesIntegration {
    constructor() {
        $("#collapseFilter select").on('change', () => {
            console.log("CasesIntegration date filter changed");
            this.applyFilter();
        });

        $("#casesSearchSubmit").on('click', () => {
            this.applyFilter();
        })

        const classWrapper = this;

        $(".cases-searches__orderid-input").on('change', function() {
            classWrapper.updateStyle($(this));
        })

        $(".component__autocomplete-input").on('change', function() {
            classWrapper.updateStyle($(this));
        })

        $("#casesFilterDateRange").on('change', () => {
            this.applyFilter();
        });

        $(".js__cases-filters__reset").on('click', function () {
            resetAllFilters($(this));
        });

        const _jsPagination = new jsPagination();
        _jsPagination.updatePagination(loadCasesPage);
    }

    updateStyle = (elem) => {
        if (elem.val() !== '') {
            elem.addClass('has-value');
        } else {
            elem.removeClass('has-value');
        }
    }

    applyFilter = () => {
        console.log("CasesIntegration filter");

        const formData = getFormData();

        // Make AJAX request
        $.ajax({
            url: `${SITEURL}orders/cases/filter`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": getCSRFToken(),
            },
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            dataType: "json",
            success: (data) => {
                console.log(data);

                const $CasesTabContent = $("#CasesTabContent");
                $CasesTabContent.empty(); // Clear the container
                $CasesTabContent.append(data.TabContent); // Append the new HTML

                const $SectionOffcanvas = $("#SectionOffcanvas");
                $SectionOffcanvas.empty();
                $SectionOffcanvas.append(data.SectionOffcanvas);

                const _jsPagination = new jsPagination();
                _jsPagination.updatePagination(loadCasesPage);
                //$('#total-results').html(data.total);

                updateTotalResults();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error("Error:", textStatus, errorThrown);
            },
        });
    };
}

function resetAllFilters(elem) {
    const tab = elem.closest('.js__cases-filters-tab');
    const listSelect2 = tab.find('.js__select2');
    listSelect2.val(null).trigger('change');
}

function getFormData() {
    // Create a FormData object
    const formData = new FormData();

    // Append values to the FormData object
    formData.append("progress_status", $("#casesFilterStatus").val());
    formData.append("ordered_by", $("#casesFilterOrderedBy").val());
    formData.append("report_type", $("#casesFilterReportType").val());
    formData.append("assignee", $("#casesFilterAssignee").val());

    formData.append("order_id", $("#casesSearchByOrderId").val());
    formData.append("search_by_pdnames", $("#casesFilterNames").val());

    formData.append("start_date", $("#casesFilterDateRange_start").val());
    formData.append("end_date", $("#casesFilterDateRange_end").val());

    formData.append("only_my", document.getElementById('casesFilterOnlyMy').checked);

    console.log("formData", formData);

    return formData;
}

function loadCasesPage(page, tabName = false) {
    const formData = getFormData();

    console.log("page", page);

    formData.append("page_" + tabName, page);
    formData.append("tabName", tabName);

    // Make AJAX request
    $.ajax({
        url: SITEURL + `orders/cases/filter`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": getCSRFToken(),
        },
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        dataType: "json",
        success: (data) => {
            console.log(data);

            const $CasesTabContent = $("#CasesTabContent");
            $CasesTabContent.empty(); // Clear the container
            $CasesTabContent.append(data.TabContent); // Append the new HTML

            const $SectionOffcanvas = $("#SectionOffcanvas");
            $SectionOffcanvas.empty();
            $SectionOffcanvas.append(data.SectionOffcanvas);

            const _jsPagination = new jsPagination();
            _jsPagination.updatePagination(loadCasesPage);

            updateTotalResults();
            //$('#total-results').html(data.total);
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.error("Error:", textStatus, errorThrown);
        },
    });
}
