export class jsPagination {
    constructor() {
        
    }

    updatePagination = (parentfunction) => {
        console.log('js pager');

        $('.pagination-wrapper').each(function() {
            const $paginationNav = $(this);
            console.log('paginationNav', $paginationNav);
            console.log('data', $paginationNav.data());
        
            // Get the tab name, checking if it exists
            const tabName = $paginationNav.data('name');
        
            // Add event listeners to pagination links
            $paginationNav.find('a.page-link').on('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior
                
                console.log(this.href);

                // Check if tabName exists before calling the parent function
                if (tabName) {
                    const page = new URL(this.href).searchParams.get('page_'+tabName);
                    parentfunction(page, tabName); // Call the parent function with the page number and tab name
                } else {
                    const page = new URL(this.href).searchParams.get('page');
                    parentfunction(page); // Call the parent function with just the page number
                }
            });
        });
        
    }
}