/**
 * Global JS called on every page.
 */

jQuery(function() {

  /**
   * Wrap tables in div so they can be scrolled
   * horizontally on mobile.
   */
  (function() {
    jQuery('.main-content table').each(function() {
      jQuery(this).wrap('<div class="table-wrapper"><div class="table-wrapper__scroll"></div></div>')
    });
  }());

});
