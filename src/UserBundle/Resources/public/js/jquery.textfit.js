/**
 * jQuery Text Fit v1.0
 * https://github.com/nbrunt/TextFit
 *
 * Copyright 2013 Nick Brunt
 * http://nickbrunt.com
 *
 * Free to use and abuse under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */

(function ($) {



    $.fn.textfit = function () {
        if (this.length > 1) {
            this.each(function () {
                $(this).textfit();
            });
            return;
        }


        var fs = parseInt(this.css("font-size"), 10);

        // Wrap the content of the target element in a div with
        // with the same width
        var i = innerWrap(this);

        // Keep reducing the font size of the target element
        // until the inner div fits
        while (i.height() > this.height()) {
            this.css("font-size", --fs + "px");
        }

        removeWrap(i);
        return this;


    };


    // Helper methods

    var innerWrap = function (el) {
        // Wrap the content of the target element in a div with
        // with the same width
        el.wrapInner($("<div id='textfit-inner'></div>")
            .css("width", el.css("width")));
        return $("#textfit-inner");
    };

    var removeWrap = function (el) {
        el.replaceWith(el.contents());
    };

})(jQuery);
