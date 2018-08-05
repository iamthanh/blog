$(document).ready(function() {
    (()=>{
        class Header {
            constructor() {
                this.topNav = $('.top-nav');
                this.searchInputTrigger = $('.nav-item[data-item="search"]', this.topNav);
                this.searchInputForm = $('form.search-input', this.topNav);
            }
            submitSearch() {
                let searchValue = this.getSearchFormInputValue();
                if (!searchValue) return;

                window.location = '/search/'+encodeURIComponent(searchValue);
            }
            isSearchFormOpen() {
                return $(this.topNav).hasClass('search-input-on');
            }
            getSearchFormInputValue() {
                return $('input', this.searchInputForm).val();
            }
            setupListeners() {
                this.searchInputTrigger.on('click', function() {
                    // Check if there's anything in the input, if so, submit that search
                    // otherwise, close the search input
                    if ($('input', self.header.searchInputForm).val().length && self.header.isSearchFormOpen()) {
                        self.header.submitSearch();
                    } else {
                        $(self.header.topNav).toggleClass('search-input-on');
                        if (self.header.isSearchFormOpen()) {
                            $('input', self.header.searchInputForm).focus();
                        }
                    }
                });

                this.searchInputForm.submit(function(e) {
                    e.preventDefault();
                    self.header.submitSearch();
                });

                window.onclick = function(e) {
                    if (e.target !== $('i', self.header.searchInputTrigger)[0] && e.target !== $('input', self.header.searchInputForm)[0]) {
                        $(self.header.topNav).removeClass('search-input-on');
                    }
                }
            }
            init() {
                this.setupListeners();
            }
        }

        window.header =  new Header();
        window.header.init();
    })();
});