(()=>{
    class Blog {
        constructor() {
            this.expandedImageModal = $('.modal.view-expanded-image');
        }

        init() {
            this.expandedImageModal.modal({
                show: false,
                keyboard: false
            });
            this.setListeners();
        };

        setListeners() {
            let self = this;
            $(document).on('click', '.single-blog img, .main-body-container img', function(e) {
                // Disabled for now
                return false;

                e.preventDefault();
                $('img', self.expandedImageModal).attr('src', '');

                let src = $(this).attr('src').replace(/1000px|500px|250px/gi, 'full');

                $('img', self.expandedImageModal).attr('src', src);
                self.expandedImageModal.modal('show');
            });
        }
    }

    window.b = new Blog();
    window.b.init();
})();