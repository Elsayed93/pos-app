var _____WB$wombat$assign$function_____ = function (name) {
    return (
        (self._wb_wombat &&
            self._wb_wombat.local_init &&
            self._wb_wombat.local_init(name)) ||
        self[name]
    );
};
if (!self.__WB_pmw) {
    self.__WB_pmw = function (obj) {
        this.__WB_source = obj;
        return this;
    };
}
{
    let window = _____WB$wombat$assign$function_____("window");
    let self = _____WB$wombat$assign$function_____("self");
    let document = _____WB$wombat$assign$function_____("document");
    let location = _____WB$wombat$assign$function_____("location");
    let top = _____WB$wombat$assign$function_____("top");
    let parent = _____WB$wombat$assign$function_____("parent");
    let frames = _____WB$wombat$assign$function_____("frames");
    let opener = _____WB$wombat$assign$function_____("opener");

    /*
     * Style File - jQuery plugin for styling file input elements
     *
     * Copyright (c) 2007-2008 Mika Tuupola
     *
     * Licensed under the MIT license:
     *   http://www.opensource.org/licenses/mit-license.php
     *
     * Based on work by Shaun Inman
     *   http://www.shauninman.com/archive/2007/09/10/styling_file_inputs_with_css_and_the_dom
     *
     * Revision: $Id: jquery.filestyle.js 303 2008-01-30 13:53:24Z tuupola $
     *
     */

    (function ($) {
        $.fn.filestyle = function (options) {
            /* TODO: This should not override CSS. */
            var settings = {
                width: 250,
            };

            if (options) {
                $.extend(settings, options);
            }

            return this.each(function () {
                var self = this;
                var wrapper = $("<div>").css({
                    width: settings.imagewidth + "px",
                    height: settings.imageheight + "px",
                    background: "url(" + settings.image + ") 0 0 no-repeat",
                    "background-position": "right",
                    display: "inline",
                    position: "absolute",
                    overflow: "hidden",
                });

                var filename = $('<input class="file">')
                    .addClass($(self).attr("class"))
                    .css({
                        display: "inline",
                        width: settings.width + "px",
                    });

                $(self).before(filename);
                $(self).wrap(wrapper);

                $(self).css({
                    position: "relative",
                    height: settings.imageheight + "px",
                    width: settings.width + "px",
                    display: "inline",
                    cursor: "pointer",
                    opacity: "0.0",
                });

                if ($.browser.mozilla) {
                    if (/Win/.test(navigator.platform)) {
                        $(self).css("margin-left", "-142px");
                    } else {
                        $(self).css("margin-left", "-168px");
                    }
                } else {
                    $(self).css(
                        "margin-left",
                        settings.imagewidth - settings.width + "px"
                    );
                }

                $(self).bind("change", function () {
                    filename.val($(self).val());
                });
            });
        };
    })(jQuery);
}
/*
     FILE ARCHIVED ON 04:12:31 Aug 13, 2019 AND RETRIEVED FROM THE
     INTERNET ARCHIVE ON 21:04:45 Dec 04, 2021.
     JAVASCRIPT APPENDED BY WAYBACK MACHINE, COPYRIGHT INTERNET ARCHIVE.

     ALL OTHER CONTENT MAY ALSO BE PROTECTED BY COPYRIGHT (17 U.S.C.
     SECTION 108(a)(3)).
*/
/*
playback timings (ms):
  captures_list: 225.665
  exclusion.robots: 0.077
  exclusion.robots.policy: 0.072
  RedisCDXSource: 0.578
  esindex: 0.006
  LoadShardBlock: 209.752 (3)
  PetaboxLoader3.datanode: 226.554 (4)
  CDXLines.iter: 13.446 (3)
  load_resource: 222.193
  PetaboxLoader3.resolve: 176.834
*/
