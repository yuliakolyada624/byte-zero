import { jsPagination } from "../js-pagination";
import { updateTotalResults, getCSRFToken } from "../../global-functions";

export class TransactionsIntegration {
    constructor() {
        $("#collapseFilter select").on('change', () => {
            console.log("TransactionsIntegration date filter changed");
            this.applyFilter();
        });

        $("#transactionsSearchSubmit").on('click', () => {
            this.applyFilter();
        })

        const classWrapper = this;

        $(".transactions-searches").find(".transactions-searches__orderid-input").on('change', function () {
            classWrapper.updateStyle($(this));
        })

        $(".transactions-searches").find(".component__autocomplete-input").on('change', function () {
            classWrapper.updateStyle($(this));
        })

        $(".js__transactions-filters__reset").on('click', function () {
            resetAllFilters($(this));
        });

        const _jsPagination = new jsPagination();
        _jsPagination.updatePagination(loadTransactionsPage);
    }

    updateStyle = (elem) => {
        if (elem.val() !== '') {
            elem.addClass('has-value');
        } else {
            elem.removeClass('has-value');
        }
    }

    applyFilter = () => {
        console.log("TransactionsIntegration filter");

        const formData = getFormData();

        // Make AJAX request

    };
}

function resetAllFilters(elem) {
    const tab = elem.closest('.js__transactions-filters-tab');
    const listSelect2 = tab.find('.js__select2');
    listSelect2.val(null).trigger('change');
}

function getFormData() {
    // Create a FormData object
    const formData = new FormData();

    // Append values to the FormData object
    formData.append("transaction_type", $("#transactionsFilterTransactionType").val());
    formData.append("case_type", $("#transactionsFilterCaseType").val());
    formData.append("product", $("#transactionsFilterProduct").val());
    formData.append("payment_method", $("#transactionsFilterPaymentMethod").val());

    formData.append("order_id", $("#transactionsSearchByOrderId").val());
    formData.append("search_by_pdnames", $("#transactionsFilterNames").val());

    formData.append("start_date", $("#transactionsFilterDateRange_start").val());
    formData.append("end_date", $("#transactionsFilterDateRange_end").val());

    formData.append("only_my", document.getElementById('transactionsFilterOnlyMy').checked);

    console.log("formData", formData);

    return formData;
}


