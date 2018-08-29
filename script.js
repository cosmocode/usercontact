jQuery(function () {
    if (!JSINFO.plugin.usercontact.users_namespace) {
        return;
    }
    var regex = new RegExp(JSINFO.plugin.usercontact.users_namespace + '$');

    /**
     * Create and show the overlay
     *
     * @param $link object The jQuery object of the link to the user page
     */
    function show_overlay($link) {
        if (!$link.usercontact_popup) {
            $link.usercontact_popup = dw_page.insituPopup($link, $link.usercontact_id);
            $link.usercontact_popup.addClass('usercontact_overlay');
            $link.usercontact_popup.css('visibility', 'hidden');
            $link.usercontact_popup.load(
                DOKU_BASE + 'lib/exe/ajax.php',
                {
                    call: 'plugin_usercontact',
                    name: $link.usercontact_name,
                },
                function (text, status, jqxhr) {
                    if (jqxhr.status >= 400) {
                        return;
                    }
                    $link.usercontact_popup.css('visibility', 'visible');
                }
            );
        }
        $link.usercontact_popup.show();
    }

    /**
     * Find all links to user pages
     *
     * Adds events and info to the links.
     *
     * @type {number}
     */
    var links = 0;
    jQuery('.dokuwiki a').each(function () {
        var $link = jQuery(this);
        var href = $link.attr('href');
        if (!href) return;
        var match = href.replace(/\//g, ':').match(regex);
        if (!match) return;

        $link.usercontact_name = match[1];
        $link.usercontact_id = 'usercontact_' + (links++);

        $link.mouseover(function () {
            $link.usercontact_timer = window.setTimeout(
                function () {
                    console.log($link.usercontact_name);
                    show_overlay($link);
                    $link.usercontact_timer = null;
                },
                300
            );
        });

        $link.mouseout(function () {
            if ($link.usercontact_timer) window.clearTimeout($link.usercontact_timer);
            $link.usercontact_timer = null;
        });
    });
});
