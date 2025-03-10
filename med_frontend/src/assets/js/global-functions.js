export function getCSRFToken() {
    let csrfTokenInput = document.querySelector('input[name="csrf_token"]');
    let csrfTokenMeta = document.querySelector('meta[name="csrf_token"]');
    return csrfTokenInput ? csrfTokenInput.value : csrfTokenMeta ? csrfTokenMeta.content : '';
}

export function getGlobalEnvironment() {
    let CIEnvMeta = document.querySelector('meta[name="CI_ENV"]');
    return CIEnvMeta ? CIEnvMeta.content : '';
}


// Function to calculate total results and update the #total-results element
export function updateTotalResults() {
    var totalResults = 0;

    // Check if there are any elements with the class .pagination-total
    const $paginationTotals = $('.pagination-total');
    if ($paginationTotals.length > 0) {
        // Iterate over all elements with the class .pagination-total
        $paginationTotals.each(function () {
            // Parse the text of each element as an integer and add it to the total sum
            var result = parseInt($(this).text(), 10);
            totalResults += !isNaN(result) ? result : 0; // Ensure the result is a number
        });

        // Update the #total-results element with the total sum
        $('#total-results').text(totalResults);
    }
}