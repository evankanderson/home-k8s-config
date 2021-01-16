/**
 * Masonry layouts
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

(function ($) {

    'use strict';

    if ($().masonry) {


        /**
         * Masonry posts/products
         */

        var
            $isShop = $(document.body).is('.archive.woocommerce'),
            $list = ($isShop) ? ($('.products')) : ($('.posts')),
            $itemClass = ($isShop) ? ('.product') : ('.entry');

        $list
            .imagesLoaded(function () {

                // Processing

                $list
                    .masonry({
                        itemSelector: $itemClass,
                        percentPosition: true,
                        isOriginLeft: ('rtl' !== $('html').attr('dir'))
                    });

            });


        /**
         * Jetpack Infinite Scroll posts loading
         */

        $(document.body)
            .on('post-load', function () {

                // Processing

                $list
                    .imagesLoaded(function () {

                        // Processing

                        $list
                            .masonry('reload');

                    });

            });


    } // /masonry

})(jQuery);
