(function ($) {
    'use strict';

    function playVideo($video) {
        if (!$video.length) {
            return;
        }

        var el = $video.get(0);
        el.muted = true;
        el.loop = true;
        el.playsInline = true;

        var playPromise = el.play();
        if (playPromise && typeof playPromise.catch === 'function') {
            playPromise.catch(function () {});
        }
    }

    function pauseAllVideos($slides) {
        $slides.find('video').each(function () {
            this.pause();
            this.currentTime = 0;
        });
    }

    function ProductGallery($slider) {
        this.$slider = $slider;
        this.$track = $('#productGalleryTrack');
        this.$slides = this.$track.find('.product-gallery-slide');
        this.$thumbs = $('.product-thumb');
        this.count = this.$slides.length;
        this.index = 0;
        this.isDragging = false;
        this.startX = 0;
        this.dragDelta = 0;
        this.swipeThreshold = 50;

        this._onPointerDown = this._onPointerDown.bind(this);
        this._onPointerMove = this._onPointerMove.bind(this);
        this._onPointerUp = this._onPointerUp.bind(this);

        if (this.count <= 1) {
            this._syncActiveVideo();
            return;
        }

        this.$track.on('pointerdown', this._onPointerDown);
        window.addEventListener('pointermove', this._onPointerMove);
        window.addEventListener('pointerup', this._onPointerUp);
        window.addEventListener('pointercancel', this._onPointerUp);

        this.goTo(0, false);
    }

    ProductGallery.prototype._getOffsetPercent = function (index, dragPx) {
        var slideWidth = this.$slider.innerWidth() || 1;
        var base = -index * 100;
        var dragPercent = (dragPx / slideWidth) * 100;

        return base + dragPercent;
    };

    ProductGallery.prototype._setTransform = function (index, dragPx, animate) {
        var offset = this._getOffsetPercent(index, dragPx || 0);

        if (animate) {
            this.$track.removeClass('is-dragging');
        } else {
            this.$track.addClass('is-dragging');
        }

        this.$track.css('transform', 'translate3d(' + offset + '%, 0, 0)');
    };

    ProductGallery.prototype._syncActiveVideo = function () {
        pauseAllVideos(this.$slides);

        var $activeVideo = this.$slides.eq(this.index).find('video');
        if ($activeVideo.length) {
            playVideo($activeVideo);
        }
    };

    ProductGallery.prototype._syncThumbs = function () {
        this.$thumbs.removeClass('is-active').eq(this.index).addClass('is-active');
    };

    ProductGallery.prototype.goTo = function (index, animate) {
        if (!this.count) {
            return;
        }

        this.index = ((index % this.count) + this.count) % this.count;
        this._setTransform(this.index, 0, animate !== false);
        this._syncThumbs();
        this._syncActiveVideo();
    };

    ProductGallery.prototype.goNext = function () {
        this.goTo(this.index + 1, true);
    };

    ProductGallery.prototype.goPrev = function () {
        this.goTo(this.index - 1, true);
    };

    ProductGallery.prototype._onPointerDown = function (e) {
        if (e.button !== undefined && e.button !== 0) {
            return;
        }

        this.isDragging = true;
        this.startX = e.clientX;
        this.dragDelta = 0;
        this.$track.addClass('is-dragging');
        this.$slider.addClass('is-grabbing');
        this.$slider[0].setPointerCapture(e.pointerId);
        e.preventDefault();
    };

    ProductGallery.prototype._onPointerMove = function (e) {
        if (!this.isDragging) {
            return;
        }

        this.dragDelta = e.clientX - this.startX;
        this._setTransform(this.index, this.dragDelta, false);
        e.preventDefault();
    };

    ProductGallery.prototype._onPointerUp = function () {
        if (!this.isDragging) {
            return;
        }

        this.isDragging = false;
        this.$slider.removeClass('is-grabbing');

        if (this.dragDelta <= -this.swipeThreshold) {
            this.goNext();
        } else if (this.dragDelta >= this.swipeThreshold) {
            this.goPrev();
        } else {
            this.goTo(this.index, true);
        }

        this.dragDelta = 0;
    };

    $(function () {
        var $slider = $('#productGallerySlider');
        if (!$slider.length) {
            return;
        }

        var gallery = new ProductGallery($slider);

        $(document).on('click', '.product-thumb', function () {
            var index = $(this).data('index');
            if (typeof index === 'undefined') {
                index = $('.product-thumb').index(this);
            }
            gallery.goTo(index, true);
        });

        $('.product-gallery-prev').on('click', function () {
            gallery.goPrev();
        });

        $('.product-gallery-next').on('click', function () {
            gallery.goNext();
        });
    });
})(jQuery);
